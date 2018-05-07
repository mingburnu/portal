<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Ad_i18n;
use App\Language;
use Config;
use File;
use Illuminate\Http\Request;
use Image;
use Input;
use Response;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $perPage = Config::get('app.pages_config');
        $totalPage = ceil(Ad::count() / $perPage);

        $page = intval(Input::get('page'));
        if ($page <= 0) {
            $page = 1;
        } elseif ($page > $totalPage) {
            $page = $totalPage;
        }
        Input::merge(['page' => $page]);

        $table = Ad::orderBy('publish_time', 'desc')
            ->paginate(Config::get('app.pages_config'));

        return view('ad_index')->with('table', $table);
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
        $hours = array();
        $minuteSeconds = array();
        for ($i = 0; $i < 60; $i++) {
            $num = sprintf("%02d", $i);
            if ($i < 24) {
                $hours[$num] = $num;
            }

            $minuteSeconds[$num] = $num;
        }
        return view('ad_create')->with('hours', $hours)->with('minuteSeconds', $minuteSeconds)->with('languages', $languages);
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
        $upload_option = (boolean)Input::get('upload_option');
        if ($upload_option) {
            $rules = array(
                'title' => 'required',
                'url' => 'url|regex:/^http([s]?):\/\/.*/',
                'upload_file' => 'required|max:1024|image',
                'publish_day' => 'required|date_format:"Y-m-d"|after:1970-01-01|before:2500-01-01',
                'publish_hh' => 'required|date_format:"H"',
                'publish_ii' => 'required|date_format:"i"',
                'publish_ss' => 'required|date_format:"s"'
            );
        } else {
            $rules = array(
                'title' => 'required',
                'url' => 'url|regex:/^http([s]?):\/\/.*/',
                'img' => 'required|url|regex:/^http([s]?):\/\/.*/',
                'publish_day' => 'required|date_format:"Y-m-d"|after:1970-01-01|before:2500-01-01',
                'publish_hh' => 'required|date_format:"H"',
                'publish_ii' => 'required|date_format:"i"',
                'publish_ss' => 'required|date_format:"s"'
            );
        }

        $this->validate($request, $rules, [], [
            'title' => Language::first()->language . '-' . \Lang::get('ui.ad title'),
            'url' => \Lang::get('ui.link'),
            'upload_file' => \Lang::get('ui.ad image')
        ]);

        Input::merge(array(
            'publish_time' => Input::get('publish_day') . " " . Input::get('publish_hh') . ":" . Input::get('publish_ii') . ":" . Input::get('publish_ss'),
        ));

        $forever = boolval(Input::get('forever'));
        if (!$forever) {
            $rules = array(
                'end_day' => 'required|date_format:"Y-m-d"|after:1970-01-01|before:2500-01-01',
                'end_hh' => 'required|date_format:"H"',
                'end_ii' => 'required|date_format:"i"',
                'end_ss' => 'required|date_format:"s"'
            );

            $this->validate($request, $rules);

            Input::merge(array(
                'end_time' => Input::get('end_day') . " " . Input::get('end_hh') . ":" . Input::get('end_ii') . ":" . Input::get('end_ss'),
            ));

            $rules = array(
                'end_time' => 'after:publish_time'
            );

            $this->validate($request, $rules);
        }

        $img = null;
        if (Input::hasFile('upload_file')) {

            $imageName = Input::file('upload_file');

            $imageName = time() . "-" . $imageName->getClientOriginalName();

            Input::file('upload_file')->move(
                public_path('ads/'), $imageName
            );

            $img = "ads/$imageName";
            $path = public_path($img);

            $width = Image::make($path)->width();
            $height = Image::make($path)->height();
            $new_height = \Config::get('app.ads_image_width') * $height / $width;

            Image::make($path)
                ->resize(\Config::get('app.ads_image_width'), $new_height)
                ->save($path);

        } else {
            $img = Input::get('img');
        }

        $languages = Language::where('id', '>', 0)->get();
        $i18ns = Input::get('ad_i18ns');

        Input::merge(array(
            'upload_option' => boolval(Input::get('upload_option')),
            'view' => boolval(Input::get('view')),
            'img' => $img,
            'ad_i18ns' => null
        ));
        Input::merge(array_map('trim', Input::all()));

        $ad = new Ad(Input::all());
        $ad->save();

        $ad_i18ns = array();
        for ($i = 0; $i < sizeof($languages); $i++) {
            $lid = $languages[$i]->id;
            $i18n = new Ad_i18n();
            $i18n->language = $lid;
            $i18n->ad()->associate($ad);

            if (!empty($i18ns[$lid])) {
                $i18n = new Ad_i18n($i18n->toArray() + array_map('trim', $i18ns[$lid]));
            }

            $ad_i18ns[] = $i18n;
        }

        $ad->ad_i18ns()->saveMany($ad_i18ns);

        return redirect()->route('ad.index')
            ->with('successes', [\Lang::get('msg.insert data successfully')]);
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
        return view('errors.404')->with('id', $id);
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
        if (Ad::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $ad = new Ad(Ad::find($id)->toArray());
        $languages = Language::all();

        $publish_time_explode = explode(" ", $ad->publish_time);
        list($publish_hh, $publish_ii, $publish_ss) = explode(":", $publish_time_explode[1]);
        $publish_hh = sprintf("%02d", $publish_hh);
        $publish_ii = sprintf("%02d", $publish_ii);
        $publish_ss = sprintf("%02d", $publish_ss);

        $ad->publish_day = $publish_time_explode[0];
        $ad->publish_hh = $publish_hh;
        $ad->publish_ii = $publish_ii;
        $ad->publish_ss = $publish_ss;

        if ($ad->end_time == null) {
            $ad->forever = true;
        } else {
            $ad->forever = false;

            $end_time_explode = explode(" ", $ad->end_time);
            list($end_hh, $end_ii, $end_ss) = explode(":", $end_time_explode[1]);
            $end_hh = sprintf("%02d", $end_hh);
            $end_ii = sprintf("%02d", $end_ii);
            $end_ss = sprintf("%02d", $end_ss);

            $ad->end_day = $end_time_explode[0];
            $ad->end_hh = $end_hh;
            $ad->end_ii = $end_ii;
            $ad->end_ss = $end_ss;
        }

        $hours = array();
        $minuteSeconds = array();
        for ($i = 0; $i < 60; $i++) {
            $num = sprintf("%02d", $i);
            if ($i < 24) {
                $hours[$num] = $num;
            }

            $minuteSeconds[$num] = $num;
        }

        return view('ad_edit', [
            'ad' => $ad,
            'languages' => $languages,
            'hours' => $hours,
            'minuteSeconds' => $minuteSeconds
        ]);
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
        if (Ad::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $ad = new Ad(Ad::find($id)->toArray());
        $db_upload_option = (boolean)$ad->upload_option;
        $upload_option = (boolean)Input::get('upload_option');

        $rules = null;
        if ($db_upload_option && $upload_option) {
            $rules = array(
                'title' => 'required',
                'url' => 'url|regex:/^http([s]?):\/\/.*/',
                'upload_file' => 'max:1024|image',
                'publish_day' => 'required|date_format:"Y-m-d"|after:1970-01-01|before:2500-01-01',
                'publish_hh' => 'required|date_format:"H"',
                'publish_ii' => 'required|date_format:"i"',
                'publish_ss' => 'required|date_format:"s"'
            );
        } elseif ($db_upload_option && !$upload_option) {
            $rules = array(
                'title' => 'required',
                'url' => 'url|regex:/^http([s]?):\/\/.*/',
                'img' => 'required|url|regex:/^http([s]?):\/\/.*/',
                'publish_day' => 'required|date_format:"Y-m-d"|after:1970-01-01|before:2500-01-01',
                'publish_hh' => 'required|date_format:"H"',
                'publish_ii' => 'required|date_format:"i"',
                'publish_ss' => 'required|date_format:"s"'
            );
        } elseif (!$db_upload_option && $upload_option) {
            $rules = array(
                'title' => 'required',
                'url' => 'url|regex:/^http([s]?):\/\/.*/',
                'upload_file' => 'required|max:1024|image',
                'publish_day' => 'required|date_format:"Y-m-d"|after:1970-01-01|before:2500-01-01',
                'publish_hh' => 'required|date_format:"H"',
                'publish_ii' => 'required|date_format:"i"',
                'publish_ss' => 'required|date_format:"s"'
            );
        } else {
            $rules = array(
                'title' => 'required',
                'url' => 'url|regex:/^http([s]?):\/\/.*/',
                'img' => 'required|url|regex:/^http([s]?):\/\/.*/',
                'publish_day' => 'required|date_format:"Y-m-d"|after:1970-01-01|before:2500-01-01',
                'publish_hh' => 'required|date_format:"H"',
                'publish_ii' => 'required|date_format:"i"',
                'publish_ss' => 'required|date_format:"s"'
            );
        }

        $this->validate($request, $rules, [], [
            'title' => Language::first()->language . '-' . \Lang::get('ui.ad title'),
            'url' => \Lang::get('ui.link'),
            'upload_file' => \Lang::get('ui.ad image')
        ]);

        Input::merge(array(
            'publish_time' => Input::get('publish_day') . " " . Input::get('publish_hh') . ":" . Input::get('publish_ii') . ":" . Input::get('publish_ss'),
        ));

        $forever = boolval(Input::get('forever'));
        if (!$forever) {
            $rules = array(
                'end_day' => 'required|date_format:"Y-m-d"|after:1970-01-01|before:2500-01-01',
                'end_hh' => 'required|date_format:"H"',
                'end_ii' => 'required|date_format:"i"',
                'end_ss' => 'required|date_format:"s"'
            );

            $this->validate($request, $rules);

            Input::merge(array(
                'end_time' => Input::get('end_day') . " " . Input::get('end_hh') . ":" . Input::get('end_ii') . ":" . Input::get('end_ss'),
            ));

            $rules = array(
                'end_time' => 'after:publish_time'
            );

            $this->validate($request, $rules);
        }

        $img = $ad->img;
        if ($db_upload_option && $upload_option) {
            if (Input::hasFile('upload_file')) {

                $imageName = Input::file('upload_file');

                $imageName = time() . "-" . $imageName->getClientOriginalName();

                Input::file('upload_file')->move(
                    public_path('ads/'), $imageName
                );

                $img = "ads/$imageName";
                $path = public_path($img);

                $width = Image::make($path)->width();
                $height = Image::make($path)->height();
                $new_height = \Config::get('app.ads_image_width') * $height / $width;

                Image::make($path)
                    ->resize(\Config::get('app.ads_image_width'), $new_height)
                    ->save($path);

                File::delete(public_path($ad->img));
            }

        } elseif ($db_upload_option && !$upload_option) {

            $img = Input::get('img');

            File::delete(public_path($ad->img));

        } elseif (!$db_upload_option && $upload_option) {

            $imageName = Input::file('upload_file');

            $imageName = time() . "-" . $imageName->getClientOriginalName();

            Input::file('upload_file')->move(
                public_path('ads/'), $imageName
            );

            $img = "ads/$imageName";
            $path = public_path($img);

            $width = Image::make($path)->width();
            $height = Image::make($path)->height();
            $new_height = \Config::get('app.ads_image_width') * $height / $width;

            Image::make($path)
                ->resize(\Config::get('app.ads_image_width'), $new_height)
                ->save($path);

        } else {
            $img = Input::get('img');
        }

        $languages = Language::where('id', '>', 0)->get();
        $i18ns = Input::get('ad_i18ns');

        Input::merge(array(
            'upload_option' => boolval(Input::get('upload_option')),
            'view' => boolval(Input::get('view')),
            'img' => $img,
            'ad_i18ns' => null
        ));
        Input::merge(array_map('trim', Input::all()));

        $ad = new Ad(Input::all());
        if ($forever) {
            $ad->end_time = null;
        }
        Ad::whereId($id)->update($ad->toArray());

        for ($i = 0; $i < sizeof($languages); $i++) {
            $lid = $languages[$i]->id;
            $i18n = new Ad_i18n();
            $i18n->ad_id = $id;
            $i18n->language = $lid;

            if (!empty($i18ns[$lid])) {
                $i18n = new Ad_i18n($i18n->toArray() + array_map('trim', $i18ns[$lid]));
            }

            if (Ad_i18n::whereAdId($id)->whereLanguage($lid)->exists()) {
                Ad_i18n::whereAdId($id)->whereLanguage($lid)->update($i18n->toArray());
            } else {
                $i18n->save();
            }
        }

        return redirect()->route('ad.index')
            ->with('successes', [\Lang::get('msg.modify data successfully')]);
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
        if (Ad::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $ad = new Ad(Ad::find($id)->toArray());
        File::delete(public_path($ad->img));

        Ad_i18n::whereAdId($id)->delete();
        Ad::whereId($id)->delete();

        return redirect()->route('ad.index')->with('successes', [\Lang::get('msg.delete data successfully')]);
    }
}
