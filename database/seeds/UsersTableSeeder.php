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
            [
            'over_name' => '生徒',
            'under_name' => '一郎',
            'over_name_kana' => 'セイト',
            'under_name_kana' => 'イチロウ',
            'mail_address' => 'student01@gmail.com',
            'sex' => 1,
            'birth_day' => '1995-08-08',
            'role' => 4,
            'password' => bcrypt('password')
        ]);
        DB::table('subject_users')->insert(
            [
                'user_id' => 1,
                'subject_id' => 1
        ]);
        DB::table('users')->insert(
        [
            'over_name' => '講師',
            'under_name' => '一成',
            'over_name_kana' => 'コウシ',
            'under_name_kana' => 'カズナリ',
            'mail_address' => 'teacher01@gmail.com',
            'sex' => 1,
            'birth_day' => '1985-08-08',
            'role' => 1,
            'password' => bcrypt('password')
        ]);
        DB::table('users')->insert(
            [
                'over_name' => '学舎',
                'under_name' => '二葉',
                'over_name_kana' => 'マナビヤ',
                'under_name_kana' => 'フタバ',
                'mail_address' => 'student02@gmail.com',
                'sex' => 2,
                'birth_day' => '2002-02-02',
                'role' => 4,
                'password' => bcrypt('password')
        ]);
        DB::table('subject_users')->insert(
            [
                'user_id' => 3,
                'subject_id' => 2
        ]);
        DB::table('subject_users')->insert(
            [
                'user_id' => 3,
                'subject_id' => 3
        ]);
        DB::table('users')->insert(
            [
                'over_name' => '押江',
                'under_name' => '守',
                'over_name_kana' => 'オシエ',
                'under_name_kana' => 'マモル',
                'mail_address' => 'student03@gmail.com',
                'sex' => 1,
                'birth_day' => '2004-03-13',
                'role' => 4,
                'password' => bcrypt('password')
        ]);
        DB::table('subject_users')->insert(
            [
                'user_id' => 4,
                'subject_id' => 3
        ]);
    }
}