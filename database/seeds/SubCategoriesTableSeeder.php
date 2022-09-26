<?php

use Illuminate\Database\Seeder;
use App\Models\Categories\SubCategories;

class SubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 国語、数学、英語、英単語帳を追加
        DB::table('sub_categories')->insert(
            [
                'main_category_id' => 1,
                'sub_category' => '国語'
            ]);
        DB::table('sub_categories')->insert(
            [
                'main_category_id' => 1,
                'sub_category' => '数学'
            ]);
        DB::table('sub_categories')->insert(
            [
                'main_category_id' => 1,
                'sub_category' => '英語'
            ]);
        DB::table('sub_categories')->insert(
            [
                'main_category_id' => 2,
                'sub_category' => '英単語帳'
            ]);
    }
}