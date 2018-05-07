<?php

namespace App\Http\Controllers;

use App\Db;
use App\Db_i18n;
use App\Language;
use App\Sort;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Input;

class DbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        if (Sort::find((new Db())->getTable()) == null) {
            $this->sort();
        }

        $sort = new Sort(Sort::find((new Db())->getTable())->toArray());
        $mode = unserialize($sort->mode);

        $perPage = \Config::get('app.pages_config');
        $totalPage = ceil(Db::count() / $perPage);

        $page = intval(Input::get('page'));
        if ($page <= 0) {
            $page = 1;
        } elseif ($page > $totalPage) {
            $page = $totalPage;
        }
        Input::merge(['page' => $page]);

        $table = Db::orderBy($mode['field'], $mode['direction'])
            ->paginate(\Config::get('app.pages_config'));

        return view('db_index')->with('table', $table)->with('direction', $mode['direction']);

    }

    public function sort()
    {
        $option = array('asc', 'desc');
        $data = Sort::find((new Db())->getTable());
        $field = 'rank_id';
        $sort = new Sort();
        if ($data == null) {
            $sort->item = (new Db())->getTable();
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

        return redirect(route('db.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        $languages = Language::all();
        return view('db_create')->with('languages', $languages);
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
        $rules = array(
            'database_name' => 'required',
            'syntax' => 'required'
        );

        $first_language = Language::first()->language;
        $this->validate($request, $rules, [], [
            'database_name' => $first_language . '-' . \Lang::get('ui database name'),
            'syntax' => $first_language . '-' . \Lang::get('ui.embedded html')
        ]);

        //   Log::info('data --------------------- ' . dump($input_data));

        $languages = Language::where('id', '>', 0)->get();
        $i18ns = Input::get('db_i18ns');

        Input::merge(array(
            'view' => boolval(Input::get('view')),
            'db_i18ns' => null
        ));
        Input::merge(array_map('trim', Input::all()));

        $db = new Db(Input::all());
        $db->save();

        $db_i18ns = array();
        for ($i = 0; $i < sizeof($languages); $i++) {
            $lid = $languages[$i]->id;
            $i18n = new Db_i18n();
            $i18n->language = $lid;
            $i18n->db()->associate($db);

            if (!empty($i18ns[$lid])) {
                $i18n = new Db_i18n($i18n->toArray() + array_map('trim', $i18ns[$lid]));
            }

            $db_i18ns[] = $i18n;
        }

        $db->db_i18ns()->saveMany($db_i18ns);

        return redirect()->route('db.index')
            ->with('successes', [\Lang::get('msg.insert data successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public
    function show($id)
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
    public
    function edit($id)
    {
        //
        if (Db::where('id', '=', $id)->count() == 0) {
            return view('errors.404');
        }

        $querydatabase = Db::where('id', '=', $id)->get();
        $querydatabase_i18n = Db_i18n::where('db_id', '=', $id)->get();
        $languages = Language::all();

        return view('db_edit')->with('querydatabase', $querydatabase)->with('querydatabase_i18n', $querydatabase_i18n)->with('languages', $languages);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public
    function update(Request $request, $id)
    {
        //
        if (Db::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $rules = array(
            'database_name' => 'required',
            'syntax' => 'required'
        );

        $first_language = Language::first()->language;
        $this->validate($request, $rules, [], [
            'database_name' => $first_language . '-' . \Lang::get('ui database name'),
            'syntax' => $first_language . '-' . \Lang::get('ui.embedded html')
        ]);

        //   Log::info('data --------------------- ' . dump($input_data));

        //   exit;

        $languages = Language::where('id', '>', 0)->get();
        $i18ns = Input::get('db_i18ns');

        Input::merge(array(
            'view' => boolval(Input::get('view')),
            'db_i18ns' => null
        ));
        Input::merge(array_map('trim', Input::all()));

        $db = new Db(Input::all());
        Db::whereId($id)->update($db->toArray());

        for ($i = 0; $i < sizeof($languages); $i++) {
            $lid = $languages[$i]->id;
            $i18n = new Db_i18n();
            $i18n->db_id = $id;
            $i18n->language = $lid;

            if (!empty($i18ns[$lid])) {
                $i18n = new Db_i18n($i18n->toArray() + array_map('trim', $i18ns[$lid]));
            }

            if (Db_i18n::whereDbId($id)->whereLanguage($lid)->exists()) {
                Db_i18n::whereDbId($id)->whereLanguage($lid)->update($i18n->toArray());
            } else {
                $i18n->save();
            }
        }

        return redirect()->route('db.index')
            ->with('successes', [\Lang::get('msg.modify data successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public
    function destroy($id)
    {
        //
        if (Db::where('id', '=', $id)->count() == 0) {
            return view('errors.404');
        }

        Db_i18n::whereDbId($id)->delete();
        Db::whereId($id)->delete();

        return redirect()->route('db.index')
            ->with('successes', [\Lang::get('msg.delete data successfully')]);
    }
}
