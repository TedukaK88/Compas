<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
        //     [
        //     'over_name' => '生徒',
        //     'under_name' => '一郎',
        //     'over_name_kana' => 'セイト',
        //     'under_name_kana' => 'イチロウ',
        //     'mail_address' => 'student01@gmail.com',
        //     'sex' => 1,
        //     'birth_day' => '1995-08-08',
        //     'role' => 4,
        //     'password' => 'password'
        // ],
        [
            'over_name' => '講師',
            'under_name' => '一成',
            'over_name_kana' => 'コウシ',
            'under_name_kana' => 'カズナリ',
            'mail_address' => 'teacher01@gmail.com',
            'sex' => 1,
            'birth_day' => '1985-08-08',
            'role' => 1,
            'password' => 'password'
        ]);
    }
}