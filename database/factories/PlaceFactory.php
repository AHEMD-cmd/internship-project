<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Place;
use Illuminate\Support\Str;
use App\Models\Specification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Place>
 */
class PlaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->city;
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . time(),
            'description' => $this->faker->paragraph,
            'is_visible' => $this->faker->randomElement([0, 1]),        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Place $place) {
            // Assign specifications
            $specifications = Specification::inRandomOrder()->limit(3)->get();
            $place->specifications()->attach($specifications, ['value' => 'good']);

            // Assign tags
            $tags = Tag::inRandomOrder()->limit(2)->get();
            $place->tags()->attach($tags);
        });
    }
}
