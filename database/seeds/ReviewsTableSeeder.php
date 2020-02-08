<?php

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reviews')->insert([
            [
                'id' => '1',
                'user_id' => '1',
                'category_id' => '1',
                'title' => 'テスト',
                'body' => 'テストです。',
                'image' => '読書アイコン.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
