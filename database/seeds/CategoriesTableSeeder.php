<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();

        $categories = [
            'title' => 'Sample Category',
            'slug' => 'sample-category'
        ];

        DB::table('categories')->insert($categories);
    }
}
