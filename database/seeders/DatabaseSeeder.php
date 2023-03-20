<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Listing;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::count() > 0) {
            User::truncate();
        }
        \App\Models\User::factory(10)->create();

        if (Listing::count() > 0) {
            Listing::truncate();
        }

        \App\Models\Listing::factory(3)->create();
    }
}
