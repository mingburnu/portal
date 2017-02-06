<?php

namespace App\Http\Controllers;

use App\Menupage;
use App\Menupage_i18n;
use App\User;
use Illuminate\Support\Facades\Input;
use Mail;
use Log;
use Auth;
use DB;
use PDF;

//use Input;
//use Session;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use File;
use Config;
use Image;
use Excel;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */


    public function state_C_output_csv($Year, $Month)
    {

        $report = DB::select('SELECT *
            FROM month_login_pages_stat
            WHERE yearmonth like ?', ['%' . $Year . '-' . $Month . '%']
        );

        // CSV

        return Excel::create($Year . '-' . $Month, function ($excel) use ($report, $Year, $Month) {

            $excel->sheet('Sheetname', function ($sheet) use ($report, $Year, $Month) {

                $sheet->row(1, array(
                    '年-月', '網頁名稱', '是否顯示', '進入次數'
                ));

                for ($i = 0; $i < count($report); $i++) {


                    $view = '';

                    if ($report[$i]->view == 1) {
                        $view = '是';
                    } elseif ($report[$i]->view == 0) {
                        $view = '否';
                    }

                    $sheet->row($i + 2, array(
                        $Year . '-' . $Month, $report[$i]->title,
                        $view, $report[$i]->view_times
                    ));

                }

            });

        })->download('csv');

    }

    public function state_C_output($Year, $Month)
    {

        $report = DB::select('SELECT *
            FROM month_login_pages_stat
            WHERE yearmonth like ?', ['%' . $Year . '-' . $Month . '%']
        );

        $html = view('state_C_output', [
            'Year' => $Year,
            'Month' => $Month,
            'report' => $report
        ]);

        return PDF::loadHTML($html)->download($Year . '-' . $Month . '.pdf');


    }


    public function state_A_output_csv($Year, $Month)
    {

        $report = DB::select('SELECT
            yearmonth,
            account_userid,
            users.perm,
            users.lock,
            login,
            logout
            FROM month_backend_login_stat
            LEFT JOIN
            users
            ON month_backend_login_stat.account_userid
            = users.email
            WHERE yearmonth like ?', ['%' . $Year . '-' . $Month . '%']
        );

        // CSV

        return Excel::create($Year . '-' . $Month, function ($excel) use ($report, $Year, $Month) {

            $excel->sheet('Sheetname', function ($sheet) use ($report, $Year, $Month) {

                $sheet->row(1, array(
                    '年-月', '帳號', '權限身份', '是否封鎖', '登入次數', '登入次數'
                ));

                for ($i = 0; $i < count($report); $i++) {


                    $perm = '';

                    if ($report[$i]->perm == 1) {
                        $perm = '最高管理者';
                    } elseif ($report[$i]->perm == 2) {
                        $perm = '一般管理者';
                    }

                    $lock = '';

                    if ($report[$i]->lock == 1) {
                        $lock = '是';
                    } elseif ($report[$i]->lock == 0) {
                        $lock = '否';
                    }

                    $sheet->row($i + 2, array(
                        $Year . '-' . $Month, $report[$i]->account_userid,
                        $perm, $lock, $report[$i]->login, $report[$i]->logout
                    ));

                }

            });


        })->download('csv');

    }

    public function state_A_output($Year, $Month)
    {


        $report = DB::select('SELECT
            yearmonth,
            account_userid,
            users.perm,
            users.lock,
            login,
            logout
            FROM month_backend_login_stat
            LEFT JOIN
            users
            ON month_backend_login_stat.account_userid
            = users.email
            WHERE yearmonth like ?', ['%' . $Year . '-' . $Month . '%']
        );

        $html = view('state_A_output', [
            'Year' => $Year,
            'Month' => $Month,
            'report' => $report
        ]);

        return PDF::loadHTML($html)->download($Year . '-' . $Month . '.pdf');

    }

    public function forget_post(Request $request)
    {
        $email_data = $request->all();

        //Log::info('data ............... ' . dump($info)); 

        $library_name = db::table('webconfig')->get();

        $subject = $library_name[0]->site_name . " 密碼函";

        $email = trim($email_data['email']);

        $rs_data = DB::table('users')->where('email', $email)->get();

        //Log::info('data ==================== ' . dump($rs_data));

        if (count($rs_data) > 0) {
            $password = str_random(12);

            // update data

            $timedata = DB::select('select now() as timedata');

            DB::table('users')
                ->where('email', $email)
                ->update([
                    'password' => bcrypt($password),
                    'updated_at' => $timedata[0]->timedata
                ]);

            //Log::info(" p - $password");

            Mail::send('email.send_forget_email_data', ['subject' => $subject, 'email' => $email,
                'password' => $password, 'library_name' => $library_name], function ($message)
            use ($subject, $email, $password, $library_name) {

                $message->from($library_name[0]->email, $library_name[0]->site_name)->subject($subject);

                //$message->to('koha@sydt.com.tw');
                $message->to($email);

                // mail log

            });

            return view('forget_email')->with('email', $email);

        } else {
            return view('errors.404');
        }

    }

    public function forget()
    {

        return view('forget');

    }


    public function state_C_post(Request $request)
    {

        $state_C = $request->all();

        $Year = trim($state_C['Year']);

        $Month = trim($state_C['Month']);

        $report = DB::select('SELECT
            *
            FROM month_login_pages_stat
            WHERE yearmonth like ?', ['%' . $Year . '-' . $Month . '%']
        );

        //        Log::info('data -------------------' . dump($data));

        return view('state_C', [
            'Year' => $Year,
            'Month' => $Month,
            'report' => $report
        ]);


    }


    public function state_A_post(Request $request)
    {

        $state_A = $request->all();


        $Year = trim($state_A['Year']);

        $Month = trim($state_A['Month']);

        $report = DB::select('SELECT
            yearmonth,
            account_userid,
            users.perm,
            users.lock,
            login,
            logout
            FROM month_backend_login_stat
            LEFT JOIN
            users
            ON month_backend_login_stat.account_userid
            = users.email
            WHERE yearmonth like ?', ['%' . $Year . '-' . $Month . '%']
        );

        //        Log::info('data -------------------' . dump($data));

        return view('state_A', [
            'Year' => $Year,
            'Month' => $Month,
            'report' => $report
        ]);


    }

    public function paper_add()
    {
        $top = array('' => '不設定(單一網頁)');
        $titles = Menupage::where('parent_id', '=', null)->lists('title', 'id')->toArray();
        $select = $top + $titles;
        $languages = DB::table('languages')->get();
        return view('paper_add')->with('languages', $languages)->with('select', $select);
    }

    public function paper_add_post(Request $request)
    {
        $type = (boolean)\Input::get('type');
        $ids = Menupage::select('id')->where('parent_id', '=', null)->lists('id')->toArray();

        if ($type) {
            $rules = array(
                'title' => 'required',
                'parent_id' => 'in:' . implode(',', $ids)
            );

            $messages = array(
                'title.required' => '<p>．請輸入項目名稱。</p>',
                'parent_id.in' => '<p>．位置不正確</p>'
            );
        } else {
            $rules = array(
                'title' => 'required',
                'url' => 'regex:/^http([s]?):\/\/.*/',
                'parent_id' => 'in:' . implode(',', $ids)
            );

            $messages = array(
                'title.required' => '<p>．請輸入項目名稱。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'parent_id.in' => '<p>．位置不正確</p>'
            );
        }

        $this->validate($request, $rules, $messages);

        //    Log::info('data ------------------ ' . dump($paper));

        $timedata = DB::select('select now() as timedata');
        $languages = DB::table('languages')->where('id', '>', 0)->get();
        $pid = \Input::get('parent_id');
        if (trim($pid) == "") {
            $pid = null;
        }

        if ($type) {
            $id = DB::table('pages')->insertGetId([
                'title' => trim(\Input::get('title')),
                'type' => $type,
                'content' => trim(Input::get('content')),
                'url' => '',
                'parent_id' => $pid,
                'view' => (boolean)\Input::get('view'),
                'rank_id' => \Input::get('rank_id'),
                'note' => trim(\Input::get('note')),
                'created_at' => $timedata[0]->timedata,
                'updated_at' => $timedata[0]->timedata
            ]);

            for ($i = 0; $i < sizeof($languages); $i++) {
                DB::table('pages_i18n')->insert(
                    [
                        'page_id' => $id,
                        'language' => $languages[$i]->id,
                        'title' => trim(\Input::get($languages[$i]->id . '_title')),
                        'content' => trim(\Input::get($languages[$i]->id . '_content')),
                        'url' => ''
                    ]
                );
            }
        } else {
            $id = DB::table('pages')->insertGetId([
                'title' => trim(\Input::get('title')),
                'type' => $type,
                'content' => '',
                'url' => trim(Input::get('url')),
                'parent_id' => $pid,
                'view' => (boolean)\Input::get('view'),
                'rank_id' => \Input::get('rank_id'),
                'note' => trim(\Input::get('note')),
                'created_at' => $timedata[0]->timedata,
                'updated_at' => $timedata[0]->timedata
            ]);

            for ($i = 0; $i < sizeof($languages); $i++) {
                DB::table('pages_i18n')->insert(
                    [
                        'page_id' => $id,
                        'language' => $languages[$i]->id,
                        'title' => trim(\Input::get($languages[$i]->id . '_title')),
                        'content' => '',
                        'url' => trim(\Input::get($languages[$i]->id . '_url'))
                    ]
                );
            }
        }

        return redirect()->route('paper.browser')
            ->with('success', '新增資料成功');

    }

    public function paper_edit_id($id)
    {
        if (DB::table('pages')->where('id', '=', $id)->count() == 0) {
            return view('errors.404');
        }

        $paper = DB::table('pages')->where('id', '=', $id)->get();
        $paper_i18n = DB::table('pages_i18n')->where('page_id', '=', $id)->get();

        $top = array('' => '不設定(單一網頁)');
        $select = $top;

        if (Menupage::where('parent_id', '=', $id)->count() == 0) {
            $titles = Menupage::where('parent_id', '=', null)->where('id', '!=', $id)->lists('title', 'id')->toArray();
            $select = $top + $titles;
        }

        $languages = DB::table('languages')->get();
        return view('paper_edit')->with('paper', $paper)->with('paper_i18n', $paper_i18n)->with('languages', $languages)->with('select', $select);

    }

    public function paper_edit_post(Request $request, $id)
    {
        if (DB::table('pages')->where('id', '=', $id)->count() == 0) {
            return view('errors.404');
        }

        $type = (boolean)\Input::get('type');

        if ($type) {
            $rules = array(
                'title' => 'required',
                'parent_id' => 'node'
            );

            $messages = array(
                'title.required' => '<p>．請輸入項目名稱。</p>',
                'parent_id.node' => '<p>．位置不正確</p>'
            );
        } else {
            $rules = array(
                'title' => 'required',
                'url' => 'regex:/^http([s]?):\/\/.*/',
                'parent_id' => 'node'
            );

            $messages = array(
                'title.required' => '<p>．請輸入項目名稱。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'parent_id.node' => '<p>．位置不正確</p>'
            );
        }

        $this->validate($request, $rules, $messages);

        //    Log::info('data ------------------ ' . dump($paper));

        $timedata = DB::select('select now() as timedata');
        $languages = DB::table('languages')->where('id', '>', 0)->get();
        $pid = \Input::get('parent_id');
        if (trim($pid) == "") {
            $pid = null;
        }

        if ($type) {
            DB::table('pages')
                ->where('id', $id)
                ->update([
                    'title' => trim(\Input::get('title')),
                    'type' => $type,
                    'content' => trim(Input::get('content')),
                    'url' => '',
                    'parent_id' => $pid,
                    'view' => (boolean)\Input::get('view'),
                    'rank_id' => \Input::get('rank_id'),
                    'note' => trim(\Input::get('note')),
                    'updated_at' => $timedata[0]->timedata
                ]);

            for ($i = 0; $i < sizeof($languages); $i++) {
                if (DB::table('pages_i18n')->where('page_id', '=', $id)->where('language', '=', $languages[$i]->id)->count() == 0) {
                    DB::table('pages_i18n')->insert(
                        [
                            'page_id' => $id,
                            'language' => $languages[$i]->id,
                            'title' => trim(\Input::get($languages[$i]->id . '_title')),
                            'content' => trim(\Input::get($languages[$i]->id . '_content')),
                            'url' => ''
                        ]
                    );
                } else {
                    DB::table('pages_i18n')
                        ->where('page_id', $id)
                        ->where('language', '=', $languages[$i]->id)
                        ->update(
                            [
                                'page_id' => $id,
                                'language' => $languages[$i]->id,
                                'title' => trim(\Input::get($languages[$i]->id . '_title')),
                                'content' => trim(\Input::get($languages[$i]->id . '_content')),
                                'url' => ''
                            ]
                        );
                }
            }
        } else {
            DB::table('pages')
                ->where('id', $id)
                ->update([
                    'title' => trim(\Input::get('title')),
                    'type' => $type,
                    'content' => '',
                    'url' => trim(Input::get('url')),
                    'parent_id' => $pid,
                    'view' => (boolean)\Input::get('view'),
                    'rank_id' => \Input::get('rank_id'),
                    'note' => trim(\Input::get('note')),
                    'updated_at' => $timedata[0]->timedata
                ]);

            for ($i = 0; $i < sizeof($languages); $i++) {
                if (DB::table('pages_i18n')->where('page_id', '=', $id)->where('language', '=', $languages[$i]->id)->count() == 0) {
                    DB::table('pages_i18n')->insert(
                        [
                            'page_id' => $id,
                            'language' => $languages[$i]->id,
                            'title' => trim(\Input::get($languages[$i]->id . '_title')),
                            'content' => '',
                            'url' => trim(\Input::get($languages[$i]->id . '_url'))
                        ]
                    );
                } else {
                    DB::table('pages_i18n')
                        ->where('page_id', $id)
                        ->where('language', '=', $languages[$i]->id)
                        ->update(
                            [
                                'page_id' => $id,
                                'language' => $languages[$i]->id,
                                'title' => trim(\Input::get($languages[$i]->id . '_title')),
                                'content' => '',
                                'url' => trim(\Input::get($languages[$i]->id . '_url'))
                            ]
                        );
                }
            }
        }

        return redirect()->route('paper.browser')
            ->with('success', '更新資料成功');

    }

//    public function paper_view_id($id)
//    {
//
//        $newid = trim($id);
//
//        $paper = DB::table('pages')->where('id', '=', $newid)->get();
//
//        return view('paper_view')->with('paper', $paper);
//
//
//    }

    public function paper_browser_id_delete($id)
    {
        if (DB::table('pages')->where('id', '=', $id)->count() == 0) {
            return view('errors.404');
        }

        $children = Menupage::where('parent_id', '=', $id)->get();
        foreach ($children as $child) {
            Menupage_i18n::where('page_id', '=', $child->id)->delete();
        }

        Menupage_i18n::where('page_id', '=', $id)->delete();
        Menupage::where('parent_id', '=', $id)->delete();
        Menupage::where('id', '=', $id)->delete();

        return redirect()->route('paper.browser')
            ->with('success', '刪除資料成功');

    }

    public function news_add()
    {
        $languages = DB::table('languages')->get();
        $hours = array();
        $minuteSeconds = array();
        for ($i = 0; $i < 60; $i++) {
            $num = sprintf("%02d", $i);
            if ($i < 24) {
                $hours[$num] = $num;
            }

            $minuteSeconds[$num] = $num;
        }
        return view('news_add')->with('hours', $hours)->with('minuteSeconds', $minuteSeconds)->with('languages', $languages);
    }

    public function news_add_post(Request $request)
    {
        //Log::info('data -----------------------' . dump($input_data));
        $rules = array(
            'publish_time' => 'required',
            'title' => 'required'
        );

        $messages = array(
            'publish_time.required' => '<p>．請輸入公告時間。</p>',
            'title.required' => '<p>．請輸入標題。</p>',
            'content.required' => '<p>．請輸入內容。</p>'
        );

        $this->validate($request, $rules, $messages);

        $publish_time = trim(\Input::get('publish_time')) . " " . trim(\Input::get('hh')) . ":" . trim(\Input::get('mm')) . ":" . trim(\Input::get('ss'));
        $timedata = DB::select('select now() as timedata');
        $languages = DB::table('languages')->where('id', '>', 0)->get();

        $id = DB::table('news')->insertGetId(
            [
                'publish_time' => $publish_time,
                'title' => trim(\Input::get('title')),
                'content' => trim(\Input::get('content')),
                'view' => (boolean)\Input::get('view'),
                'note' => trim(\Input::get('note')),
                'created_at' => $timedata[0]->timedata,
                'updated_at' => $timedata[0]->timedata
            ]
        );

        for ($i = 0; $i < sizeof($languages); $i++) {
            DB::table('news_i18n')->insert(
                [
                    'news_id' => $id,
                    'language' => $languages[$i]->id,
                    'title' => trim(\Input::get($languages[$i]->id . '_title')),
                    'content' => trim(\Input::get($languages[$i]->id . '_content'))
                ]
            );
        }

        return redirect()->route('news.browser')
            ->with('success', '新增資料成功');


    }

    public function news_edit_id($id)
    {
        if (DB::table('news')->where('id', '=', $id)->count() == 0) {
            return view('errors.404');
        }

        $news = DB::table('news')->where('id', '=', $id)->get();
        $news_i18n = DB::table('news_i18n')->where('news_id', '=', $id)->get();
        $languages = DB::table('languages')->get();

        // 2016-03-20 11:30:33

        $newt = explode(" ", $news[0]->publish_time);


        list($hh, $mm, $ss) = explode(":", $newt[1]);
        $hh = sprintf("%02d", $hh);
        $mm = sprintf("%02d", $mm);
        $ss = sprintf("%02d", $ss);

        $hours = array();
        $minuteSeconds = array();
        for ($i = 0; $i < 60; $i++) {
            $num = sprintf("%02d", $i);
            if ($i < 24) {
                $hours[$num] = $num;
            }

            $minuteSeconds[$num] = $num;
        }

        $news[0]->publish_time = $newt[0];
        $news[0]->hh = $hh;
        $news[0]->mm = $mm;
        $news[0]->ss = $ss;

        return view('news_edit', [
            'news' => $news,
            'news_i18n' => $news_i18n,
            'languages' => $languages,
            'hours' => $hours,
            'minuteSeconds' => $minuteSeconds
        ]);
    }

    public function news_edit_post(Request $request, $id)
    {
        if (DB::table('news')->where('id', '=', $id)->count() == 0) {
            return view('errors.404');
        }

        $rules = array(
            'publish_time' => 'required',
            'title' => 'required'
        );

        $messages = array(
            'publish_time.required' => '<p>．請輸入公告時間。</p>',
            'title.required' => '<p>．請輸入標題。</p>',
            'content.required' => '<p>．請輸入內容。</p>'
        );

        $this->validate($request, $rules, $messages);

        $publish_time = trim(\Input::get('publish_time')) . " " . trim(\Input::get('hh')) . ":" . trim(\Input::get('mm')) . ":" . trim(\Input::get('ss'));
        $timedata = DB::select('select now() as timedata');
        $languages = DB::table('languages')->where('id', '>', 0)->get();

        DB::table('news')
            ->where('id', $id)
            ->update([
                'publish_time' => $publish_time,
                'title' => trim(\Input::get('title')),
                'content' => trim(\Input::get('content')),
                'view' => (boolean)\Input::get('view'),
                'note' => trim(\Input::get('note')),
                'created_at' => $timedata[0]->timedata,
                'updated_at' => $timedata[0]->timedata
            ]);

        for ($i = 0; $i < sizeof($languages); $i++) {
            if (DB::table('news_i18n')->where('news_id', '=', $id)->where('language', '=', $languages[$i]->id)->count() == 0) {
                DB::table('news_i18n')->insert(
                    [
                        'news_id' => $id,
                        'language' => $languages[$i]->id,
                        'title' => trim(\Input::get($languages[$i]->id . '_title')),
                        'content' => trim(\Input::get($languages[$i]->id . '_content'))
                    ]
                );
            } else {
                DB::table('news_i18n')
                    ->where('news_id', '=', $id)
                    ->where('language', '=', $languages[$i]->id)
                    ->update([
                        'news_id' => $id,
                        'title' => trim(\Input::get($languages[$i]->id . '_title')),
                        'content' => trim(\Input::get($languages[$i]->id . '_content'))
                    ]);
            }
        }

        return redirect()->route('news.browser')
            ->with('success', '更新資料成功');
    }

//    public function news_view_id($id)
//    {
//
//        $newid = trim($id);
//
//        $news = DB::table('news')->where('id', '=', $newid)->get();
//
//        return view('news_view')->with('news', $news);
//
//
//    }

    public function news_browser_id_delete($id)
    {
        if (DB::table('news')->where('id', '=', $id)->count() == 0) {
            return view('errors.404');
        }

        DB::table('news_i18n')->where('news_id', '=', $id)->delete();
        DB::table('news')->where('id', '=', $id)->delete();

        return redirect()->route('news.browser')
            ->with('success', '刪除資料成功');
    }

    public function books_add()
    {
        $languages = DB::table('languages')->get();
        return view('books_add')->with('languages', $languages);
    }

    public function books_add_post(Request $request)
    {
        $rules = null;
        $messages = null;
        $upload_option = (boolean)\Input::get('upload_option');
        if ($upload_option) {
            $rules = array(
                'book_name' => 'required',
                'url' => 'required|regex:/^http([s]?):\/\/.*/',
                'upload_file' => 'required|mimes:png,jpeg,gif'
            );

            $messages = array(
                'book_name.required' => '<p>．請輸入書名。</p>',
                'url.required' => '<p>．請輸入連結。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'upload_file.required' => '<p>．請上傳書封。</p>',
                'upload_file.mimes' => '<p>．請上傳書封。</p>'
            );
        } else {
            $rules = array(
                'book_name' => 'required',
                'url' => 'required|regex:/^http([s]?):\/\/.*/',
                'cover' => 'required|regex:/^http([s]?):\/\/.*/'
            );

            $messages = array(
                'book_name.required' => '<p>．請輸入書名。</p>',
                'url.required' => '<p>．請輸入連結。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'cover.required' => '<p>．請輸入書封。</p>',
                'cover.regex' => '<p>．圖檔網址格式必須為網址(含http://)。</p>'
            );
        }

        $this->validate($request, $rules, $messages);

        //Log::info("data --------------------------- " . dump($request));

        // 2 不用處理檔案 copy , 1 要處理檔案 copy

        $cover = null;

        if (\Input::hasFile('upload_file')) {

            $imageName = \Input::file('upload_file');

            $imageName = time() . "-" . $imageName->getClientOriginalName();

            \Input::file('upload_file')->move(
                base_path() . '/public/books/', $imageName
            );

            // width 固定

            $width = Image::make(base_path() . '/public/books/' . $imageName)->width();

            $height = Image::make(base_path() . '/public/books/' . $imageName)->height();

            $new_height = Config::get('app.books_image_width') * $height / $width;

//                Log::info('height - ' . $height . ', width - ' . $width . ", new_height " . $new_height);

            Image::make(base_path() . '/public/books/' . $imageName)
                ->resize(Config::get('app.books_image_width'), $new_height)
                ->save(public_path('books/' . $imageName));


            $cover = "books/$imageName";

        } else {
            $cover = trim(\Input::get('cover'));
        }

        $timedata = DB::select('select now() as timedata');
        $languages = DB::table('languages')->where('id', '>', 0)->get();

        $id = DB::table('book')->insertGetId(
            [
                'cover' => $cover,
                'upload_option' => $upload_option,
                'book_name' => \Input::get('book_name'),
                'url' => \Input::get('url'),
                'view' => \Input::get('view'),
                'rand_id' => \Input::get('rand_id'),
                'note' => \Input::get('note'),
                'created_at' => $timedata[0]->timedata,
                'updated_at' => $timedata[0]->timedata
            ]
        );

        for ($i = 0; $i < sizeof($languages); $i++) {
            DB::table('book_i18n')->insert(
                [
                    'book_id' => $id,
                    'language' => $languages[$i]->id,
                    'book_name' => trim(\Input::get($languages[$i]->id . '_book_name'))
                ]
            );
        }

        return redirect()->route('books.browser')
            ->with('success', '新增資料成功');
    }

    public function books_edit_id($id)
    {
        if (DB::table('book')->where('id', '=', $id)->count() == 0) {
            return view('errors.404');
        }

        $book = DB::table('book')->where('id', '=', $id)->get();

        $book_i18n = DB::table('book_i18n')->where('book_id', '=', $id)->get();
        $languages = DB::table('languages')->get();

        return view('books_edit')->with('book', $book)->with('book_i18n', $book_i18n)->with('languages', $languages);
    }

    public function books_edit_post(Request $request, $id)
    {
        if (DB::table('book')->where('id', '=', $id)->count() == 0) {
            return view('errors.404');
        }

        $book = DB::table('book')->where('id', '=', $id)->get();
        $db_upload_option = (boolean)$book[0]->upload_option;
        $upload_option = (boolean)\Input::get('upload_option');

        $rules = null;
        $messages = null;
        if ($db_upload_option && $upload_option) {
            $rules = array(
                'book_name' => 'required',
                'url' => 'required|regex:/^http([s]?):\/\/.*/',
                'upload_file' => 'mimes:png,jpeg,gif'
            );

            $messages = array(
                'book_name.required' => '<p>．請輸入書名。</p>',
                'url.required' => '<p>．請輸入連結。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'upload_file.mimes' => '<p>．請上傳書封。</p>'
            );
        } elseif ($db_upload_option && !$upload_option) {
            $rules = array(
                'book_name' => 'required',
                'url' => 'required|regex:/^http([s]?):\/\/.*/',
                'cover' => 'required|regex:/^http([s]?):\/\/.*/'
            );

            $messages = array(
                'book_name.required' => '<p>．請輸入書名。</p>',
                'url.required' => '<p>．請輸入連結。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'cover.required' => '<p>．請輸入書封。</p>',
                'cover.regex' => '<p>．圖檔網址格式必須為網址(含http://)。</p>'
            );
        } elseif (!$db_upload_option && $upload_option) {
            $rules = array(
                'book_name' => 'required',
                'url' => 'required|regex:/^http([s]?):\/\/.*/',
                'upload_file' => 'required|mimes:png,jpeg,gif'
            );

            $messages = array(
                'book_name.required' => '<p>．請輸入書名。</p>',
                'url.required' => '<p>．請輸入連結。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'upload_file.required' => '<p>．請上傳書封。</p>',
                'upload_file.mimes' => '<p>．請上傳書封。</p>'
            );
        } else {
            $rules = array(
                'book_name' => 'required',
                'url' => 'required|regex:/^http([s]?):\/\/.*/',
                'cover' => 'required|regex:/^http([s]?):\/\/.*/'
            );

            $messages = array(
                'book_name.required' => '<p>．請輸入書名。</p>',
                'url.required' => '<p>．請輸入連結。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'cover.required' => '<p>．請輸入書封。</p>',
                'cover.regex' => '<p>．圖檔網址格式必須為網址(含http://)。</p>'
            );
        }

        $this->validate($request, $rules, $messages);

        //Log::info("data --------------------------- " . dump($request));

        // 2 不用處理檔案 copy , 1 要處理檔案 copy

        $cover = '';

        if ($db_upload_option && $upload_option) {
            if (\Input::hasFile('upload_file')) {

                $imageName = \Input::file('upload_file');

                $imageName = time() . "-" . $imageName->getClientOriginalName();

                \Input::file('upload_file')->move(
                    base_path() . '/public/books/', $imageName
                );

                // width 固定

                $width = Image::make(base_path() . '/public/books/' . $imageName)->width();

                $height = Image::make(base_path() . '/public/books/' . $imageName)->height();

                $new_height = Config::get('app.books_image_width') * $height / $width;

//                Log::info('height - ' . $height . ', width - ' . $width . ", new_height " . $new_height);

                Image::make(base_path() . '/public/books/' . $imageName)
                    ->resize(Config::get('app.books_image_width'), $new_height)
                    ->save(public_path('books/' . $imageName));


                $cover = "books/$imageName";

                // 需要刪除舊有 image 檔案

                File::delete(Config::get('app.books_image_folder') . $book[0]->cover);
            } else {
                $cover = $book[0]->cover;
            }

        } elseif ($db_upload_option && !$upload_option) {

            $cover = \Input::get('cover');

            // 需要刪除舊有 image 檔案

            File::delete(Config::get('app.books_image_folder') . $book[0]->cover);

        } elseif (!$db_upload_option && $upload_option) {

            $imageName = \Input::file('upload_file');

            $imageName = time() . "-" . $imageName->getClientOriginalName();

            \Input::file('upload_file')->move(
                base_path() . '/public/books/', $imageName
            );

            // width 固定

            $width = Image::make(base_path() . '/public/books/' . $imageName)->width();

            $height = Image::make(base_path() . '/public/books/' . $imageName)->height();

            $new_height = Config::get('app.books_image_width') * $height / $width;

//                Log::info('height - ' . $height . ', width - ' . $width . ", new_height " . $new_height);

            Image::make(base_path() . '/public/books/' . $imageName)
                ->resize(Config::get('app.books_image_width'), $new_height)
                ->save(public_path('books/' . $imageName));


            $cover = "books/$imageName";

        } else {
            $cover = \Input::get('cover');
        }

        $timedata = DB::select('select now() as timedata');
        $languages = DB::table('languages')->where('id', '>', 0)->get();

        DB::table('book')
            ->where('id', $id)
            ->update([
                    'cover' => $cover,
                    'upload_option' => $upload_option,
                    'book_name' => \Input::get('book_name'),
                    'url' => \Input::get('url'),
                    'view' => \Input::get('view'),
                    'rand_id' => \Input::get('rand_id'),
                    'note' => \Input::get('note'),
                    'updated_at' => $timedata[0]->timedata
                ]
            );

        for ($i = 0; $i < sizeof($languages); $i++) {
            if (DB::table('book_i18n')->where('book_id', '=', $id)->where('language', '=', $languages[$i]->id)->count() == 0) {
                DB::table('book_i18n')->insert(
                    [
                        'book_id' => $id,
                        'language' => $languages[$i]->id,
                        'book_name' => trim(\Input::get($languages[$i]->id . '_book_name'))
                    ]
                );
            } else {
                DB::table('book_i18n')
                    ->where('book_id', '=', $id)
                    ->where('language', '=', $languages[$i]->id)
                    ->update([
                        'book_id' => $id,
                        'book_name' => trim(\Input::get($languages[$i]->id . '_book_name'))
                    ]);
            }
        }

        return redirect()->route('books.browser')
            ->with('success', '更新資料成功');
    }

//    public function books_view_id($id)
//    {
//        $newid = trim($id);
//
//        $book = DB::table('book')->where('id', '=', $newid)->get();
//
//        return view('books_view')->with('book', $book);
//
//    }

    public function books_browser_id_delete($id)
    {
        if (DB::table('book')->where('id', '=', $id)->count() == 0) {
            return view('errors.404');
        }

        $book = DB::table('book')->where('id', '=', $id)->get();
        File::delete(Config::get('app.books_image_folder') . $book[0]->cover);

        DB::table('book_i18n')->where('book_id', '=', $id)->delete();
        DB::table('book')->where('id', '=', $id)->delete();

        return redirect()->route('books.browser')
            ->with('success', '刪除資料成功');
    }

//    public function db_browser_id($id)
//    {
//        $newid = trim($id);
//
//        $querydatabase = DB::table('querydatabase')->where('id', '=', $newid)->get();
//
//        return view('db_view')->with('querydatabase', $querydatabase);
//        //        return view('db_view');
//
//    }

    public function admin_add_post(Request $request)
    {


        if (Auth::user()->perm == 1) {

            $this->validate($request, [
                'email' => 'required',
                'password' => 'required'
            ]);

            $input_data = $request->all();

            //   Log::info('data ------------------------- ' . dump($input_data));

            //   exit;

            $email = trim($input_data['email']);

            $password = bcrypt(trim($input_data['password']));

            $perm = trim($input_data['perm']);

            $lock = trim($input_data['lock']);

            $note = trim($input_data['note']);

            $add_users = DB::table('users')->where('email', '=', $email)->get();

            if ($add_users) {

                return redirect()->route('admin.add')
                    ->with('error', $email . ' 帳號已存在');


            } else {


                if (preg_match("|^[-_.0-9a-z]+@([-_0-9a-z][-_0-9a-z]+\.)+[a-z]{2,3}$|i", $email)) {

                    DB::table('users')->insert([
                        'email' => $email,
                        'password' => $password,
                        'perm' => $perm,
                        'lock' => $lock,
                        'note' => $note
                    ]);

                    return redirect()->route('admin.browser')
                        ->with('success', '新增 ' . $email . ' 帳號成功');
                } else {

                    return redirect()->route('admin.add')
                        ->with('error', $email . ' 格式不合法');

                }

            }

        } else {
            return view('errors.404');
        }


    }

    public function admin_add()
    {
        //   input::flash();

        //   Session::reflash();
        if (Auth::user()->perm == 1) {
            return view('admin_add');
        } else {
            return view('errors.404');
        }

    }

    public function admin_post_edit(Request $request)
    {

        if (Auth::user()->perm == 1) {

//            $this->validate($request, [
//                'ico' => 'mimes:ico',
//                'logo' => 'mimes:png'
//            ]);            

            $input_data = $request->all();

            //Log::info('data ------------------------- ' . dump($input_data));

            $password = trim($input_data['password']);

            $perm = trim($input_data['perm']);

            $lock = trim($input_data['lock']);

            $note = trim($input_data['note']);

            $id = trim($input_data['id']);

            $timedata = DB::select('select now() as timedata');

            //Log::info('timedata ------------------------- ' . dump($timedata[0]->timedata));

            //exit;

            if ($password) {

                DB::table('users')
                    ->where('id', $id)
                    ->update([
                        'password' => bcrypt($password),
                        'perm' => $perm,
                        'lock' => $lock,
                        'note' => $note,
                        'updated_at' => $timedata[0]->timedata
                    ]);


            } else {

                DB::table('users')
                    ->where('id', $id)
                    ->update([
                        'perm' => $perm,
                        'lock' => $lock,
                        'note' => $note,
                        'updated_at' => $timedata[0]->timedata
                    ]);

            }

            return redirect()->route('admin.browser')
                ->with('success', '更新帳號成功');

        } else {
            return view('errors.404');
        }

    }

    public function admin_edit($id)
    {

        if (Auth::user()->perm == 1) {
            $newid = trim($id);

            $user = DB::table('users')->where('id', '=', $newid)->get();

            //Log::info('data -------------------------------- '. dump($user));

            return view('admin_edit')->with('user', $user);
        } else {
            return view('errors.404');
        }

    }

//    public function admin_view($id)
//    {
//
//        if(Auth::user()->perm == 1)
//        {
//            $newid = trim($id);
//
//            $user = DB::table('users')->where('id', '=', $newid)->get();
//
//            //Log::info('data ------------------ ' . dump($user));
//
//            //exit;
//
//            return view('admin_view')->with('user', $user);
//        }
//        else
//        {
//            return view('errors.404');
//        }
//
//    }

    public function admin_browser_id_delete($id)
    {

        if (Auth::user()->perm == 1) {
            $newid = trim($id);

            $perm = DB::table('users')->where('id', '=', $newid)->get();

            if ($perm[0]->perm == 1) {

                return redirect()->route('admin.browser')
                    ->with('error', '無法刪除最高管理者帳號');

            } elseif ($perm[0]->perm == 2) {
                DB::table('users')->where('id', '=', $newid)->delete();

                return redirect()->route('admin.browser')
                    ->with('success', '刪除帳號成功');
            }
        } else {
            return view('errors.404');
        }

    }

    public function admin_browser()
    {


        if (Auth::user()->perm == 1) {
            $user = DB::table('users')
                ->orderBy('id', 'desc')
                ->paginate(Config::get('app.pages_config'));


            //Log::info('user data ----------------- ' . dump($user[0]->email));

            return view('admin_browser')->with('user', $user);
        } else {
            return view('errors.404');
        }


    }

    public function index()
    {
        // 任何管理員都可以

//        $user =  DB::table('users')
//                    ->orderBy('id', 'desc')
//                    ->get();                    

        $querydatabase = DB::table('querydatabase')
            ->orderBy('rank_id', 'desc')
            ->paginate(Config::get('app.pages_config'));
//                            ->get();

        //Log::info('querydatabase ------------------------ ' . dump($querydatabase));

        return view('db_browser')->with('querydatabase', $querydatabase);


        //Log::info('user data ----------------- ' . dump($user[0]->email));

//        return view('db_browser')->with('user', $user);

    }

    public function sys_edit()
    {
        if (Auth::user()->perm == 1) {
            $languages = DB::table('languages')->get();

            //Log::info('sys data --------------------------- ' . dump($webconfig));

            return view('sys_edit')->with('languages', $languages);
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit_next()
    {
        if (Auth::user()->perm == 1) {
            DB::table('languages')
                ->where('id', 0)
                ->update([
                    'sort' => \Input::get('sort')
                ]);

            $languages = DB::table('languages')->where('id', '>', 0)->get();
            for ($i = 0; $i < sizeof($languages); $i++) {
                DB::table('languages')
                    ->where('id', $languages[$i]->id)
                    ->update([
                        'display' => (boolean)\Input::get($languages[$i]->id . '_display'),
                        'sort' => \Input::get($languages[$i]->id . '_sort')
                    ]);
            }


            return redirect()->route('sys.edit.2');
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit_2()
    {
        if (Auth::user()->perm == 1) {
            $webconfig = DB::table('webconfig')->get();
            $webconfig_i18n = DB::table('webconfig_i18n')->get();
            $languages = DB::table('languages')->get();
            //Log::info('sys data --------------------------- ' . dump($webconfig));

            return view('sys_edit_2')->with('webconfig', $webconfig)->with('webconfig_i18n', $webconfig_i18n)->with('languages', $languages);
        } else {
            return view('errors.404');
        }

    }

    public function sys_edit_2_next(Request $request)
    {
        if (Auth::user()->perm == 1) {

            $rules = array(
                'site_name' => 'required'
            );

            $messages = array(
                'site_name.required' => '．請輸入網站名稱。'
            );

            $this->validate($request, $rules, $messages);

            $languages = DB::table('languages')->where('id', '>', 0)->get();
            $timedata = DB::select('select now() as timedata');

            DB::table('webconfig')
                ->where('id', 1)
                ->update([
                    'site_name' => trim(\Input::get('site_name')),
                    'updated_at' => $timedata[0]->timedata
                ]);

            for ($i = 0; $i < sizeof($languages); $i++) {
                if (DB::table('webconfig_i18n')->where('language', '=', $languages[$i]->id)->count() == 0) {
                    DB::table('webconfig_i18n')
                        ->insert([
                            'language' => $languages[$i]->id,
                            'site_name' => trim(\Input::get($languages[$i]->id . '_site_name'))
                        ]);
                } else {
                    DB::table('webconfig_i18n')
                        ->where('language', $languages[$i]->id)
                        ->update([
                            'site_name' => trim(\Input::get($languages[$i]->id . '_site_name'))
                        ]);
                }
            }

            return redirect()->route('sys.edit.3');
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit_3()
    {
        if (Auth::user()->perm == 1) {
            $languages = DB::table('languages')->get();
            //Log::info('sys data --------------------------- ' . dump($webconfig));

            return view('sys_edit_3')->with('languages', $languages);
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit_3_next()
    {
        if (Auth::user()->perm == 1) {
            $languages = DB::table('languages')->where('id', '>', 0)->get();
            $timedata = DB::select('select now() as timedata');

            if (\Input::hasFile('logo')) {
                \Input::file('logo')->move(
                    base_path() . '/public/img/', "logo.png"
                );

                Image::make(base_path() . '/public/img/' . "logo.png")
                    ->resize(Config::get('app.logo_image_width'), Config::get('app.logo_image_height'))
                    ->save(public_path('img/' . "logo.png"));
            }

            DB::table('webconfig')
                ->where('id', 1)
                ->update([
                    'logo' => "logo.png",
                    'updated_at' => $timedata[0]->timedata
                ]);

            for ($i = 0; $i < sizeof($languages); $i++) {
                if (\Input::hasFile($languages[$i]->id . '_logo')) {
                    \Input::file($languages[$i]->id . '_logo')->move(
                        base_path() . '/public/img/', "logo_" . $languages[$i]->id . ".png"
                    );

                    Image::make(base_path() . '/public/img/' . "logo_" . $languages[$i]->id . ".png")
                        ->resize(Config::get('app.logo_image_width'), Config::get('app.logo_image_height'))
                        ->save(public_path('img/' . "logo_" . $languages[$i]->id . ".png"));
                }

                if (DB::table('webconfig_i18n')->where('language', '=', $languages[$i]->id)->count() == 0) {
                    DB::table('webconfig_i18n')
                        ->insert([
                            'language' => $languages[$i]->id,
                            'logo' => "logo_" . $languages[$i]->id . ".png"
                        ]);
                } else {
                    DB::table('webconfig_i18n')
                        ->where('language', $languages[$i]->id)
                        ->update([
                            'logo' => "logo_" . $languages[$i]->id . ".png"
                        ]);
                }
            }

            // width 固定

            //$width = Image::make( base_path() . '/public/img/' . $imageName )->width();

            //$height = Image::make( base_path() . '/public/img/' . $imageName )->height();

            //$new_height = Config::get('app.logo_image_width') * $height / $width;

            return redirect()->route('sys.edit.4');
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit_4()
    {
        if (Auth::user()->perm == 1) {
            $webconfig = DB::table('webconfig')->get();
            $webconfig_i18n = DB::table('webconfig_i18n')->get();
            $languages = DB::table('languages')->get();
            //Log::info('sys data --------------------------- ' . dump($webconfig));

            return view('sys_edit_4')->with('webconfig', $webconfig)->with('webconfig_i18n', $webconfig_i18n)->with('languages', $languages);
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit_4_next(Request $request)
    {
        if (Auth::user()->perm == 1) {

            $rules = array(
                'copyright' => 'required'
            );

            $messages = array(
                'copyright.required' => '．請輸入版權宣告。'
            );

            $this->validate($request, $rules, $messages);
            $languages = DB::table('languages')->where('id', '>', 0)->get();
            $timedata = DB::select('select now() as timedata');

            DB::table('webconfig')
                ->where('id', 1)
                ->update([
                    'copyright' => \Input::get('copyright'),
                    'updated_at' => $timedata[0]->timedata
                ]);

            for ($i = 0; $i < sizeof($languages); $i++) {
                if (DB::table('webconfig_i18n')->where('language', '=', $languages[$i]->id)->count() == 0) {
                    DB::table('webconfig_i18n')
                        ->insert([
                            'language' => $languages[$i]->id,
                            'copyright' => \Input::get($languages[$i]->id . '_copyright')
                        ]);
                } else {
                    DB::table('webconfig_i18n')
                        ->where('language', $languages[$i]->id)
                        ->update([
                            'copyright' => \Input::get($languages[$i]->id . '_copyright')
                        ]);
                }
            }
            return redirect()->route('sys.edit.5');
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit_5()
    {
        if (Auth::user()->perm == 1) {
            $webconfig = DB::table('webconfig')->get();

            //Log::info('sys data --------------------------- ' . dump($webconfig));

            return view('sys_edit_5')->with('webconfig', $webconfig);
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit_5_post()
    {
        if (Auth::user()->perm == 1) {
            $email = trim(\Input::get('email'));
            $icoName = "favicon.ico";

            if (\Input::hasFile('ico')) {

                \Input::file('ico')->move(
                    base_path() . '/public/img/', $icoName
                );

                Image::make(base_path() . '/public/img/' . $icoName)
                    ->resize(Config::get('app.ico_image_width'), Config::get('app.ico_image_height'))
                    ->save(public_path('img/' . $icoName));

            }

            if (preg_match("|^[-_.0-9a-z]+@([-_0-9a-z][-_0-9a-z]+\.)+[a-z]{2,3}$|i", $email)) {
                $timedata = DB::select('select now() as timedata');
                $color = trim(\Input::get('color'));

                for ($i = 1; $i <= 4; $i++) {
                    if ($i == 4) {
                        $color = 'S1';
                    } else {
                        if ($color == 'S' . $i) {
                            break;
                        }
                    }
                }

                DB::table('webconfig')
                    ->where('id', 1)
                    ->update([
                        'email' => $email,
                        'ico' => $icoName,
                        'color' => $color,
                        'note' => trim(\Input::get('note')),
                        'updated_at' => $timedata[0]->timedata
                    ]);

                return redirect()->route('sys.edit.5')->with('success', '資料更新成功');
            } else {
                return redirect()->route('sys.edit.5')
                    ->with('error', ' 請輸入符合格式之電子信箱')->withInput();
            }

        } else {
            return view('errors.404');
        }
    }

    public function db_browser()
    {

        $querydatabase = DB::table('querydatabase')
            ->orderBy('rank_id', 'desc')
//                            ->paginate(3);
            ->paginate(Config::get('app.pages_config'));

        //Log::info('querydatabase ------------------------ ' . dump($querydatabase));

        return view('db_browser')->with('querydatabase', $querydatabase);

    }

    public function db_browser_id_delete($id)
    {
        if (DB::table('querydatabase')->where('id', '=', $id)->count() == 0) {
            return view('errors.404');
        }

        DB::table('querydatabase_i18n')->where('db_id', '=', $id)->delete();
        DB::table('querydatabase')->where('id', '=', $id)->delete();

        return redirect()->route('db.browser')
            ->with('success', '刪除資料成功');

    }

    public function db_add()
    {
        $languages = DB::table('languages')->get();
        return view('db_add')->with('languages', $languages);
    }

    public function db_add_post(Request $request)
    {
        $rules = array(
            'database_name' => 'required',
            'syntax' => 'required'
        );

        $messages = array(
            'database_name.required' => '<p>．請輸入資料庫名稱。</p>',
            'syntax.required' => '<p>．請輸入嵌入語法。</p>'
        );

        $this->validate($request, $rules, $messages);

        //   Log::info('data --------------------- ' . dump($input_data));

        $timedata = DB::select('select now() as timedata');
        $languages = DB::table('languages')->where('id', '>', 0)->get();

        $id = DB::table('querydatabase')->insertGetId(
            [
                'database_name' => trim(\Input::get('database_name')),
                'syntax' => trim(\Input::get('syntax')),
                'view' => trim(\Input::get('view')),
                'rank_id' => trim(\Input::get('rank_id')),
                'note' => trim(\Input::get('note')),
                'created_at' => $timedata[0]->timedata,
                'updated_at' => $timedata[0]->timedata
            ]
        );

        for ($i = 0; $i < sizeof($languages); $i++) {
            DB::table('querydatabase_i18n')->insert(
                [
                    'db_id' => $id,
                    'language' => $languages[$i]->id,
                    'database_name' => trim(\Input::get($languages[$i]->id . '_database_name')),
                    'syntax' => trim(\Input::get($languages[$i]->id . '_syntax'))

                ]
            );
        }

        return redirect()->route('db.browser')
            ->with('success', '新增資料成功');
    }

    public function db_edit_id($id)
    {
        if (DB::table('querydatabase')->where('id', '=', $id)->count() == 0) {
            return view('errors.404');
        }

        $querydatabase = DB::table('querydatabase')->where('id', '=', $id)->get();
        $querydatabase_i18n = DB::table('querydatabase_i18n')->where('db_id', '=', $id)->get();
        $languages = DB::table('languages')->get();

        return view('db_edit')->with('querydatabase', $querydatabase)->with('querydatabase_i18n', $querydatabase_i18n)->with('languages', $languages);

    }

    public function db_edit_post(Request $request, $id)
    {
        if (DB::table('querydatabase')->where('id', '=', $id)->count() == 0) {
            return view('errors.404');
        }

        $rules = array(
            'database_name' => 'required',
            'syntax' => 'required'
        );

        $messages = array(
            'database_name.required' => '<p>．請輸入資料庫名稱。</p>',
            'syntax.required' => '<p>．請輸入嵌入語法。</p>'
        );

        $this->validate($request, $rules, $messages);

        //   Log::info('data --------------------- ' . dump($input_data));

        //   exit;

        $timedata = DB::select('select now() as timedata');
        $languages = DB::table('languages')->where('id', '>', 0)->get();

        DB::table('querydatabase')
            ->where('id', $id)
            ->update([
                'database_name' => trim(\Input::get('database_name')),
                'syntax' => trim(\Input::get('syntax')),
                'view' => trim(\Input::get('view')),
                'rank_id' => trim(\Input::get('rank_id')),
                'note' => trim(\Input::get('note')),
                'updated_at' => $timedata[0]->timedata
            ]);

        for ($i = 0; $i < sizeof($languages); $i++) {
            if (DB::table('querydatabase_i18n')->where('db_id', '=', $id)->where('language', '=', $languages[$i]->id)->count() == 0) {
                DB::table('querydatabase_i18n')->insert(
                    [
                        'db_id' => $id,
                        'language' => $languages[$i]->id,
                        'database_name' => trim(\Input::get($languages[$i]->id . '_database_name')),
                        'syntax' => trim(\Input::get($languages[$i]->id . '_syntax'))
                    ]
                );
            } else {
                DB::table('querydatabase_i18n')
                    ->where('db_id', '=', $id)
                    ->where('language', '=', $languages[$i]->id)
                    ->update([
                        'database_name' => trim(\Input::get($languages[$i]->id . '_database_name')),
                        'syntax' => trim(\Input::get($languages[$i]->id . '_syntax'))
                    ]);
            }
        }

        return redirect()->route('db.browser')
            ->with('success', '更新資料成功');

    }

    public function books_browser()
    {

        $book = DB::table('book')
            ->orderBy('rand_id', 'desc')
//                    ->paginate(3);
            ->paginate(Config::get('app.pages_config'));

        return view('books_browser')->with('book', $book);

    }

    public function news_browser()
    {

        $news = DB::table('news')
            ->orderBy('publish_time', 'desc')
            ->paginate(Config::get('app.pages_config'));

        return view('news_browser')->with('news', $news);

    }

    public function paper_browser()
    {
        $perPage = Config::get('app.pages_config');
        $totalPage = ceil(Menupage::count() / $perPage);

        $page = intval(\Input::get('page'));
        if ($page <= 0) {
            $page = 1;
        } elseif ($page > $totalPage) {
            $page = $totalPage;
        }

        $offset = ($page - 1) * $perPage;

        $sql = 'CALL showChildLst(' . $offset . ',' . $perPage . ')';
        $pdo = new \PDO("mysql:host=" . DB::getConfig('host') . ";dbname=" . DB::getDatabaseName(),
            DB::getConfig('username'), DB::getConfig('password'));
        $menus = $pdo->query($sql)->fetchAll();

        return view('paper_browser')->with('menus', $menus)->with('totalPage', $totalPage)->with('page', $page);
    }

    public function lang_edit_label($label)
    {
        $languages = DB::table('languages')->get();
        $record = DB::table('label_update_time')->where('label', '=', $label)->get();

        $table = new \SplFixedArray(sizeof(array_slice((array)$languages[0], 5)));
        if ($label >= sizeof($table)) {
            return view('errors.404');
        }

        for ($i = 0; $i < sizeof($table); $i++) {
            $table[$i] = new \SplFixedArray(sizeof($languages));
        }

        for ($j = 0; $j < sizeof($languages); $j++) {
            $language_array = array_slice((array)$languages[$j], 5);
            $index_array = array_values($language_array);

            for ($i = 0; $i < sizeof($language_array); $i++) {
                $table[$i][$j] = $index_array[$i];
            }
        }

        $row = $table[$label];

        return view('lang_edit')->with('languages', $languages)->with('row', $row)->with('label', $label)->with('record', $record);
    }

    public function lang_edit_post(Request $request, $label)
    {
        $languages = DB::table('languages')->get();

        $table = new \SplFixedArray(sizeof(array_slice((array)$languages[0], 5)));
        if ($label >= sizeof($table)) {
            return view('errors.404');
        }

        $rules = array(
            '0_title' => 'required'
        );

        $messages = array(
            '0_title.required' => '<p>．請輸入繁體中文訊息名稱。</p>'
        );

        $this->validate($request, $rules, $messages);

        $columns = \Schema::getColumnListing('languages');
        $timedata = DB::select('select now() as timedata');

        for ($i = 0; $i < sizeof($languages); $i++) {
            $signal = Input::get($i . '_title');
            $lang_array = (array)$languages[$i];
            $index = 5 + $label;

            $values = array_combine(array_values($columns), array_values($lang_array));
            $values[$columns[$index]] = $signal;

            DB::table('languages')->where('id', '=', $languages[$i]->id)->update($values);

        }

        if (DB::table('label_update_time')->where('label', '=', $label)->count() == 0) {
            DB::table('label_update_time')->insert([
                'label' => $label,
                'updated_at' => $timedata[0]->timedata
            ]);
        } else {
            DB::table('label_update_time')
                ->where('label', '=', $label)
                ->update([
                    'updated_at' => $timedata[0]->timedata
                ]);
        }

        return redirect()->route('lang.browser')->with('success', '更新資料成功');
    }

    public function lang_browser()
    {
        $languages = DB::table('languages')->get();

        $table = new \SplFixedArray(sizeof(array_slice((array)$languages[0], 5)));

        for ($i = 0; $i < sizeof($table); $i++) {
            $table[$i] = new \SplFixedArray(sizeof($languages));
        }

        for ($j = 0; $j < sizeof($languages); $j++) {
            $language_array = array_slice((array)$languages[$j], 5);
            $index_array = array_values($language_array);

            for ($i = 0; $i < sizeof($language_array); $i++) {
                $table[$i][$j] = $index_array[$i];
            }
        }

        return view('lang_browser')->with('languages', $languages)->with('table', $table);
    }

    public
    function my_info()
    {
        $user = Auth::user();

        return view('my_info', [
            'email' => $user['attributes']['email'],
            'perm' => $user['attributes']['perm']
        ]);


    }

    public
    function state_A()
    {


//User {#245 ▼
//  #table: "users"
//  #fillable: array:3 [▶]
//  #hidden: array:2 [▶]
//  #connection: null
//  #primaryKey: "id"
//  #perPage: 15
//  +incrementing: true
//  +timestamps: true
//  #attributes: array:10 [▼
//    "id" => "5"
//    "name" => "koha"
//    "email" => "koha@sydt.com.tw"
//    "password" => "$2y$10$UcRrAb.d/UiVgoOXLnmqvufwyFxsNDp6sDOG33hCMH9MI2ZHgDHAe"
//    "lock" => "0"
//    "note" => ""
//    "remember_token" => "8To4WCeUlt0mq0RDvJ9ZfSELK4UIOnVpGDj6L5JecjRqHWcWREaAcO9FfQsQ"
//    "perm" => "1"
//    "created_at" => "2015-10-05 11:11:43"
//    "updated_at" => "2015-10-27 13:48:38"
//  ]

//        $data = Auth::user();

//        Log::info("ddddddddddddddddd". dump($data));

        //Log::info("ddddd --------------------- ". dump($data['attributes']['email']));

        $results = DB::select('select date_format(date_add( now(), interval -1 month), \'%Y\') as Year');

        $Year = $results[0]->Year;

        $results = DB::select('select date_format(date_add( now(), interval -1 month), \'%m\') as Month         ');

        $Month = $results[0]->Month;

        //        Log::info('data -------------- ' . dump($results));

        $report = DB::select('SELECT
            yearmonth, 
            account_userid, 
            users.perm,
            users.lock,
            login, 
            logout 
            FROM month_backend_login_stat
            LEFT JOIN
            users
            ON month_backend_login_stat.account_userid
            = users.email
            WHERE yearmonth like ?', ['%' . $Year . '-' . $Month . '%']
        );

        //        Log::info('data ------------------- ' . dump($report));
        //        exit;

        return view('state_A', [
            'Year' => $Year,
            'Month' => $Month,
            'report' => $report
        ]);

    }


    public
    function state_C()
    {

        $results = DB::select('select date_format(date_add( now(), interval -1 month), \'%Y\') as Year');

        $Year = $results[0]->Year;

        $results = DB::select('select date_format(date_add( now(), interval -1 month), \'%m\') as Month         ');

        $Month = $results[0]->Month;


        $report = DB::select('SELECT *
            FROM month_login_pages_stat
            WHERE yearmonth like ?', ['%' . $Year . '-' . $Month . '%']
        );

        //        Log::info('data ------------------- ' . dump($report));
        //        exit;

        return view('state_C', [
            'Year' => $Year,
            'Month' => $Month,
            'report' => $report
        ]);


    }


    public
    function my_info_edit(Request $request)
    {
        $user = Auth::user();

        $email = trim($user['attributes']['email']);

        $input_data = $request->all();

        $password = bcrypt(trim($input_data['password']));

        $timedata = DB::select('select now() as timedata');

        if (trim($input_data['password'])) {

            DB::table('users')
                ->where('email', $email)
                ->update(['password' => $password, 'updated_at' => $timedata[0]->timedata]);
        }

        return redirect()->route('my.info')
            ->with('success', '密碼更新成功');

        //        Log::info("raw data ---------------- " . dump($input_data['password']));


    }


}
