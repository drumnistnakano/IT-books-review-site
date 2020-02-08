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
        DB::table('users')->insert([
            [
                'id' => '1',
                'name' => 'nakano',
                'email' => 'nakano@nakano',
                'password' => bcrypt('nakanosan'),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
