<?php

namespace Database\Factories;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class ListingFactory extends Factory
{
    protected $model = Listing::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(3),
            'salary' => $this->faker->sentence(4),
            'email' => $this->faker->unique()->safeEmail,
            'image' => 'https://laragigs.s3.us-west-1.amazonaws.com/default.png',
            'tags' => ['backend', 'laravel', 'php'],
        ];
    }
}
