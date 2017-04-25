<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Banner_i18n;
use App\Http\Requests;
use App\Language;
use App\Sort;
use Config;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Image;
use Input;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        if (Sort::find((new Banner())->getTable()) == null) {
            $this->sort();
        }

        $sort = new Sort(Sort::find((new Banner())->getTable())->toArray());
        $mode = unserialize($sort->mode);

        $perPage = Config::get('app.pages_config');
        $totalPage = ceil(Banner::count() / $perPage);

        $page = intval(Input::get('page'));
        if ($page <= 0) {
            $page = 1;
        } elseif ($page > $totalPage) {
            $page = $totalPage;
        }
        Input::merge(['page' => $page]);

        $table = Banner::orderBy($mode['field'], $mode['direction'])
            ->paginate(\Config::get('app.pages_config'));

        return view('banner_index')->with('table', $table)->with('direction', $mode['direction']);
    }

    public function sort()
    {
        $option = array('asc', 'desc');
        $data = Sort::find((new Banner())->getTable());
        $field = 'rank_id';
        $sort = new Sort();
        if ($data == null) {
            $sort->item = (new Banner())->getTable();
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

        return $this->index();
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
        return view('banner_create')->with('languages', $languages);
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
        $rules = null;
        $messages = null;
        $upload_option = (boolean)Input::get('upload_option');
        if ($upload_option) {
            $rules = array(
                'title' => 'required',
                'url' => 'regex:/^http([s]?):\/\/.*/',
                'upload_file' => 'required|mimes:png,jpeg,gif'
            );

            $messages = array(
                'title.required' => '<p>．請輸入Banner標題。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'upload_file.required' => '<p>．請上傳Banner圖片。</p>',
                'upload_file.mimes' => '<p>．請上傳正確格式圖片。</p>'
            );
        } else {
            $rules = array(
                'title' => 'required',
                'url' => 'regex:/^http([s]?):\/\/.*/',
                'img' => 'required|regex:/^http([s]?):\/\/.*/'
            );

            $messages = array(
                'title.required' => '<p>．請輸入Banner標題。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'img.required' => '<p>．請輸入圖檔網址。</p>',
                'img.regex' => '<p>．圖檔網址格式必須為網址(含http://)。</p>'
            );
        }

        $this->validate($request, $rules, $messages);

        $img = null;
        if (Input::hasFile('upload_file')) {

            $imageName = Input::file('upload_file');

            $imageName = time() . "-" . $imageName->getClientOriginalName();

            Input::file('upload_file')->move(
                base_path() . '/public/banners/', $imageName
            );

            // width 固定

            $width = Image::make(base_path() . '/public/banners/' . $imageName)->width();

            $height = Image::make(base_path() . '/public/banners/' . $imageName)->height();

            $new_height = \Config::get('app.banners_image_width') * $height / $width;

//                Log::info('height - ' . $height . ', width - ' . $width . ", new_height " . $new_height);

            Image::make(base_path() . '/public/banners/' . $imageName)
                ->resize(\Config::get('app.banners_image_width'), $new_height)
                ->save(public_path('banners/' . $imageName));


            $img = "banners/$imageName";

        } else {
            $img = Input::get('img');
        }

        $languages = Language::where('id', '>', 0)->get();
        $i18ns = Input::get('banner_i18ns');

        Input::merge(array(
            'play' => boolval(Input::get('play')),
            'upload_option' => boolval(Input::get('upload_option')),
            'view' => boolval(Input::get('view')),
            'img' => $img,
            'banner_i18ns' => null
        ));
        Input::merge(array_map('trim', Input::all()));

        $banner = new Banner(Input::all());
        $banner->save();

        $banner_i18ns = array();
        for ($i = 0; $i < sizeof($languages); $i++) {
            $lid = $languages[$i]->id;
            $i18n = new Banner_i18n();
            $i18n->language = $lid;
            $i18n->banner()->associate($banner);

            if (!empty($i18ns[$lid])) {
                $i18n = new Banner_i18n($i18n->toArray() + array_map('trim', $i18ns[$lid]));
            }

            $banner_i18ns[] = $i18n;
        }

        $banner->banner_i18ns()->saveMany($banner_i18ns);

        return redirect()->route('banner.index')
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
        if (Banner::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $banner = new Banner(Banner::find($id)->toArray());
        $languages = Language::all();
        return view('banner_edit')->with('banner', $banner)->with('languages', $languages);
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
        if (Banner::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $banner = new Banner(Banner::find($id)->toArray());
        $db_upload_option = (boolean)$banner->upload_option;
        $upload_option = (boolean)Input::get('upload_option');

        $rules = null;
        $messages = null;
        if ($db_upload_option && $upload_option) {
            $rules = array(
                'title' => 'required',
                'url' => 'regex:/^http([s]?):\/\/.*/',
                'upload_file' => 'mimes:png,jpeg,gif'
            );

            $messages = array(
                'title.required' => '<p>．請輸入Banner標題。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'upload_file.mimes' => '<p>．請上傳正確格式圖片。</p>'
            );
        } elseif ($db_upload_option && !$upload_option) {
            $rules = array(
                'title' => 'required',
                'url' => 'regex:/^http([s]?):\/\/.*/',
                'img' => 'required|regex:/^http([s]?):\/\/.*/'
            );

            $messages = array(
                'title.required' => '<p>．請輸入Banner標題。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'img.required' => '<p>．請輸入圖檔網址。</p>',
                'img.regex' => '<p>．圖檔網址格式必須為網址(含http://)。</p>'
            );
        } elseif (!$db_upload_option && $upload_option) {
            $rules = array(
                'title' => 'required',
                'url' => 'regex:/^http([s]?):\/\/.*/',
                'upload_file' => 'required|mimes:png,jpeg,gif'
            );

            $messages = array(
                'title.required' => '<p>．請輸入Banner標題。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'upload_file.required' => '<p>．請上傳Banner圖片。</p>',
                'upload_file.mimes' => '<p>．請上傳正確格式圖片。</p>'
            );
        } else {
            $rules = array(
                'title' => 'required',
                'url' => 'regex:/^http([s]?):\/\/.*/',
                'img' => 'required|regex:/^http([s]?):\/\/.*/'
            );

            $messages = array(
                'title.required' => '<p>．請輸入Banner標題。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'img.required' => '<p>．請輸入圖檔網址。</p>',
                'img.regex' => '<p>．圖檔網址格式必須為網址(含http://)。</p>'
            );
        }

        $this->validate($request, $rules, $messages);

        $img = $banner->img;
        if ($db_upload_option && $upload_option) {
            if (Input::hasFile('upload_file')) {

                $imageName = Input::file('upload_file');

                $imageName = time() . "-" . $imageName->getClientOriginalName();

                Input::file('upload_file')->move(
                    base_path() . '/public/banners/', $imageName
                );

                // width 固定

                $width = Image::make(base_path() . '/public/banners/' . $imageName)->width();

                $height = Image::make(base_path() . '/public/banners/' . $imageName)->height();

                $new_height = \Config::get('app.banners_image_width') * $height / $width;

//                Log::info('height - ' . $height . ', width - ' . $width . ", new_height " . $new_height);

                Image::make(base_path() . '/public/banners/' . $imageName)
                    ->resize(\Config::get('app.banners_image_width'), $new_height)
                    ->save(public_path('banners/' . $imageName));

                $img = "banners/$imageName";

                // 需要刪除舊有 image 檔案

                File::delete(\Config::get('app.banners_image_folder') . $banner->img);
            } else {
                // $img = $banner->img;
            }

        } elseif ($db_upload_option && !$upload_option) {

            $img = Input::get('img');

            // 需要刪除舊有 image 檔案

            File::delete(\Config::get('app.banners_image_folder') . $banner->img);

        } elseif (!$db_upload_option && $upload_option) {

            $imageName = Input::file('upload_file');

            $imageName = time() . "-" . $imageName->getClientOriginalName();

            Input::file('upload_file')->move(
                base_path() . '/public/banners/', $imageName
            );

            // width 固定

            $width = Image::make(base_path() . '/public/banners/' . $imageName)->width();

            $height = Image::make(base_path() . '/public/banners/' . $imageName)->height();

            $new_height = \Config::get('app.banners_image_width') * $height / $width;

//                Log::info('height - ' . $height . ', width - ' . $width . ", new_height " . $new_height);

            Image::make(base_path() . '/public/banners/' . $imageName)
                ->resize(\Config::get('app.banners_image_width'), $new_height)
                ->save(public_path('banners/' . $imageName));


            $img = "banners/$imageName";

        } else {
            $img = Input::get('img');
        }

        $languages = Language::where('id', '>', 0)->get();
        $i18ns = Input::get('banner_i18ns');

        Input::merge(array(
            'play' => boolval(Input::get('play')),
            'upload_option' => boolval(Input::get('upload_option')),
            'view' => boolval(Input::get('view')),
            'img' => $img,
            'banner_i18ns' => null
        ));
        Input::merge(array_map('trim', Input::all()));

        $banner->fill(Input::all());
        Banner::whereId($id)->update($banner->toArray());

        for ($i = 0; $i < sizeof($languages); $i++) {
            $lid = $languages[$i]->id;
            $i18n = new Banner_i18n();
            $i18n->banner_id = $id;
            $i18n->language = $lid;

            if (!empty($i18ns[$lid])) {
                $i18n = new Banner_i18n($i18n->toArray() + array_map('trim', $i18ns[$lid]));
            }

            if (Banner_i18n::whereBannerId($id)->whereLanguage($lid)->exists()) {
                Banner_i18n::whereBannerId($id)->whereLanguage($lid)->update($i18n->toArray());
            } else {
                $i18n->save();
            }
        }

        return redirect()->route('banner.index')
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
        if (Banner::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $banner = new Banner(Banner::find($id)->toArray());
        File::delete(\Config::get('app.banners_image_folder') . $banner->img);

        Banner_i18n::whereBannerId($id)->delete();
        Banner::whereId($id)->delete();

        return redirect()->route('banner.index')->with('success', '刪除資料成功');
    }
}
