<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Language;
use App\News;
use App\News_i18n;
use Config;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Input;

class NewsController extends Controller
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
        $totalPage = ceil(News::count() / $perPage);

        $page = intval(Input::get('page'));
        if ($page <= 0) {
            $page = 1;
        } elseif ($page > $totalPage) {
            $page = $totalPage;
        }
        Input::merge(['page' => $page]);

        $table = News::orderBy('publish_time', 'desc')
            ->paginate(Config::get('app.pages_config'));

        return view('news_index')->with('table', $table);
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
        return view('news_create')->with('hours', $hours)->with('minuteSeconds', $minuteSeconds)->with('languages', $languages);
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
            'title' => 'required',
            'content' => 'required',
            'publish_day' => 'required|date_format:"Y-m-d"|after:1970-01-01|before:2500-01-01',
            'publish_hh' => 'required|date_format:"H"',
            'publish_ii' => 'required|date_format:"i"',
            'publish_ss' => 'required|date_format:"s"'
        );

        $messages = array(
            'title.required' => '<p>．請輸入標題。</p>',
            'content.required' => '<p>．請輸入繁體中文的內容。</p>',
            'publish_day.required' => '<p>．請輸入公告日期。</p>',
            'publish_day.date_format' => '<p>．請輸入正確格式公告日期。</p>',
            'publish_day.after' => '<p>．公告日期太早。</p>',
            'publish_day.before' => '<p>．公告日期太晚。</p>',
            'publish_hh.required' => '<p>．公告時必須填。</p>',
            'publish_ii.required' => '<p>．公告分必須填。</p>',
            'publish_ss.required' => '<p>．公告秒必須填。</p>',
            'publish_hh.date_format' => '<p>．請輸入正確格式公告時。</p>',
            'publish_ii.date_format' => '<p>．請輸入正確格式公告分。</p>',
            'publish_ss.date_format' => '<p>．請輸入正確格式公告秒。</p>'
        );

        $this->validate($request, $rules, $messages);

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

            $messages = array(
                'end_day.required' => '<p>．請輸入結束日期。</p>',
                'end_date.date_format' => '<p>．請輸入正確格式結束日期。</p>',
                'end_date.after' => '<p>．結束日期太早。</p>',
                'end_date.before' => '<p>．結束日期太晚。</p>',
                'end_hh.required' => '<p>．結束時必須填。</p>',
                'end_ii.required' => '<p>．結束分必須填。</p>',
                'end_ss.required' => '<p>．結束秒必須填。</p>',
                'end_hh.date_format' => '<p>．請輸入正確格式結束時。</p>',
                'end_ii.date_format' => '<p>．請輸入正確格式結束分。</p>',
                'end_ss.date_format' => '<p>．請輸入正確格式結束秒。</p>'
            );

            $this->validate($request, $rules, $messages);

            Input::merge(array(
                'end_time' => Input::get('end_day') . " " . Input::get('end_hh') . ":" . Input::get('end_ii') . ":" . Input::get('end_ss'),
            ));

            $rules = array(
                'end_time' => 'after:publish_time'
            );

            $messages = array(
                'end_time.after' => '<p>．公告時間必須早於結束時間。</p>'
            );

            $this->validate($request, $rules, $messages);
        }

        $languages = Language::where('id', '>', 0)->get();
        $i18ns = Input::get('news_i18ns');

        Input::merge(array(
            'view' => boolval(Input::get('view')),
            'news_i18ns' => null
        ));
        Input::merge(array_map('trim', Input::all()));

        $news = new News(Input::all());
        $news->save();

        $news_i18ns = array();
        for ($i = 0; $i < sizeof($languages); $i++) {
            $lid = $languages[$i]->id;
            $i18n = new News_i18n();
            $i18n->language = $lid;
            $i18n->news()->associate($news);

            if (!empty($i18ns[$lid])) {
                $i18n = new News_i18n($i18n->toArray() + array_map('trim', $i18ns[$lid]));
            }

            $news_i18ns[] = $i18n;
        }

        $news->news_i18ns()->saveMany($news_i18ns);

        return redirect()->route('news.index')
            ->with('success', '新增資料成功');
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
        if (News::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $news = new News(News::find($id)->toArray());
        $languages = Language::all();

        $publish_time_explode = explode(" ", $news->publish_time);
        list($publish_hh, $publish_ii, $publish_ss) = explode(":", $publish_time_explode[1]);
        $publish_hh = sprintf("%02d", $publish_hh);
        $publish_ii = sprintf("%02d", $publish_ii);
        $publish_ss = sprintf("%02d", $publish_ss);

        $news->publish_day = $publish_time_explode[0];
        $news->publish_hh = $publish_hh;
        $news->publish_ii = $publish_ii;
        $news->publish_ss = $publish_ss;

        if ($news->end_time == null) {
            $news->forever = true;
        } else {
            $news->forever = false;

            $end_time_explode = explode(" ", $news->end_time);
            list($end_hh, $end_ii, $end_ss) = explode(":", $end_time_explode[1]);
            $end_hh = sprintf("%02d", $end_hh);
            $end_ii = sprintf("%02d", $end_ii);
            $end_ss = sprintf("%02d", $end_ss);

            $news->end_day = $end_time_explode[0];
            $news->end_hh = $end_hh;
            $news->end_ii = $end_ii;
            $news->end_ss = $end_ss;
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

        return view('news_edit', [
            'news' => $news,
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
    public
    function update(Request $request, $id)
    {
        //
        if (News::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $rules = array(
            'title' => 'required',
            'content' => 'required',
            'publish_day' => 'required|date_format:"Y-m-d"|after:1970-01-01|before:2500-01-01',
            'publish_hh' => 'required|date_format:"H"',
            'publish_ii' => 'required|date_format:"i"',
            'publish_ss' => 'required|date_format:"s"'
        );

        $messages = array(
            'title.required' => '<p>．請輸入標題。</p>',
            'content.required' => '<p>．請輸入繁體中文的內容。</p>',
            'publish_day.required' => '<p>．請輸入公告日期。</p>',
            'publish_day.date_format' => '<p>．請輸入正確格式公告日期。</p>',
            'publish_day.after' => '<p>．公告日期太早。</p>',
            'publish_day.before' => '<p>．公告日期太晚。</p>',
            'publish_hh.required' => '<p>．公告時必須填。</p>',
            'publish_ii.required' => '<p>．公告分必須填。</p>',
            'publish_ss.required' => '<p>．公告秒必須填。</p>',
            'publish_hh.date_format' => '<p>．請輸入正確格式公告時。</p>',
            'publish_ii.date_format' => '<p>．請輸入正確格式公告分。</p>',
            'publish_ss.date_format' => '<p>．請輸入正確格式公告秒。</p>'
        );

        $this->validate($request, $rules, $messages);

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

            $messages = array(
                'end_day.required' => '<p>．請輸入結束日期。</p>',
                'end_day.date_format' => '<p>．請輸入正確格式結束日期。</p>',
                'end_day.after' => '<p>．結束日期太早。</p>',
                'end_day.before' => '<p>．結束日期太晚。</p>',
                'end_hh.required' => '<p>．結束時必須填。</p>',
                'end_ii.required' => '<p>．結束分必須填。</p>',
                'end_ss.required' => '<p>．結束秒必須填。</p>',
                'end_hh.date_format' => '<p>．請輸入正確格式結束時。</p>',
                'end_ii.date_format' => '<p>．請輸入正確格式結束分。</p>',
                'end_ss.date_format' => '<p>．請輸入正確格式結束秒。</p>'
            );

            $this->validate($request, $rules, $messages);

            Input::merge(array(
                'end_time' => Input::get('end_day') . " " . Input::get('end_hh') . ":" . Input::get('end_ii') . ":" . Input::get('end_ss'),
            ));

            $rules = array(
                'end_time' => 'after:publish_time'
            );

            $messages = array(
                'end_time.after' => '<p>．公告時間必須早於結束時間。</p>'
            );

            $this->validate($request, $rules, $messages);
        }

        $languages = Language::where('id', '>', 0)->get();
        $i18ns = Input::get('news_i18ns');

        Input::merge(array(
            'view' => boolval(Input::get('view')),
            'news_i18ns' => null
        ));
        Input::merge(array_map('trim', Input::all()));

        $news = new News(Input::all());
        if ($forever) {
            $news->end_time = null;
        }
        News::whereId($id)->update($news->toArray());

        for ($i = 0; $i < sizeof($languages); $i++) {
            $lid = $languages[$i]->id;
            $i18n = new News_i18n();
            $i18n->news_id = $id;
            $i18n->language = $lid;

            if (!empty($i18ns[$lid])) {
                $i18n = new News_i18n($i18n->toArray() + array_map('trim', $i18ns[$lid]));
            }

            if (News_i18n::whereNewsId($id)->whereLanguage($lid)->exists()) {
                News_i18n::whereNewsId($id)->whereLanguage($lid)->update($i18n->toArray());
            } else {
                $i18n->save();
            }
        }

        return redirect()->route('news.index')
            ->with('success', '更新資料成功');
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
        if (News::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        News_i18n::whereNewsId($id)->delete();
        News::whereId($id)->delete();

        return redirect()->route('news.index')
            ->with('success', '刪除資料成功');
    }
}
