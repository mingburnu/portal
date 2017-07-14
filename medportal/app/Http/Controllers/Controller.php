<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){
        $webconfig = \DB::table('webconfig')->get();
        $webconfig_i18n = null;

        $lang_id = \Cookie::get('language');
        if ($lang_id != '0') {
            if ($lang_id == null || intval($lang_id) < 0 || sizeof(Language::whereId($lang_id)->whereDisplay(true)->get()) == 0) {
                $lang_id = Language::whereDisplay(true)->orderBy('sort', 'desc')->first()->id;
            }

            $webconfig_i18n = \DB::table('webconfig_i18n')->where('language', $lang_id)->get();
        }

        $signal = Language::whereId($lang_id)->get();
        $languages = Language::where('display', true)->orderBy('sort', 'desc')->lists('language', 'id');

        \View::share('webconfig', $webconfig);
        \View::share('webconfig_i18n', $webconfig_i18n);
        \View::share('signal', $signal);
        \View::share('languages', $languages);
    }
}
