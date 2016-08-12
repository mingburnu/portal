<?php

use Illuminate\Database\Seeder;

class pages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('pages')->truncate();

        DB::table('pages')->insert([
            'title' => '首頁',
            'type' => 1,
            'content' => '首頁',            
            'url' => '',
            'view' => 1,
            'rank_id' => 1,
            'note' => '',                
        ]);


        DB::table('pages')->insert([
            'title' => '考科藍新訊',
            'type' => 1,
            'content' => '考科藍新訊',
            'url' => '',
            'view' => 1,
            'rank_id' => 2,
            'note' => '',
        ]);

        DB::table('pages')->insert([
            'title' => '本館簡介',
            'type' => 1,
            'content' => '本館簡介',
            'url' => '',
            'view' => 1,
            'rank_id' => 3,
            'note' => '',
        ]);


        DB::table('pages')->insert([
            'title' => '館藏目錄查詢',
            'type' => 2,
            'content' => '館藏目錄查詢',
            'url' => 'http://koha.sydt.com.tw',
            'view' => 1,
            'rank_id' => 4,
            'note' => '',
        ]);


        DB::table('pages')->insert([
            'title' => '電子資源整合查詢',
            'type' => 2,
            'content' => '電子資源整合查詢',
            'url' => 'http://asp.libsteps.com/NSYSU/?userid',
            'view' => 1,
            'rank_id' => 5,
            'note' => '',
        ]);

        DB::table('pages')->insert([
            'title' => '申請館際合作',
            'type' => 1,
            'content' => '申請館際合作',
            'url' => '',
            'view' => 1,
            'rank_id' => 6,
            'note' => '',
        ]);

        DB::table('pages')->insert([
            'title' => '相關醫學網站',
            'type' => 1,
            'content' => '相關醫學網站',
            'url' => '',
            'view' => 1,
            'rank_id' => 7,
            'note' => '',
        ]);

        DB::table('pages')->insert([
            'title' => '常用連結',
            'type' => 1,
            'content' => '常用連結',
            'url' => '',
            'view' => 1,
            'rank_id' => 8,
            'note' => '',
        ]);

        DB::table('pages')->insert([
            'title' => '開館時間',
            'type' => 1,
            'content' => '開館時間',
            'url' => '',
            'view' => 1,
            'rank_id' => 9,
            'note' => '',
        ]);


        DB::table('pages')->insert([
            'title' => '交通位置',
            'type' => 1,
            'content' => '交通位置',
            'url' => '',
            'view' => 1,
            'rank_id' => 10,
            'note' => '',
        ]);


    }    
        

}
