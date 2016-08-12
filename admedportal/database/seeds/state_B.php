<?php

use Illuminate\Database\Seeder;

class state_B extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('month_querydatabase_stat')->truncate();


        DB::table('month_querydatabase_stat')->insert([
            'yearmonth' => '2015-7-31',
            'database_name' => '館藏目錄',
            'view' => 1,
            'query_times' => 1001,
        ]);
 

        DB::table('month_querydatabase_stat')->insert([
            'yearmonth' => '2015-8-31',
            'database_name' => '館藏目錄',
            'view' => 0,
            'query_times' => 11,
        ]);
        
        DB::table('month_querydatabase_stat')->insert([
            'yearmonth' => '2015-8-31',
            'database_name' => 'PubMed 資料庫',
            'view' => 0,
            'query_times' => 87,
        ]);
 

        DB::table('month_querydatabase_stat')->insert([
            'yearmonth' => '2015-9-30',
            'database_name' => '館藏目錄',
            'view' => 0,
            'query_times' => 54,
        ]);
        
        DB::table('month_querydatabase_stat')->insert([
            'yearmonth' => '2015-9-30',
            'database_name' => 'PubMed 資料庫',
            'view' => 0,
            'query_times' => 876,
        ]);
 
        DB::table('month_querydatabase_stat')->insert([
            'yearmonth' => '2015-9-30',
            'database_name' => '國家圖書館',
            'view' => 1,
            'query_times' => 16,
        ]);
 
        DB::table('month_querydatabase_stat')->insert([
            'yearmonth' => '2015-9-30',
            'database_name' => 'MedlinePlus 資料庫',
            'view' => 0,
            'query_times' => 85,
        ]);
 
        DB::table('month_querydatabase_stat')->insert([
            'yearmonth' => '2015-9-30',
            'database_name' => '考科藍實證醫學資料庫',
            'view' => 0,
            'query_times' => 33,
        ]);
 

    }
}
