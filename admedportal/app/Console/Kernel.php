<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        // login_pages_stat
    
         $schedule->call(function () {

            $MD_1 = DB::select('SELECT
date_add( date(now()), INTERVAL -1 Month) AS first_day
');

            $MD_2 = DB::select('SELECT 
date_add( date(now()),INTERVAL -1 Day) AS final_day
');      

            $report = DB::select('SELECT
title, view, sum(view_times) AS view_times 
FROM login_pages_stat
WHERE created_at between ? AND ?
GROUP BY title', [ $MD_1[0]->first_day . ' 00:00:00', $MD_2[0]->final_day . ' 23:59:59' ]
);      

            for($i = 0; $i < count($report); $i++) {

                DB::table('month_login_pages_stat')->insert(
                    [
                        'yearmonth'     =>  $MD_2[0]->final_day,
                        'title'         =>  $report[$i]->title,
                        'view'          =>  $report[$i]->view,
                        'view_times'    =>  $report[$i]->view_times
                    ]
                );


        
            }

        })->cron('1 2 1 * *');
   

    // backend_login_stat

        $schedule->call(function () {

            $MD_1 = DB::select('SELECT
date_add( date(now()), INTERVAL -1 Month) AS first_day
');

            $MD_2 = DB::select('SELECT 
date_add( date(now()),INTERVAL -1 Day) AS final_day
');            

            $report = DB::select('SELECT 
backend_login_stat.account_userid , sum(backend_login_stat.login) AS login, sum(backend_login_stat.logout) AS logout , backend_login_stat.created_at 
FROM backend_login_stat 
LEFT JOIN users ON backend_login_stat.account_userid = users.email
WHERE backend_login_stat.created_at between ? AND ? 
GROUP BY account_userid', [ $MD_1[0]->first_day . ' 00:00:00', $MD_2[0]->final_day . ' 23:59:59']);

            for($i = 0; $i < count($report); $i++) {

                DB::table('month_backend_login_stat')->insert(
                    [
                        'yearmonth'           =>  $MD_2[0]->final_day,
                        'account_userid'      =>  $report[$i]->account_userid,
                        'login'               =>  $report[$i]->login,
                        'logout'              =>  $report[$i]->logout
                    ]
                );

            }


        })->cron('1 2 1 * *');
            
    }
}
