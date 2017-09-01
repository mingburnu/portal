<?php

namespace App\Http\Controllers;

use App\Language;
use App\User;
use Auth;
use Config;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use Mail;
use PDF;

class AdminController extends Controller
{
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
                    \Lang::get('ui.year-month'), \Lang::get('ui.webpage name'), \Lang::get('ui.display'), \Lang::get('ui.click times')
                ));

                for ($i = 0; $i < count($report); $i++) {

                    $view = '';

                    if ($report[$i]->view == 1) {
                        $view = \Lang::get('ui.true');
                    } elseif ($report[$i]->view == 0) {
                        $view = \Lang::get('ui.false');
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
                    \Lang::get('ui.year-month'), \Lang::get('ui.account'), \Lang::get('ui.permission'), \Lang::get('ui.blockade'), \Lang::get('ui.login times'), \Lang::get('ui.logout times')
                ));

                for ($i = 0; $i < count($report); $i++) {


                    $perm = '';

                    if ($report[$i]->perm == 1) {
                        $perm = \Lang::get('ui.administrator');
                    } elseif ($report[$i]->perm == 2) {
                        $perm = \Lang::get('ui.standard user');
                    }

                    $lock = '';

                    if ($report[$i]->lock == 1) {
                        $lock = \Lang::get('ui.true');
                    } elseif ($report[$i]->lock == 0) {
                        $lock = \Lang::get('ui.false');
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

        $subject = $library_name[0]->site_name . " " . \Lang::get('ui.password email');

        $email = trim($email_data['email']);

        $rs_data = User::where('email', $email)->get();

        //Log::info('data ==================== ' . dump($rs_data));

        if (count($rs_data) > 0) {
            $password = str_random(12);

            // update data

            $timedata = DB::select('select now() as timedata');

            User::where('email', $email)
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
            $request->request->add(['mail' => Input::get('email'), 'pwd' => Input::get('password')]);
            $this->validate($request, [
                'mail' => 'required|email',
                'email' => 'unique:' . User::getModel()->getTable() . ',email',
                'pwd' => 'required',
                'password' => 'min:6'
            ]);

            $input_data = $request->all();

            //   Log::info('data ------------------------- ' . dump($input_data));

            //   exit;

            $email = trim($input_data['email']);

            $password = bcrypt(trim($input_data['password']));

            $perm = trim($input_data['perm']);

            $lock = trim($input_data['lock']);

            $note = trim($input_data['note']);

            User::insert([
                'email' => $email,
                'password' => $password,
                'perm' => $perm,
                'lock' => $lock,
                'note' => $note
            ]);

            return redirect()->route('admin.browser')
                ->with('successes', [\Lang::get('msg.add account successfully', ['account' => $email])]);

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
            $this->validate($request, [
                'password' => 'min:6'
            ]);

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
                User::whereId($id)
                    ->update([
                        'password' => bcrypt($password),
                        'perm' => $perm,
                        'lock' => $lock,
                        'note' => $note,
                        'updated_at' => $timedata[0]->timedata
                    ]);
            } else {
                User::whereId($id)
                    ->update([
                        'perm' => $perm,
                        'lock' => $lock,
                        'note' => $note,
                        'updated_at' => $timedata[0]->timedata
                    ]);
            }

            return redirect()->route('admin.browser')->with('successes', [\Lang::get('msg.modify account successfully')]);

        } else {
            return view('errors.404');
        }
    }

    public function admin_edit($id)
    {
        if (Auth::user()->perm == 1) {
            $newid = trim($id);

            $user = User::whereId($newid)->get();

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

            $perm = User::whereId($newid)->get();
            $validator = \Validator::make(['perm' => $perm[0]->perm], ['perm' => 'ne:1']);
            if ($validator->fails()) {
                return redirect()->route('admin.browser')->withErrors($validator);
            } elseif ($perm[0]->perm == 2) {
                User::whereId($newid)->delete();

                return redirect()->route('admin.browser')
                    ->with('successes', [\Lang::get('msg.delete account successfully')]);
            }
        } else {
            return view('errors.404');
        }
    }

    public function index()
    {
        return $this->admin_browser();
    }

    public function admin_browser()
    {
        if (Auth::user()->perm == 1) {
            $user = User::orderBy('id', 'desc')
                ->paginate(Config::get('app.pages_config'));


            //Log::info('user data ----------------- ' . dump($user[0]->email));

            return view('admin_browser')->with('user', $user);
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit()
    {
        if (Auth::user()->perm == 1) {
            $languages = Language::all();

            //Log::info('sys data --------------------------- ' . dump($webconfig));

            return view('sys_edit')->with('languages', $languages);
        } else {
            return view('errors.404');
        }
    }

    public function sys_edit_next()
    {
        if (Auth::user()->perm == 1) {
            Language::whereId(0)
                ->update([
                    'sort' => \Input::get('sort')
                ]);

            $languages = Language::where('id', '>', 0)->get();
            for ($i = 0; $i < sizeof($languages); $i++) {
                Language::whereId($languages[$i]->id)
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

            $this->validate($request, $rules);

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

    public function sys_edit_3_next(Request $request)
    {
        if (Auth::user()->perm == 1) {
            $languages = Language::where('id', '>', 0)->get();
            $timedata = DB::select('select now() as timedata');

            $rules = ['logo' => 'max:1024|image'];
            $messages = [];
            $customAttributes = ['logo' => Language::first()->language . '-' . \Lang::get('ui.logo image')];
            foreach ($languages as $language) {
                $rules = $rules + [$language->id . '_logo' => 'max:1024|image'];
                $messages = $messages + [
                        $language->id . '_logo.max' => \Lang::get('validation.custom.logo.max'),
                        $language->id . '_logo.image' => \Lang::get('validation.custom.logo.image'),
                    ];
                $customAttributes = $customAttributes + [
                        $language->id . '_logo' => $language->language . '-' . \Lang::get('ui.logo image')
                    ];
            }

            $validator = \Validator::make($request->all(), $rules, $messages, $customAttributes);
            if ($validator->fails()) {
                return redirect()->route('sys.edit.3')->withErrors($validator)->withInput();
            }

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

            $this->validate($request, $rules, [], [
                'copyright' => Language::first()->language . '-' . \Lang::get('ui.copyright content')
            ]);

            $languages = Language::where('id', '>', 0)->get();
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

            $validator = \Validator::make(['email' => $email], ['email' => 'email']);
            if ($validator->fails()) {
                return redirect()->route('sys.edit.5')->withErrors($validator)->withInput();
            }

            if (\Input::hasFile('ico')) {
                \Input::file('ico')->move(
                    base_path() . '/public/img/', $icoName
                );

                Image::make(base_path() . '/public/img/' . $icoName)
                    ->resize(Config::get('app.ico_image_width'), Config::get('app.ico_image_height'))
                    ->save(public_path('img/' . $icoName));

            }

            $timedata = DB::select('select now() as timedata');
            $color = trim(\Input::get('color'));
            $isCss = false;

            for ($i = 1; $i <= 7; $i++) {
                if ($color == 'S' . $i) {
                    $isCss = true;
                    break;
                }
            }

            if (!$isCss) {
                $color = 'S1';
            }

            DB::table('webconfig')
                ->where('id', 1)
                ->update([
                    'email' => $email,
                    'ico' => $icoName,
                    'color' => $color,
                    'play' => (boolean)\Input::get('play'),
                    'exhibition' => (boolean)\Input::get('exhibition'),
                    'count_visitors' => (boolean)\Input::get('count_visitors'),
                    'note' => trim(\Input::get('note')),
                    'updated_at' => $timedata[0]->timedata
                ]);

            return redirect()->route('sys.edit.5')->with('successes', [\Lang::get('msg.modify data successfully')]);

        } else {
            return view('errors.404');
        }
    }

    public function lang_edit_label($label)
    {
        $languages = DB::table(Language::getModel()->getTable())->get();
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
        $language_table_name = Language::getModel()->getTable();
        $languages = DB::table($language_table_name)->get();

        $table = new \SplFixedArray(sizeof(array_slice((array)$languages[0], 5)));
        if ($label >= sizeof($table)) {
            return view('errors.404');
        }

        $rules = array(
            '0_title' => 'required'
        );

        $this->validate($request, $rules, array(), ['0_title' => $languages[0]->language]);

        $columns = \Schema::getColumnListing($language_table_name);
        $timedata = DB::select('select now() as timedata');

        for ($i = 0; $i < sizeof($languages); $i++) {
            $signal = Input::get($i . '_title');
            $lang_array = (array)$languages[$i];
            $index = 5 + $label;

            $values = array_combine(array_values($columns), array_values($lang_array));
            $values[$columns[$index]] = $signal;

            DB::table($language_table_name)->where('id', '=', $languages[$i]->id)->update($values);

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

        return redirect()->route('lang.browser')->with('successes', [\Lang::get('msg.modify data successfully')]);
    }

    public function lang_browser()
    {
        $languages = DB::table(Language::getModel()->getTable())->get();

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
            ->with('successes', [\Lang::get('msg.modify password successfully')]);

        //        Log::info("raw data ---------------- " . dump($input_data['password']));
    }
}
