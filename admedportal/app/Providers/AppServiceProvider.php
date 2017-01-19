<?php

namespace App\Providers;

use App\Menupage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('node', function ($attribute, $value, $parameters) {
            $parent_id = $value;
            if (trim($value) == "") {
                $parent_id = null;
            };

            if (Menupage::where('parent_id', '=', $this->app->request->id)->count() > 0) {
                return $parent_id == null;
            } else {
                $ids = Menupage::where('parent_id', '=', null)->where('id', '!=', $this->app->request->id)->lists('id')->toArray();
                return in_array($parent_id, $ids);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
