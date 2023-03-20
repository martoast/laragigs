<?php

namespace Database\Seeders;

use App\Models\Listing;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Listing::count() > 0) {
            Listing::truncate();
        }
        \App\Models\Listing::factory(3)->create();
    }
}
