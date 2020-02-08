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
        DB::table('categories')->insert([
            [
                'id' => '1',
                'name' => '技術書',
                'color' => '#ff8d64',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '2',
                'name' => '自己啓発書',
                'color' => '#deb787',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
