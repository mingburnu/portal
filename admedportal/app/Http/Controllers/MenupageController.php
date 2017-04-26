<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Language;
use App\Menupage;
use App\Menupage_i18n;
use App\Sort;
use Config;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Input;
use PDO;

class MenupageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        if (Sort::find((new Menupage())->getTable()) == null) {
            $this->sort();
        }

        $perPage = Config::get('app.pages_config');
        $totalPage = ceil(Menupage::count() / $perPage);

        $page = intval(Input::get('page'));
        if ($page <= 0) {
            $page = 1;
        } elseif ($page > $totalPage) {
            $page = $totalPage;
        }

        $offset = ($page - 1) * $perPage;

        $sort = new Sort(Sort::find((new Menupage())->getTable())->toArray());
        $mode = unserialize($sort->mode);

        $procedure = "DROP PROCEDURE `showChildLst`; " .
            "CREATE DEFINER=`root`@`localhost` PROCEDURE `showChildLst`(IN `position` INT, IN `perPage` INT) NOT " .
            "DETERMINISTIC NO SQL SQL SECURITY DEFINER BEGIN DECLARE done INT DEFAULT 0; DECLARE b INT; " .
            "DECLARE cur1 CURSOR FOR SELECT id FROM pages where parent_id IS NULL " .
            "ORDER BY " . $mode['field'] . " " . $mode['direction'] . "; DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1; " .
            "CREATE TEMPORARY TABLE IF NOT EXISTS tmpLst (sno int primary key auto_increment,id int,depth int); " .
            "DELETE FROM tmpLst; SET max_sp_recursion_depth = 255; OPEN cur1; FETCH cur1 INTO b; " .
            "WHILE done=0 DO CALL createChildLst(b,0); FETCH cur1 INTO b; END " .
            "WHILE; CLOSE cur1; select tmpLst.*,pages.title,pages.view, pages.rank_id, pages.created_at, pages.updated_at from tmpLst,pages " .
            "where tmpLst.id=pages.id order by tmpLst.sno limit position , perPage; END";

        $sql = 'CALL showChildLst(' . $offset . ',' . $perPage . ')';
        $pdo = new PDO("mysql:host=" . DB::getConfig('host') . ";dbname=" . DB::getDatabaseName(),
            DB::getConfig('username'), DB::getConfig('password'));
        $pdo->query($procedure);
        $menus = $pdo->query($sql)->fetchAll();

        $table = new LengthAwarePaginator($menus, Menupage::count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]);

        return view('menupage_index')->with('table', $table)->with('direction', $mode['direction']);
    }

    public function sort()
    {
        $option = array('asc', 'desc');
        $data = Sort::find((new Menupage())->getTable());
        $field = 'rank_id';
        $sort = new Sort();
        if ($data == null) {
            $sort->item = (new Menupage())->getTable();
            $sort->mode = serialize(
                [
                    'field' => $field,
                    'direction' => $option[0]
                ]
            );
        } else {
            $sort = new Sort($data->toArray());
            $mode = unserialize($sort->mode);

            $direction = $option[0];
            if ($mode['direction'] == $option[0]) {
                $direction = $option[1];
            } else if ($mode['direction'] == $option[1]) {
                $direction = $option[0];
            }

            $sort->mode = serialize([
                'field' => $field,
                'direction' => $direction
            ]);
        }

        Sort::updateOrCreate([$sort->getKeyName() => $sort->item], $sort->toArray());

        return redirect(route('menupage.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        $top = array('' => '不設定(單一網頁)');
        $titles = Menupage::where('parent_id', '=', null)->lists('title', 'id')->toArray();
        $select = $top + $titles;
        $languages = Language::all();
        return view('menupage_create')->with('languages', $languages)->with('select', $select);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
        $type = (boolean)Input::get('type');
        $ids = Menupage::select('id')->where('parent_id', '=', null)->lists('id')->toArray();

        $languages = Language::where('id', '>', 0)->get();
        if ($type) {
            $rules = array(
                'title' => 'required',
                'content' => 'required',
                'parent_id' => 'in:' . implode(',', $ids)
            );

            $messages = array(
                'title.required' => '<p>．請輸入項目名稱。</p>',
                'content.required' => '<p>．請輸入繁體中文的網頁內容。</p>',
                'parent_id.in' => '<p>．位置不正確</p>'
            );
        } else {
            $rules = array(
                'title' => 'required',
                'url' => 'required|regex:/^http([s]?):\/\/.*/',
                'parent_id' => 'in:' . implode(',', $ids)
            );

            $messages = array(
                'title.required' => '<p>．請輸入項目名稱。</p>',
                'url.required' => '<p>．請輸入繁體中文的網頁連結。</p>',
                'url.regex' => '<p>．繁體中文的網頁連結格式必須為網址(含http://)。</p>',
                'parent_id.in' => '<p>．位置不正確</p>'
            );

            foreach ($languages as $language) {
                $rules = $rules + array('menupage_i18ns.' . $language->id . '.url' => 'regex:/^http([s]?):\/\/.*/');
                $messages = $messages + array('menupage_i18ns.' . $language->id . '.url.regex' => '<p>．' . $language->language . '的網頁連結格式必須為網址(含http://)。</p>');
            }
        }

        $this->validate($request, $rules, $messages);

        //    Log::info('data ------------------ ' . dump($paper));

        $i18ns = Input::get('menupage_i18ns');

        Input::merge(array(
            'type' => boolval(Input::get('type')),
            'view' => boolval(Input::get('view')),
            'menupage_i18ns' => null
        ));
        Input::merge(array_map('trim', Input::all()));

        $menupage = new Menupage(Input::all());

        if ($menupage->parent_id == "") {
            $menupage->parent_id = null;
        }

        if ($menupage->type) {
            $menupage->url = "";
        } else {
            $menupage->content = "";
        }

        $menupage->save();

        $menupage_i18ns = array();
        for ($i = 0; $i < sizeof($languages); $i++) {
            $lid = $languages[$i]->id;
            $i18n = new Menupage_i18n();
            $i18n->language = $lid;
            $i18n->menupage()->associate($menupage);

            if (!empty($i18ns[$lid])) {
                $i18n = new Menupage_i18n($i18n->toArray() + array_map('trim', $i18ns[$lid]));
            }

            if ($type) {
                $i18n->url = "";
            } else {
                $i18n->content = "";
            }

            $menupage_i18ns[] = $i18n;
            $menupage->menupage_i18ns()->saveMany($menupage_i18ns);
        }

        return redirect()->route('menupage.index')
            ->with('success', '新增資料成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //TODO
        return view('errors.404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
        if (Menupage::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $paper = Menupage::find($id);

        $top = array('' => '不設定(單一網頁)');
        $select = $top;

        if (Menupage::whereParentId($id)->count() == 0) {
            $titles = Menupage::where('parent_id', '=', null)->where('id', '!=', $id)->lists('title', 'id')->toArray();
            $select = $top + $titles;
        }

        $languages = Language::all();
        return view('menupage_edit')->with('paper', $paper)->with('languages', $languages)->with('select', $select);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
        if (Menupage::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $languages = Language::where('id', '>', 0)->get();

        $type = (boolean)Input::get('type');

        if ($type) {
            $rules = array(
                'title' => 'required',
                'content' => 'required',
                'parent_id' => 'node'
            );

            $messages = array(
                'title.required' => '<p>．請輸入項目名稱。</p>',
                'content.required' => '<p>．請輸入繁體中文的網頁內容。</p>',
                'parent_id.node' => '<p>．位置不正確</p>'
            );
        } else {
            $rules = array(
                'title' => 'required',
                'url' => 'required|regex:/^http([s]?):\/\/.*/',
                'parent_id' => 'node'
            );

            $messages = array(
                'title.required' => '<p>．請輸入項目名稱。</p>',
                'url.required' => '<p>．請輸入繁體中文的網頁連結。</p>',
                'url.regex' => '<p>．繁體中文的網頁連結格式必須為網址(含http://)。</p>',
                'parent_id.node' => '<p>．位置不正確</p>'
            );

            foreach ($languages as $language) {
                $rules = $rules + array('menupage_i18ns.' . $language->id . '.url' => 'regex:/^http([s]?):\/\/.*/');
                $messages = $messages + array('menupage_i18ns.' . $language->id . '.url.regex' => '<p>．' . $language->language . '的網頁連結格式必須為網址(含http://)。</p>');
            }
        }

        $this->validate($request, $rules, $messages);

        $i18ns = Input::get('menupage_i18ns');

        Input::merge(array(
            'type' => boolval(Input::get('type')),
            'view' => boolval(Input::get('view')),
            'menupage_i18ns' => null
        ));
        Input::merge(array_map('trim', Input::all()));

        $menupage = new Menupage(Input::all());

        if ($menupage->parent_id == "") {
            $menupage->parent_id = null;
        }

        if ($menupage->type) {
            $menupage->url = "";
        } else {
            $menupage->content = "";
        }

        Menupage::whereId($id)->update($menupage->toArray());

        for ($i = 0; $i < sizeof($languages); $i++) {
            $lid = $languages[$i]->id;
            $i18n = new Menupage_i18n();
            $i18n->page_id = $id;
            $i18n->language = $lid;

            if (!empty($i18ns[$lid])) {
                $i18n = new Menupage_i18n($i18n->toArray() + array_map('trim', $i18ns[$lid]));
            }

            if ($type) {
                $i18n->url = "";
            } else {
                $i18n->content = "";
            }

            if (Menupage_i18n::wherePageId($id)->whereLanguage($lid)->exists()) {
                Menupage_i18n::wherePageId($id)->whereLanguage($lid)->update($i18n->toArray());
            } else {
                $i18n->save();
            }
        }

        return redirect()->route('menupage.index')
            ->with('success', '更新資料成功');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        if (Menupage::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $children = Menupage::whereParentId($id)->get();
        foreach ($children as $child) {
            Menupage_i18n::wherePageId($child->id)->delete();
        }

        Menupage_i18n::wherePageId($id)->delete();
        Menupage::whereParentId($id)->delete();
        Menupage::whereId($id)->delete();

        return redirect()->route('menupage.index')
            ->with('success', '刪除資料成功');
    }
}
