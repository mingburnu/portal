<?php

namespace App\Console;

use DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        // login_pages_stat
        $schedule->call(function () {
            DB::table('month_login_pages_stat')->truncate();
            $now = new \DateTime();
            $MD_1 = new \DateTime('2015-10-01 00:00:00');
            $MD_2 = new \DateTime($now->format('Y-m-01 00:00:00'));

            $sql = '';
            $betweens = array();
            while ($MD_1 < $MD_2) {
                $start = new \DateTime($MD_1->format('Y-m-d H:i:s'));
                $endOperator = new \DateTime($start->format('Y-m-d H:i:s'));
                $end = $endOperator->modify('+1 month')->modify('-1 second');

                $sql = $sql . 'SELECT title, view, created_at, sum(view_times) AS view_times FROM login_pages_stat '
                    . 'WHERE created_at between ? AND ? GROUP BY title ' . 'UNION ';

                $betweens[] = $start->format('Y-m-d H:i:s');
                $betweens[] = $end->format('Y-m-d H:i:s');

                $MD_1->modify('+1 month');
            }

            $sql = preg_replace('/UNION$/', '', trim($sql));
            $report = DB::select($sql, $betweens);

            $values = array();
            for ($i = 0; $i < count($report); $i++) {
                $yearmonth = new \DateTime($report[$i]->created_at);

                $values[] = [
                    'yearmonth' => $yearmonth->format('Y-m-t'),
                    'title' => $report[$i]->title,
                    'view' => $report[$i]->view,
                    'view_times' => $report[$i]->view_times
                ];
            }

            DB::table('month_login_pages_stat')->insert($values);

        })->cron('0 0 1 * *');


        // backend_login_stat
        $schedule->call(function () {
            DB::table('month_backend_login_stat')->truncate();
            $now = new \DateTime();
            $MD_1 = new \DateTime('2015-10-01 00:00:00');
            $MD_2 = new \DateTime($now->format('Y-m-01 00:00:00'));

            $sql = '';
            $betweens = array();
            while ($MD_1 < $MD_2) {
                $start = new \DateTime($MD_1->format('Y-m-d H:i:s'));
                $endOperator = new \DateTime($start->format('Y-m-d H:i:s'));
                $end = $endOperator->modify('+1 month')->modify('-1 second');

                $sql = $sql . 'SELECT backend_login_stat.account_userid , sum(backend_login_stat.login) AS login, sum(backend_login_stat.logout) AS logout , backend_login_stat.created_at ' .
                    'FROM backend_login_stat LEFT JOIN users ON backend_login_stat.account_userid = users.email ' .
                    'WHERE backend_login_stat.created_at between ? AND ? GROUP BY account_userid ' . 'UNION ';

                $betweens[] = $start->format('Y-m-d H:i:s');
                $betweens[] = $end->format('Y-m-d H:i:s');

                $MD_1->modify('+1 month');
            }

            $sql = preg_replace('/UNION$/', '', trim($sql));
            $report = DB::select($sql, $betweens);

            $values = array();
            for ($i = 0; $i < count($report); $i++) {
                $yearmonth = new \DateTime($report[$i]->created_at);

                $values[] = [
                    'yearmonth' => $yearmonth->format('Y-m-t'),
                    'account_userid' => $report[$i]->account_userid,
                    'login' => $report[$i]->login,
                    'logout' => $report[$i]->logout
                ];
            }

            DB::table('month_backend_login_stat')->insert($values);

        })->cron('0 0 1 * *');
    }
}