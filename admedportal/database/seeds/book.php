<?php

use Illuminate\Database\Seeder;

class book extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('book')->truncate();

        DB::table('book')->insert([
            'cover' => 'img/book_01.png',
            'book_name' => 'Advances in economic theory',
            'url' => 'http://koha.sydt.com.tw/cgi-bin/koha/opac-detail.pl?biblionumber=107',
            'view' => '1',
            'rand_id' => '1',
            'note' => '',
        ]);

        DB::table('book')->insert([
            'cover' => 'img/book_02.png',
            'book_name' => '彩色圖解急重症照護醫學快速學習',
            'url' => 'http://koha.sydt.com.tw/cgi-bin/koha/opac-detail.pl?biblionumber=19031&query_desc=kw%2Cwrdl%3A%20medicine',
            'view' => '1',
            'rand_id' => '2',
            'note' => '',
        ]);

        DB::table('book')->insert([
            'cover' => 'img/book_03.png',
            'book_name' => '臨床外科學',
            'url' => 'http://koha.sydt.com.tw/cgi-bin/koha/opac-detail.pl?biblionumber=19033&query_desc=kw%2Cwrdl%3A%20%E9%86%AB%E5%AD%B8',
            'view' => '1',
            'rand_id' => '3',
            'note' => '',
        ]);

        DB::table('book')->insert([
            'cover' => 'img/book_04.png',
            'book_name' => 'Building a world-class NHS',
            'url' => 'http://koha.sydt.com.tw/cgi-bin/koha/opac-detail.pl?biblionumber=5',
            'view' => '1',
            'rand_id' => '4',
            'note' => '',
        ]);

        DB::table('book')->insert([
            'cover' => 'img/book_05.png',
            'book_name' => 'Fourier transform infrared spectroscopy in colloid and interface science',
            'url' => 'http://koha.sydt.com.tw/cgi-bin/koha/opac-detail.pl?biblionumber=157&query_desc=kw%2Cwrdl%3A%20science',
            'view' => '1',
            'rand_id' => '5',
            'note' => '',
        ]);

        DB::table('book')->insert([
            'cover' => 'img/book_06.png',
            'book_name' => '新聞地理',
            'url' => 'http://koha.sydt.com.tw/cgi-bin/koha/opac-detail.pl?biblionumber=19159&query_desc=kw%2Cwrdl%3A%20%E7%B6%93%E6%BF%9F',
            'view' => '1',
            'rand_id' => '6',
            'note' => '',
        ]);

        DB::table('book')->insert([
            'cover' => 'img/book_07.png',
            'book_name' => '新聞地理2',
            'url' => 'http://koha.sydt.com.tw/cgi-bin/koha/opac-detail.pl?biblionumber=19160&query_desc=kw%2Cwrdl%3A%20%E7%B6%93%E6%BF%9F',
            'view' => '1',
            'rand_id' => '7',
            'note' => '',
        ]);

        DB::table('book')->insert([
            'cover' => 'img/book_08.png',
            'book_name' => '色彩生活美學',
            'url' => 'http://koha.sydt.com.tw/cgi-bin/koha/opac-detail.pl?biblionumber=14160&query_desc=kw%2Cwrdl%3A%20%E9%86%AB%E5%AD%B8',
            'view' => '1',
            'rand_id' => '8',
            'note' => '',
        ]);

        DB::table('book')->insert([
            'cover' => 'http://koha.sydt.com.tw/cgi-bin/koha/opac-image.pl?imagenumber=2',
            'book_name' => '數一數，動物躲哪裡？',
            'url' => 'http://koha.sydt.com.tw/cgi-bin/koha/opac-detail.pl?biblionumber=60',
            'view' => '1',
            'rand_id' => '9',
            'note' => '',
        ]);



    }
}
