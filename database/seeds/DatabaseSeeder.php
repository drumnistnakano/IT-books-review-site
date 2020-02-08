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
        // Note : シーディングファイルを作成する度に追記
        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            ReviewsTableSeeder::class,
        ]);
    }
}
