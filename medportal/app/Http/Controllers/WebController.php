<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Book;
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
            return view('pages', [
                'pages_data' => $pages_data,
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
        $news = News::whereView(true)
            ->where('publish_time', '<=', Carbon::now()->toDateTimeString())
            ->where(function ($q) {
                $q->whereEndTime(null)->orWhere('end_time', '>', Carbon::now()->toDateTimeString());
            })
            ->orderBy('publish_time', 'desc')->get();

        return view('news_list', [
            'news' => $news,
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

        return view('news_detail', [
            'news' => $news,
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

        $book = Book::whereView(true)
            ->orderBy('rand_id', 'desc')
            ->get();

        $news = News::whereView(true)
            ->where('publish_time', '<=', Carbon::now()->toDateTimeString())
            ->where(function ($q) {
                $q->whereEndTime(null)->orWhere('end_time', '>', Carbon::now()->toDateTimeString());
            })
            ->orderBy('publish_time', 'desc')->take(5)->skip(0)->get();

        $banners = Banner::whereView(true)->get();

        return view('index', [
            'banners' => $banners,
            'book' => $book,
            'news' => $news,
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
