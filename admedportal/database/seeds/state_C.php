<?php

use Illuminate\Database\Seeder;

class state_C extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('month_login_pages_stat')->truncate();

        DB::table('month_login_pages_stat')->insert([
            'yearmonth' => '2015-07-31',
            'title' => '考科藍新訊',
            'view' => 0,
            'view_times' => 106,
        ]);        


        DB::table('month_login_pages_stat')->insert([
            'yearmonth' => '2015-08-31',
            'title' => '首頁',
            'view' => 0,
            'view_times' => 5,
        ]);        

        DB::table('month_login_pages_stat')->insert([
            'yearmonth' => '2015-08-31',
            'title' => '考科藍新訊',
            'view' => 0,
            'view_times' => 106,
        ]);        




        DB::table('month_login_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'title' => '首頁',
            'view' => 0,
            'view_times' => 54,
        ]);        

        DB::table('month_login_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'title' => '考科藍新訊',
            'view' => 0,
            'view_times' => 876,
        ]);        

        DB::table('month_login_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'title' => '本館簡介',
            'view' => 1,
            'view_times' => 16,
        ]);        

        DB::table('month_login_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'title' => '館藏目錄查詢',
            'view' => 0,
            'view_times' => 85,
        ]);        


        DB::table('month_login_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'title' => '電子資源整合查詢',
            'view' => 0,
            'view_times' => 33,
        ]);        

        DB::table('month_login_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'title' => '申請館際合作',
            'view' => 0,
            'view_times' => 54,
        ]);        

        DB::table('month_login_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'title' => '相關醫學網站',
            'view' => 0,
            'view_times' => 876,
        ]);        


        DB::table('month_login_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'title' => '常用連結',
            'view' => 1,
            'view_times' => 16,
        ]);        


        DB::table('month_login_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'title' => '開館時間',
            'view' => 0,
            'view_times' => 85,
        ]);        

        DB::table('month_login_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'title' => '交通位置',
            'view' => 0,
            'view_times' => 33,
        ]);        



    }
}
