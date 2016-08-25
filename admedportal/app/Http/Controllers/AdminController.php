<?php

namespace App\Http\Controllers;

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

    public function paper_add_post(Request $request)
    {
        $paper = $request->all();

        $this->validate($request, [
            'title' => 'required'
        ]);

        //    Log::info('data ------------------ ' . dump($paper));

        $title = trim($paper['title']);

        $type = trim($paper['type']);

        $content = '';

        $url = '';

        if ($type == 1) {

            $content = trim($paper['content']);

        } elseif ($type == 2) {

            $url = trim($paper['url']);

        }


        $view = trim($paper['view']);

        $rank_id = trim($paper['rank_id']);

        $note = trim($paper['note']);

        DB::table('pages')->insert(
            [
                'title' => $title,
                'type' => $type,
                'content' => $content,
                'url' => $url,
                'view' => $view,
                'rank_id' => $rank_id,
                'note' => $note
            ]
        );

        return redirect()->route('paper.browser')
            ->with('success', '新增資料成功');


    }

    public function paper_add()
    {

        return view('paper_add');

    }

    public function paper_edit_post(Request $request)
    {
        $paper = $request->all();

        $this->validate($request, [
            'title' => 'required'
        ]);

        //        Log::info('data ......................... ' . dump($paper));

        $id = trim($paper['id']);

        $title = trim($paper['title']);

        $type = trim($paper['type']);

        $content = '';

        $url = '';

        if ($type == 1) {

            $content = trim($paper['content']);

        } elseif ($type == 2) {

            $url = trim($paper['url']);

        }

        $view = trim($paper['view']);

        $rank_id = trim($paper['rank_id']);

        $note = trim($paper['note']);

        $timedata = DB::select('select now() as timedata');


        DB::table('pages')
            ->where('id', $id)
            ->update([
                'title' => $title,
                'type' => $type,
                'content' => $content,
                'url' => $url,
                'view' => $view,
                'rank_id' => $rank_id,
                'note' => $note,
                'updated_at' => $timedata[0]->timedata
            ]);

        return redirect()->route('paper.browser')
            ->with('success', '更新資料成功');


    }

    public function paper_edit_id($id)
    {

        $newid = trim($id);

        $paper = DB::table('pages')->where('id', '=', $newid)->get();

        return view('paper_edit')->with('paper', $paper);

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

        $newid = trim($id);

        DB::table('pages')->where('id', '=', $newid)->delete();

        return redirect()->route('paper.browser')
            ->with('success', '刪除資料成功');


    }

    public function news_add_post(Request $request)
    {


        $input_data = $request->all();

        //Log::info('data -----------------------' . dump($input_data));

        $this->validate($request, [
            'publish_time' => 'required',
            'title' => 'required'
        ]);

        $publish_time = trim($input_data['publish_time']) . " " . trim($input_data['hh']) . ":" . trim($input_data['mm']) . ":" . trim($input_data['ss']);

        $title = trim($input_data['title']);

        $content = trim($input_data['content']);

        $view = trim($input_data['view']);

        //$rank_id = trim($input_data['rank_id']);

        $note = trim($input_data['note']);

        DB::table('news')->insert(
            [
                'publish_time' => $publish_time,
                'title' => $title,
                'content' => $content,
                'view' => $view,
                //    'rank_id'               => $rank_id,
                'note' => $note
            ]
        );

        return redirect()->route('news.browser')
            ->with('success', '新增資料成功');


    }

    public function news_add()
    {
        return view('news_add');
    }

    public function news_edit_post(Request $request)
    {

        $input_data = $request->all();

        $this->validate($request, [
            'publish_time' => 'required',
            'title' => 'required'
        ]);


        //Log::info('data -----------------------' . dump($input_data));

        $publish_time = trim($input_data['publish_time']) . " " . trim($input_data['hh']) . ":" . trim($input_data['mm']) . ":" . trim($input_data['ss']);

        $title = trim($input_data['title']);

        $content = trim($input_data['content']);

        $view = trim($input_data['view']);

        //$rank_id = trim($input_data['rank_id']);

        $note = trim($input_data['note']);

        $id = trim($input_data['id']);

        $timedata = DB::select('select now() as timedata');

        DB::table('news')
            ->where('id', $id)
            ->update([
                'publish_time' => $publish_time,
                'title' => $title,
                'content' => $content,
                'view' => $view,
                //'rank_id' => $rank_id,
                'note' => $note,
                'updated_at' => $timedata[0]->timedata
            ]);

        return redirect()->route('news.browser')
            ->with('success', '更新資料成功');


    }

    public function news_edit_id($id)
    {
        $newid = trim($id);

        $news = DB::table('news')->where('id', '=', $newid)->get();

        // 2016-03-20 11:30:33

        $newt = explode(" ", $news[0]->publish_time);

        list($hh, $mm, $ss) = explode(":", $newt[1]);

        $hh_a = [
            0 => "00", 1 => "01", 2 => "02", 3 => "03", 4 => "04", 5 => "05",
            6 => "06", 7 => "07", 8 => "08", 9 => "09", 10 => "10", 11 => "11",
            12 => "12", 13 => "13", 14 => "14", 15 => "15", 16 => "16", 17 => "17",
            18 => "18", 19 => "19", 20 => "20", 21 => "21", 22 => "22", 23 => "23",
        ];

        $mm_a = [
            0 => "00", 1 => "01", 2 => "02", 3 => "03", 4 => "04", 5 => "05",
            6 => "06", 7 => "07", 8 => "08", 9 => "09", 10 => "10", 11 => "11",
            12 => "12", 13 => "13", 14 => "14", 15 => "15", 16 => "16", 17 => "17",
            18 => "18", 19 => "19", 20 => "20", 21 => "21", 22 => "22", 23 => "23",
            24 => "24", 25 => "25", 26 => "26", 27 => "27", 28 => "28", 29 => "29",
            30 => "30", 31 => "31", 32 => "32", 33 => "33", 34 => "34", 35 => "35",
            36 => "36", 37 => "37", 38 => "38", 39 => "39", 40 => "40", 41 => "41",
            42 => "42", 43 => "43", 44 => "44", 45 => "45", 46 => "46", 47 => "47",
            48 => "48", 49 => "49", 50 => "50", 51 => "51", 52 => "52", 53 => "53",
            54 => "54", 55 => "55", 56 => "56", 57 => "57", 58 => "58", 59 => "59"
        ];

        $ss_a = [
            0 => "00", 1 => "01", 2 => "02", 3 => "03", 4 => "04", 5 => "05",
            6 => "06", 7 => "07", 8 => "08", 9 => "09", 10 => "10", 11 => "11",
            12 => "12", 13 => "13", 14 => "14", 15 => "15", 16 => "16", 17 => "17",
            18 => "18", 19 => "19", 20 => "20", 21 => "21", 22 => "22", 23 => "23",
            24 => "24", 25 => "25", 26 => "26", 27 => "27", 28 => "28", 29 => "29",
            30 => "30", 31 => "31", 32 => "32", 33 => "33", 34 => "34", 35 => "35",
            36 => "36", 37 => "37", 38 => "38", 39 => "39", 40 => "40", 41 => "41",
            42 => "42", 43 => "43", 44 => "44", 45 => "45", 46 => "46", 47 => "47",
            48 => "48", 49 => "49", 50 => "50", 51 => "51", 52 => "52", 53 => "53",
            54 => "54", 55 => "55", 56 => "56", 57 => "57", 58 => "58", 59 => "59"
        ];

        return view('news_edit', [
            'news' => $news,
            'publish_time' => $newt[0],
            'hh_a' => $hh_a,
            'hh' => $hh,
            'mm_a' => $mm_a,
            'mm' => $mm,
            'ss_a' => $ss_a,
            'ss' => $ss
        ]);


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
        $newid = trim($id);

        DB::table('news')->where('id', '=', $newid)->delete();

        return redirect()->route('news.browser')
            ->with('success', '刪除資料成功');

    }

    public function books_add()
    {
        return view('books_add');
    }

    public function books_add_post()
    {
        $msg = '';
        $rule1 = array(
            'book_name_ch' => 'required'
        );

        $rule2 = array(
            'url' => 'required'
        );

        $rule3 = array(
            'url' => 'regex:/^http([s]?):\/\/.*/'
        );

        $rule4 = null;
        $upload_option = (boolean)\Input::get('upload_option');
        if ($upload_option) {
            $rule4 = array(
                'upload_file' => 'required|mimes:png,jpeg,gif'
            );
        } else {
            $rule4 = array(
                'cover' => 'required'
            );
        }

        $rule5 = array(
            'cover' => 'regex:/^http([s]?):\/\/.*/'
        );

        if (\Validator::make(\Input::all(), $rule1)->fails()) {
            $msg .= '<p>．請輸入書名。</p>';
        }

        if (\Validator::make(\Input::all(), $rule2)->fails()) {
            $msg .= '<p>．請輸入連結。</p>';
        } else {
            if (\Validator::make(\Input::all(), $rule3)->fails()) {
                $msg .= '<p>．連結格式必須為網址(含http://)。</p>';
            }
        }

        if (\Validator::make(\Input::all(), $rule4)->fails()) {
            if ($upload_option) {
                $msg .= '<p>．請上傳書封。</p>';

            } else {
                $msg .= '<p>．請輸入書封。</p>';
            }
        } else {
            if (!$upload_option) {
                if (\Validator::make(\Input::all(), $rule5)->fails()) {
                    $msg .= '<p>．圖檔網址格式必須為網址(含http://)。</p>';
                }
            }
        }

        if ($msg != '') {
            return redirect()->route('books.add')->with('error', $msg)->withInput();

        }

        //Log::info("data --------------------------- " . dump($request));

        // 2 不用處理檔案 copy , 1 要處理檔案 copy

        $cover = '';

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
        DB::table('book')->insert(
            [
                'cover' => $cover,
                'upload_option' => $upload_option,
                'book_name_ch' => \Input::get('book_name_ch'),
                'book_name_cn' => \Input::get('book_name_cn'),
                'book_name_en' => \Input::get('book_name_en'),
                'book_name_jp' => \Input::get('book_name_jp'),
                'book_name_kr' => \Input::get('book_name_kr'),
                'url' => \Input::get('url'),
                'view' => \Input::get('view'),
                'rand_id' => \Input::get('rand_id'),
                'note' => \Input::get('note'),
                'created_at' => $timedata[0]->timedata,
                'updated_at' => $timedata[0]->timedata
            ]
        );

        return redirect()->route('books.browser')
            ->with('success', '新增資料成功');
    }

    public function books_edit_id($id)
    {

        $newid = trim($id);

        $book = DB::table('book')->where('id', '=', $newid)->get();

        $match = preg_match('/Http/i', $book[0]->cover);

//        return view('books_edit', ['book' => $book, 'match' => $match]);
        return view('books_edit')->with('book', $book);

    }

    public function books_edit_post($id)
    {
        $book = DB::table('book')->where('id', '=', $id)->get();
        $db_upload_option = (boolean)$book[0]->upload_option;
        $upload_option = (boolean)\Input::get('upload_option');
        $msg = '';

        $rule1 = array(
            'book_name_ch' => 'required'
        );

        $rule2 = array(
            'url' => 'required'
        );

        $rule3 = array(
            'url' => 'regex:/^http([s]?):\/\/.*/'
        );

        $rule4 = null;
        if ($db_upload_option && $upload_option) {
            $rule4 = array(
                'upload_file' => 'mimes:png,jpeg,gif'
            );
        } elseif ($db_upload_option && !$upload_option) {
            $rule4 = array(
                'cover' => 'required'
            );
        } elseif (!$db_upload_option && $upload_option) {
            $rule4 = array(
                'upload_file' => 'required|mimes:png,jpeg,gif'
            );
        } else {
            $rule4 = array(
                'cover' => 'required'
            );
        }

        $rule5 = array(
            'cover' => 'regex:/^http([s]?):\/\/.*/'
        );

        if (\Validator::make(\Input::all(), $rule1)->fails()) {
            $msg .= '<p>．請輸入書名。</p>';
        }

        if (\Validator::make(\Input::all(), $rule2)->fails()) {
            $msg .= '<p>．請輸入連結。</p>';
        } else {
            if (\Validator::make(\Input::all(), $rule3)->fails()) {
                $msg .= '<p>．連結格式必須為網址(含http://)。</p>';
            }
        }

        if ($db_upload_option && $upload_option) {
            if (\Validator::make(\Input::all(), $rule4)->fails()) {
                $msg .= '<p>．請上傳書封。</p>';
            }

        } elseif ($db_upload_option && !$upload_option) {
            if (\Validator::make(\Input::all(), $rule4)->fails()) {
                $msg .= '<p>．請輸入書封。</p>';
            } else {
                if (\Validator::make(\Input::all(), $rule5)->fails()) {
                    $msg .= '<p>．圖檔網址格式必須為網址(含http://)。</p>';
                }
            }
        } elseif (!$db_upload_option && $upload_option) {
            if (\Validator::make(\Input::all(), $rule4)->fails()) {
                $msg .= '<p>．請上傳書封。</p>';
            }
        } else {
            if (\Validator::make(\Input::all(), $rule4)->fails()) {
                $msg .= '<p>．請輸入書封。</p>';
            } else {
                if (\Validator::make(\Input::all(), $rule5)->fails()) {
                    $msg .= '<p>．圖檔網址格式必須為網址(含http://)。</p>';
                }
            }
        }

        if ($msg != '') {
            return redirect()->route('books.edit.post', $id)->with('error', $msg)->withInput();
        }

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
        DB::table('book')
            ->where('id', $id)
            ->update([
                    'cover' => $cover,
                    'upload_option' => $upload_option,
                    'book_name_ch' => \Input::get('book_name_ch'),
                    'book_name_cn' => \Input::get('book_name_cn'),
                    'book_name_en' => \Input::get('book_name_en'),
                    'book_name_jp' => \Input::get('book_name_jp'),
                    'book_name_kr' => \Input::get('book_name_kr'),
                    'url' => \Input::get('url'),
                    'view' => \Input::get('view'),
                    'rand_id' => \Input::get('rand_id'),
                    'note' => \Input::get('note'),
                    'updated_at' => $timedata[0]->timedata
                ]
            );

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
        $newid = trim($id);

        $book = DB::table('book')->where('id', '=', $newid)->get();

        DB::table('book')->where('id', '=', $newid)->delete();

        File::delete(Config::get('app.books_image_folder') . $book[0]->cover);

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

    public function db_browser_id_delete($id)
    {

        $newid = trim($id);

        DB::table('querydatabase')->where('id', '=', $newid)->delete();

        return redirect()->route('db.browser')
            ->with('success', '刪除資料成功');

    }

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
            $webconfig = DB::table('webconfig')->get();

            //Log::info('sys data --------------------------- ' . dump($webconfig));

            return view('sys_edit')->with('webconfig', $webconfig);
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit_next()
    {
        if (Auth::user()->perm == 1) {

            $timedata = DB::select('select now() as timedata');
            DB::table('webconfig')
                ->where('id', 1)
                ->update([
                    'cn_display' => \Input::get('cn_display'),
                    'en_display' => \Input::get('en_display'),
                    'jp_display' => \Input::get('jp_display'),
                    'kr_display' => \Input::get('kr_display'),
                    'ch_order' => \Input::get('ch_order'),
                    'cn_order' => \Input::get('cn_order'),
                    'en_order' => \Input::get('en_order'),
                    'jp_order' => \Input::get('jp_order'),
                    'kr_order' => \Input::get('kr_order'),
                    'updated_at' => $timedata[0]->timedata
                ]);

            return redirect()->route('sys.edit.2');
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit_2()
    {
        if (Auth::user()->perm == 1) {
            $webconfig = DB::table('webconfig')->get();

            //Log::info('sys data --------------------------- ' . dump($webconfig));

            return view('sys_edit_2')->with('webconfig', $webconfig);
        } else {
            return view('errors.404');
        }

    }

    public function sys_edit_2_next()
    {
        if (Auth::user()->perm == 1) {

            $rules = array(
                'site_name_ch' => 'required'
            );

            if (\Validator::make(\Input::all(), $rules)->fails()) {
                return redirect()->route('sys.edit.2')->with('error', '．請輸入網站名稱。')->withInput();
            }

            $timedata = DB::select('select now() as timedata');
            DB::table('webconfig')
                ->where('id', 1)
                ->update([
                    'site_name_ch' => trim(\Input::get('site_name_ch')),
                    'site_name_cn' => trim(\Input::get('site_name_cn')),
                    'site_name_en' => trim(\Input::get('site_name_en')),
                    'site_name_jp' => trim(\Input::get('site_name_jp')),
                    'site_name_kr' => trim(\Input::get('site_name_kr')),
                    'updated_at' => $timedata[0]->timedata
                ]);

            return redirect()->route('sys.edit.3');
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit_3()
    {
        if (Auth::user()->perm == 1) {

            //Log::info('sys data --------------------------- ' . dump($webconfig));

            return view('sys_edit_3');
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit_3_next()
    {
        if (Auth::user()->perm == 1) {
            $imageName_ch = "logo_ch.png";
            $imageName_cn = "logo_cn.png";
            $imageName_en = "logo_en.png";
            $imageName_jp = "logo_jp.png";
            $imageName_kr = "logo_kr.png";

            if (\Input::hasFile('logo_ch')) {
                \Input::file('logo_ch')->move(
                    base_path() . '/public/img/', $imageName_ch
                );
            }

            if (\Input::hasFile('logo_cn')) {
                \Input::file('logo_ch')->move(
                    base_path() . '/public/img/', $imageName_cn
                );
            }

            if (\Input::hasFile('logo_en')) {
                \Input::file('logo_en')->move(
                    base_path() . '/public/img/', $imageName_en
                );
            }

            if (\Input::hasFile('logo_jp')) {
                \Input::file('logo_jp')->move(
                    base_path() . '/public/img/', $imageName_jp
                );
            }

            if (\Input::hasFile('logo_kr')) {
                \Input::file('logo_kr')->move(
                    base_path() . '/public/img/', $imageName_kr
                );
            }

            // width 固定

            //$width = Image::make( base_path() . '/public/img/' . $imageName )->width();

            //$height = Image::make( base_path() . '/public/img/' . $imageName )->height();

            //$new_height = Config::get('app.logo_image_width') * $height / $width;

            Image::make(base_path() . '/public/img/' . $imageName_ch)
                ->resize(Config::get('app.logo_image_width'), Config::get('app.logo_image_height'))
                ->save(public_path('img/' . $imageName_ch));

            Image::make(base_path() . '/public/img/' . $imageName_cn)
                ->resize(Config::get('app.logo_image_width'), Config::get('app.logo_image_height'))
                ->save(public_path('img/' . $imageName_cn));

            Image::make(base_path() . '/public/img/' . $imageName_en)
                ->resize(Config::get('app.logo_image_width'), Config::get('app.logo_image_height'))
                ->save(public_path('img/' . $imageName_en));

            Image::make(base_path() . '/public/img/' . $imageName_jp)
                ->resize(Config::get('app.logo_image_width'), Config::get('app.logo_image_height'))
                ->save(public_path('img/' . $imageName_jp));

            Image::make(base_path() . '/public/img/' . $imageName_kr)
                ->resize(Config::get('app.logo_image_width'), Config::get('app.logo_image_height'))
                ->save(public_path('img/' . $imageName_kr));

            $timedata = DB::select('select now() as timedata');
            DB::table('webconfig')
                ->where('id', 1)
                ->update([
                    'logo_ch' => $imageName_ch,
                    'logo_cn' => $imageName_cn,
                    'logo_en' => $imageName_en,
                    'logo_jp' => $imageName_jp,
                    'logo_kr' => $imageName_kr,
                    'updated_at' => $timedata[0]->timedata
                ]);

            return redirect()->route('sys.edit.4');
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit_4()
    {
        if (Auth::user()->perm == 1) {
            $webconfig = DB::table('webconfig')->get();

            //Log::info('sys data --------------------------- ' . dump($webconfig));

            return view('sys_edit_4')->with('webconfig', $webconfig);
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit_4_next()
    {
        if (Auth::user()->perm == 1) {

            $rules = array(
                'copyright_ch' => 'required'
            );

            if (\Validator::make(\Input::all(), $rules)->fails()) {
                return redirect()->route('sys.edit.4')->with('error', '．請輸入版權宣告。')->withInput();
            }

            $timedata = DB::select('select now() as timedata');
            DB::table('webconfig')
                ->where('id', 1)
                ->update([
                    'copyright_ch' => \Input::get('copyright_ch'),
                    'copyright_cn' => \Input::get('copyright_cn'),
                    'copyright_en' => \Input::get('copyright_en'),
                    'copyright_jp' => \Input::get('copyright_jp'),
                    'copyright_kr' => \Input::get('copyright_kr'),
                    'updated_at' => $timedata[0]->timedata
                ]);

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
                DB::table('webconfig')
                    ->where('id', 1)
                    ->update([
                        'email' => $email,
                        'ico' => $icoName,
                        'color' => trim(\Input::get('color')),
                        'note' => trim(\Input::get('note')),
                        'updated_at' => $timedata[0]->timedata
                    ]);

                return redirect()->route('sys.edit.5')->with('success', '資料更新成功');
            } else {
                return redirect()->route('sys.edit.5')
                    ->with('error', $email . ' 格式不合法')->withInput();
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

    public function db_add()
    {
        return view('db_add');
    }

    public function db_add_post()
    {
        $msg = '';
        $rule1 = array(
            'database_name_ch' => 'required'
        );

        $rule2 = array(
            'syntax_ch' => 'required'
        );

        if (\Validator::make(\Input::all(), $rule1)->fails()) {
            $msg .= '<p>．請輸入資料庫名稱。</p>';
        }

        if (\Validator::make(\Input::all(), $rule2)->fails()) {
            $msg .= '<p>．請輸入嵌入語法。</p>';
        }

        if ($msg != '') {
            return redirect()->route('db.add')->with('error', $msg)->withInput();

        } else {

            //   Log::info('data --------------------- ' . dump($input_data));

            $timedata = DB::select('select now() as timedata');

            DB::table('querydatabase')->insert(
                [
                    'database_name_ch' => trim(\Input::get('database_name_ch')),
                    'database_name_cn' => trim(\Input::get('database_name_cn')),
                    'database_name_en' => trim(\Input::get('database_name_en')),
                    'database_name_jp' => trim(\Input::get('database_name_jp')),
                    'database_name_kr' => trim(\Input::get('database_name_kr')),
                    'syntax_ch' => trim(\Input::get('syntax_ch')),
                    'syntax_cn' => trim(\Input::get('syntax_cn')),
                    'syntax_en' => trim(\Input::get('syntax_en')),
                    'syntax_jp' => trim(\Input::get('syntax_jp')),
                    'syntax_kr' => trim(\Input::get('syntax_kr')),
                    'view' => trim(\Input::get('view')),
                    'rank_id' => trim(\Input::get('rank_id')),
                    'note' => trim(\Input::get('note')),
                    'created_at' => $timedata[0]->timedata,
                    'updated_at' => $timedata[0]->timedata
                ]
            );

            return redirect()->route('db.browser')
                ->with('success', '新增資料成功');
        }

    }

    public function db_edit_id($id)
    {

        $newid = trim($id);

        $querydatabase = DB::table('querydatabase')->where('id', '=', $newid)->get();

        return view('db_edit')->with('querydatabase', $querydatabase);

    }

    public function db_edit_post($id)
    {

        $msg = '';
        $rule1 = array(
            'database_name_ch' => 'required'
        );

        $rule2 = array(
            'syntax_ch' => 'required'
        );

        if (\Validator::make(\Input::all(), $rule1)->fails()) {
            $msg .= '<p>．請輸入資料庫名稱。</p>';
        }

        if (\Validator::make(\Input::all(), $rule2)->fails()) {
            $msg .= '<p>．請輸入嵌入語法。</p>';
        }

        if ($msg != '') {
            return redirect()->route('db.edit.id', $id)->with('error', $msg)->withInput();

        } else {

            //   Log::info('data --------------------- ' . dump($input_data));

            //   exit;

            $timedata = DB::select('select now() as timedata');

            DB::table('querydatabase')
                ->where('id', $id)
                ->update([
                    'database_name_ch' => trim(\Input::get('database_name_ch')),
                    'database_name_cn' => trim(\Input::get('database_name_cn')),
                    'database_name_en' => trim(\Input::get('database_name_en')),
                    'database_name_jp' => trim(\Input::get('database_name_jp')),
                    'database_name_kr' => trim(\Input::get('database_name_kr')),
                    'syntax_ch' => trim(\Input::get('syntax_ch')),
                    'syntax_cn' => trim(\Input::get('syntax_cn')),
                    'syntax_en' => trim(\Input::get('syntax_en')),
                    'syntax_jp' => trim(\Input::get('syntax_jp')),
                    'syntax_kr' => trim(\Input::get('syntax_kr')),
                    'view' => trim(\Input::get('view')),
                    'rank_id' => trim(\Input::get('rank_id')),
                    'note' => trim(\Input::get('note')),
                    'updated_at' => $timedata[0]->timedata
                ]);


            return redirect()->route('db.browser')
                ->with('success', '更新資料成功');

        }
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

        $pages = DB::table('pages')
            ->orderBy('rank_id', 'desc')
//                    ->get();
            ->paginate(Config::get('app.pages_config'));
//                    ->paginate(5);

        return view('paper_browser')->with('pages', $pages);

    }

    public function my_info()
    {
        $user = Auth::user();

        return view('my_info', [
            'email' => $user['attributes']['email'],
            'perm' => $user['attributes']['perm']
        ]);


    }

    public function state_A()
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


    public function state_C()
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


    public function my_info_edit(Request $request)
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
