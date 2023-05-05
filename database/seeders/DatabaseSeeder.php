<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\BlogSeeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\VoteSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            BlogSeeder::class,
            PostSeeder::class,
            VoteSeeder::class
        ]);
    }
}
