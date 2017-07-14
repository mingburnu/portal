<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Book;
use App\Http\Requests;
use App\Language;
use App\Menupage;
use App\News;
use Carbon\Carbon;
use Cookie;
use DB;
use Illuminate\Http\Response;

class WebController extends Controller
{
    public function pages($id)
    {
        if (Menupage::whereView(true)->whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $pages_data = new Menupage(Menupage::whereView(true)->find($id)->toArray());

        DB::table('login_pages_stat')->insert(
            [
                'title' => $pages_data->title,
                'view' => $pages_data->view,
                'view_times' => 1
            ]
        );

        if ($pages_data->type) {
            $queryDb = \App\Db::whereView(true)->orderBy('rank_id', 'desc')->get();

            $menus = Menupage::whereView(true)
                ->whereParentId(null)
                ->orderBy('rank_id', 'desc')->get();

            $totalc = DB::table('webcounter')->count();

            return view('pages', [
                'queryDb' => $queryDb,
                'pages_data' => $pages_data,
                'menus' => $menus,
                'totalc' => $totalc,
            ]);
        } else {
            $url = $pages_data->url;
            $lang_id = \View::getShared()['signal'][0]->id;

            foreach ($pages_data->menupage_i18ns as $i18n) {
                if ($i18n->language == $lang_id) {
                    if (!empty($i18n->url)) {
                        $url = $i18n->url;
                    }
                    break;
                }
            }
            return redirect($url);
        }
    }

    public function news_list()
    {
        $queryDb = \App\Db::whereView(true)->orderBy('rank_id', 'desc')->get();

        $news = News::whereView(true)
            ->where('publish_time', '<=', Carbon::now()->toDateTimeString())
            ->where(function ($q) {
                $q->whereEndTime(null)->orWhere('end_time', '>', Carbon::now()->toDateTimeString());
            })
            ->orderBy('publish_time', 'desc')->get();

        $menus = Menupage::whereView(true)
            ->whereParentId(null)
            ->orderBy('rank_id', 'desc')->get();

        $totalc = DB::table('webcounter')->count();

        return view('news_list', [
            'queryDb' => $queryDb,
            'news' => $news,
            'menus' => $menus,
            'totalc' => $totalc,
        ]);

    }

    public function news_detail($id)
    {
        if (News::whereView(true)
                ->where('publish_time', '<=', Carbon::now()->toDateTimeString())
                ->where(function ($q) {
                    $q->whereEndTime(null)->orWhere('end_time', '>', Carbon::now()->toDateTimeString());
                })
                ->whereId($id)->count() == 0
        ) {
            return view('errors.404');
        }

        $news = News::whereView(true)
            ->where('publish_time', '<=', Carbon::now()->toDateTimeString())
            ->where(function ($q) {
                $q->whereEndTime(null)->orWhere('end_time', '>', Carbon::now()->toDateTimeString());
            })
            ->find($id);


        $queryDb = \App\Db::whereView(true)->orderBy('rank_id', 'desc')->get();

        $menus = Menupage::whereView(true)
            ->whereParentId(null)
            ->orderBy('rank_id', 'desc')->get();

        $totalc = DB::table('webcounter')->count();

        return view('news_detail', [
            'queryDb' => $queryDb,
            'news' => $news,
            'menus' => $menus,
            'totalc' => $totalc,
        ]);

    }

    public function index()
    {
        DB::table('login_pages_stat')->insert(
            [
                'title' => Language::first()->language,
                'view' => 1,
                'view_times' => 1
            ]
        );

        $ipaddress = $_SERVER["REMOTE_ADDR"];

        DB::table('webcounter')->insert(
            [
                'ipaddress' => $ipaddress,
                'view_times' => 1
            ]
        );

        $queryDb = \App\Db::whereView(true)->orderBy('rank_id', 'desc')->get();

        $book = Book::whereView(true)
            ->orderBy('rand_id', 'desc')
            ->get();

        $news = News::whereView(true)
            ->where('publish_time', '<=', Carbon::now()->toDateTimeString())
            ->where(function ($q) {
                $q->whereEndTime(null)->orWhere('end_time', '>', Carbon::now()->toDateTimeString());
            })
            ->orderBy('publish_time', 'desc')->take(5)->skip(0)->get();

        $menus = Menupage::whereView(true)
            ->whereParentId(null)
            ->orderBy('rank_id', 'desc')->get();

        $banners = Banner::whereView(true)->get();

        $totalc = DB::table('webcounter')->count();

        return view('index', [
            'banners' => $banners,
            'queryDb' => $queryDb,
            'book' => $book,
            'news' => $news,
            'menus' => $menus,
            'totalc' => $totalc,
        ]);
    }

    public function locale()
    {
        $lang_id = \Input::get('lang_id');
        if (intval($lang_id < 0) || sizeof(Language::whereId($lang_id)->whereDisplay(true)->get()) == 0) {
            $lang_id = Language::whereDisplay(true)->orderBy('sort', 'desc')->first()->id;
        }

        $response = new Response();
        $response->withCookie(Cookie::forever('language', $lang_id));
        return $response;
    }
}
