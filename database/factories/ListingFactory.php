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
        $image = $this->faker->image('public/storage/listings', 640, 480, null, false);

        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(3),
            'salary' => $this->faker->sentence(4),
            'image' => 'listings/' . basename($image),
        ];
    }

    public function configure()
{
    return $this->afterCreating(function (Listing $listing) {
        $listing->setImageAttribute(Storage::url($listing->image));
        $listing->save();
    });
}
}
