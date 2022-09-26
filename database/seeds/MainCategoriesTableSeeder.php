<?php

use Illuminate\Database\Seeder;
use App\Models\Categories\MainCategory;

class MainCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 教科、参考書を追加
        DB::table('main_categories')->insert(
            ['main_category' => '教科']);
        DB::table('main_categories')->insert(
            ['main_category' => '参考書']);
    }
}