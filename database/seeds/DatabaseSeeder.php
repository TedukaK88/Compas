<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //DB初期化
        DB::table('users')->truncate();
        DB::table('posts')->truncate();
        DB::table('post_comments')->truncate();
        DB::table('post_sub_categories')->truncate();
        DB::table('likes')->truncate();
        DB::table('main_categories')->truncate();
        DB::table('sub_categories')->truncate();
        DB::table('subjects')->truncate();
        DB::table('subject_users')->truncate();
        DB::table('reserve_settings')->truncate();
        DB::table('reserve_setting_users')->truncate();

        // Seederの起動
        $this->call(SubjectsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MainCategoriesTableSeeder::class);
        $this->call(SubCategoriesTableSeeder::class);
    }
}