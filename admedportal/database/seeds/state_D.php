<?php

use Illuminate\Database\Seeder;

class state_D extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('month_keyword_pages_stat')->truncate();


        DB::table('month_keyword_pages_stat')->insert([
            'yearmonth' => '2015-07-31',
            'rank_id' => 1,
            'keyword' => 'MERS',
            'database_name' => '館藏目錄',
            'query_times' => 10,
        ]);        



        DB::table('month_keyword_pages_stat')->insert([
            'yearmonth' => '2015-08-31',
            'rank_id' => 1,
            'keyword' => 'MERS',
            'database_name' => '館藏目錄',
            'query_times' => 10,
        ]);        

        DB::table('month_keyword_pages_stat')->insert([
            'yearmonth' => '2015-08-31',
            'rank_id' => 2,
            'keyword' => '管理',
            'database_name' => 'MedlinePlus 資料庫',
            'query_times' => 108,
        ]);        

        DB::table('month_keyword_pages_stat')->insert([
            'yearmonth' => '2015-08-31',
            'rank_id' => 3,
            'keyword' => '燒燙傷',
            'database_name' => '考科藍實證醫學資料庫',
            'query_times' => 111,
        ]);        




        DB::table('month_keyword_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'rank_id' => 1,
            'keyword' => 'MERS',
            'database_name' => '館藏目錄',
            'query_times' => 1088,
        ]);        

        DB::table('month_keyword_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'rank_id' => 2,
            'keyword' => '管理',
            'database_name' => 'MedlinePlus 資料庫',
            'query_times' => 1085,
        ]);        

        DB::table('month_keyword_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'rank_id' => 3,
            'keyword' => '燒燙傷',
            'database_name' => '考科藍實證醫學資料庫',
            'query_times' => 1080,
        ]);        

        DB::table('month_keyword_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'rank_id' => 4,
            'keyword' => '心理諮商',
            'database_name' => 'MedlinePlus 資料庫',
            'query_times' => 1075,
        ]);        

        DB::table('month_keyword_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'rank_id' => 5,
            'keyword' => 'Cancer',
            'database_name' => '國家圖書館',
            'query_times' => 1063,
        ]);        

        DB::table('month_keyword_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'rank_id' => 6,
            'keyword' => '臨床醫學',
            'database_name' => 'PubMed 資料庫',
            'query_times' => 1054,
        ]);        

        DB::table('month_keyword_pages_stat')->insert([
            'yearmonth' => '2015-09-30',
            'rank_id' => 7,
            'keyword' => 'Arthralgia',
            'database_name' => 'MedlinePlus 資料庫',
            'query_times' => 1046,
        ]);        




    }
}
