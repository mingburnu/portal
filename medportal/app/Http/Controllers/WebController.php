<?php

namespace App\Http\Controllers;

use App\Book;
use App\Menupage;
use App\News;
use DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class WebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function pages($id)
    {
        $pages_data = Menupage::where('view', true)->where('id', $id)->get();
        if (sizeof($pages_data) == 0) {
            return view('errors.404');
        }

        DB::table('login_pages_stat')->insert(
            [
                'title' => $pages_data[0]->title,
                'view' => $pages_data[0]->view,
                'view_times' => 1
            ]
        );

        if ($pages_data[0]->type) {
            $lang_id = $this->get_lang_id();

            $webconfig = DB::table('webconfig')->get();
            $webconfig_i18n = null;
            if ($lang_id != 0) {
                $webconfig_i18n = DB::table('webconfig_i18n')->where('language', $lang_id)->get();
            }

            $queryDb = \App\Db::where('view', true)->orderBy('rank_id', 'desc')->get();

            $pages = Menupage::where('view', true)
                ->where('parent_id', null)
                ->orderBy('rank_id', 'desc')->get();

            $signal = DB::table('languages')->where('id', $lang_id)->get();

            $totalc = DB::table('webcounter')->count();

            return view('pages', [
                'webconfig' => $webconfig,
                'webconfig_i18n' => $webconfig_i18n,
                'queryDb' => $queryDb,
                'pages_data' => $pages_data,
                'pages' => $pages,
                'totalc' => $totalc,
                'signal' => $signal
            ]);
        } else {

            return Redirect::to($pages_data[0]->url);
        }
    }

    public function news_list()
    {
        $lang_id = $this->get_lang_id();

        $webconfig = DB::table('webconfig')->get();
        $webconfig_i18n = null;
        if ($lang_id != 0) {
            $webconfig_i18n = DB::table('webconfig_i18n')->where('language', $lang_id)->get();
        }

        $queryDb = \App\Db::where('view', true)->orderBy('rank_id', 'desc')->get();

        $news = News::where('view', true)
            ->where('publish_time', '<=', DB::raw('CURRENT_TIMESTAMP'))
            ->orderBy('publish_time', 'desc')->get();

        $pages = Menupage::where('view', true)
            ->where('parent_id', null)
            ->orderBy('rank_id', 'desc')->get();

        $signal = DB::table('languages')->where('id', $lang_id)->get();

        $totalc = DB::table('webcounter')->count();

        return view('news_list', [
            'webconfig' => $webconfig,
            'webconfig_i18n' => $webconfig_i18n,
            'queryDb' => $queryDb,
            'news' => $news,
            'pages' => $pages,
            'totalc' => $totalc,
            'signal' => $signal
        ]);

    }

    public function news_detail($id)
    {

        $lang_id = $this->get_lang_id();

        $webconfig = DB::table('webconfig')->get();
        $webconfig_i18n = null;
        if ($lang_id != 0) {
            $webconfig_i18n = DB::table('webconfig_i18n')->where('language', $lang_id)->get();
        }

        $queryDb = \App\Db::where('view', true)->orderBy('rank_id', 'desc')->get();

        $news = News::where('view', true)
            ->where('publish_time', '<=', DB::raw('CURRENT_TIMESTAMP'))
            ->where('id', $id)->get();

        $pages = Menupage::where('view', true)
            ->where('parent_id', null)
            ->orderBy('rank_id', 'desc')->get();

        $signal = DB::table('languages')->where('id', $lang_id)->get();

        $totalc = DB::table('webcounter')->count();

        return view('news_detail', [
            'webconfig' => $webconfig,
            'webconfig_i18n' => $webconfig_i18n,
            'queryDb' => $queryDb,
            'news' => $news,
            'pages' => $pages,
            'totalc' => $totalc,
            'signal' => $signal
        ]);

    }

    public function index()
    {
        $lang_id = $this->get_lang_id();

        DB::table('login_pages_stat')->insert(
            [
                'title' => '首頁',
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

        $webconfig = DB::table('webconfig')->get();
        $webconfig_i18n = null;
        if ($lang_id != 0) {
            $webconfig_i18n = DB::table('webconfig_i18n')->where('language', $lang_id)->get();
        }

        $queryDb = \App\Db::where('view', true)->orderBy('rank_id', 'desc')->get();

        $book = Book::where('view', true)
            ->orderBy('rand_id', 'desc')
            ->get();

        $news = News::where('view', true)
            ->where('publish_time', '<=', DB::raw('CURRENT_TIMESTAMP'))
            ->orderBy('publish_time', 'desc')->take(5)->skip(0)->get();

        $pages = Menupage::where('view', true)
            ->where('parent_id', null)
            ->orderBy('rank_id', 'desc')->get();

        $languages = DB::table('languages')->where('display', true)->orderBy('sort', 'desc')->lists('language', 'id');

        $signal = DB::table('languages')->where('id', $lang_id)->get();

        $totalc = DB::table('webcounter')->count();

        return view('index', [
            'webconfig' => $webconfig,
            'webconfig_i18n' => $webconfig_i18n,
            'queryDb' => $queryDb,
            'book' => $book,
            'news' => $news,
            'pages' => $pages,
            'totalc' => $totalc,
            'languages' => $languages,
            'signal' => $signal
        ]);
    }

    public function locale()
    {
        $lang_id = intval(Input::get('lang_id'));

        if ($lang_id < 0 || sizeof(DB::table('languages')->where('id', '=', $lang_id)->where('display', true)->get()) == 0) {
            $lang_id = 0;
        }

        $response = new Response();
        $response->withCookie(\Cookie::forever('language', $lang_id));

        return $response;
    }

    protected function get_lang_id()
    {
        $lang_id = \Cookie::get('language');
        if ($lang_id == null || sizeof(DB::table('languages')->where('id', '=', $lang_id)->where('display', true)->get()) == 0) {
            $lang_id = 0;
        }

        return $lang_id;
    }
}
