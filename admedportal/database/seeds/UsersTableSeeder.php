<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        \App\User::truncate();
        
//        factory(\App\User::class, 6)->create();

        DB::table('users')->truncate();    


        DB::table('users')->insert([
            'name' => 'cc',
            'email' => 'cc@gmail.com',
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10), 
        ]);



        DB::table('users')->insert([
            'name' => 'aaa',
            'email' => 'aaa@gmail.com',
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10), 
        ]);


        DB::table('users')->insert([
            'name' => '3344',
            'email' => '3344@gmail.com',
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10), 
        ]);


        DB::table('users')->insert([
            'name' => '12345',
            'email' => '12345@gmail.com',
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10), 
        ]);



        DB::table('users')->insert([
            'name' => 'koha',
            'email' => 'koha@sydt.com.tw',
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10), 
        ]);

        DB::table('users')->insert([
            'name' => 'root',
            'email' => 'root@gmail.com',
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'bbb',
            'email' => 'bbb@gmail.com',
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'ccc',
            'email' => 'ccc@gmail.com',
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'ddd',
            'email' => 'ddd@gmail.com',
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'eee',
            'email' => 'eee@gmail.com',
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10),
        ]);        

    }
}
