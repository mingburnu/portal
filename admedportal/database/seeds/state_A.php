<?php

use Illuminate\Database\Seeder;

class state_A extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('month_backend_login_stat')->truncate();

        DB::table('month_backend_login_stat')->insert([
            'yearmonth' => '2015-07-31',
            'account_userid' => 'aaa@gmail.com',
            'login' => 2,
            'logout' => 1,            
        ]);        

        DB::table('month_backend_login_stat')->insert([
            'yearmonth' => '2015-07-31',
            'account_userid' => 'cc@gmail.com',
            'login' => 33,
            'logout' => 30,
        ]);


        DB::table('month_backend_login_stat')->insert([
            'yearmonth' => '2015-08-30',
            'account_userid' => '12345@gmail.com',
            'login' => 51,
            'logout' => 1,            
        ]);        

        DB::table('month_backend_login_stat')->insert([
            'yearmonth' => '2015-08-30',
            'account_userid' => '3344@gmail.com',
            'login' => 87,
            'logout' => 30,
        ]);




        DB::table('month_backend_login_stat')->insert([
            'yearmonth' => '2015-08-30',
            'account_userid' => 'root@gmail.com',
            'login' => 54,
            'logout' => 10,            
        ]);        

        DB::table('month_backend_login_stat')->insert([
            'yearmonth' => '2015-08-30',
            'account_userid' => 'bbb@gmail.com',
            'login' => 876,
            'logout' => 320,
        ]);

        DB::table('month_backend_login_stat')->insert([
            'yearmonth' => '2015-08-30',
            'account_userid' => 'ccc@gmail.com',
            'login' => 16,
            'logout' => 5,
        ]);

        DB::table('month_backend_login_stat')->insert([
            'yearmonth' => '2015-08-30',
            'account_userid' => 'ddd@gmail.com',
            'login' => 85,
            'logout' => 25,
        ]);

        DB::table('month_backend_login_stat')->insert([
            'yearmonth' => '2015-08-30',
            'account_userid' => 'eee@gmail.com',
            'login' => 33,
            'logout' => 6,
        ]);


        //

        DB::table('month_backend_login_stat')->insert([
            'yearmonth' => '2015-09-30',
            'account_userid' => 'root@gmail.com',
            'login' => 54,
            'logout' => 10,            
        ]);        

        DB::table('month_backend_login_stat')->insert([
            'yearmonth' => '2015-09-30',
            'account_userid' => 'bbb@gmail.com',
            'login' => 876,
            'logout' => 320,
        ]);

        DB::table('month_backend_login_stat')->insert([
            'yearmonth' => '2015-09-30',
            'account_userid' => 'ccc@gmail.com',
            'login' => 16,
            'logout' => 5,
        ]);

        DB::table('month_backend_login_stat')->insert([
            'yearmonth' => '2015-09-30',
            'account_userid' => 'ddd@gmail.com',
            'login' => 85,
            'logout' => 25,
        ]);

        DB::table('month_backend_login_stat')->insert([
            'yearmonth' => '2015-09-30',
            'account_userid' => 'eee@gmail.com',
            'login' => 33,
            'logout' => 6,
        ]);


    }
}
