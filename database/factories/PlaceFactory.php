<?php

namespace Database\Factories;

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
    public function definition(): array {

        $name = $this->faker->streetName();
        $slug = $this->generateSlug($name);
        $city = $this->faker->city();
        $state = $this->faker->stateAbbr();

        return [
            'name'  => $name,
            'slug'  => $slug,
            'city'  => $city,
            'state' => $state
        ];
    }

    private function generateSlug(string $value) {
        $value = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
        $value = strtolower($value);
        $value = str_replace(' ', '-', $value);
        $value = preg_replace('/[^a-z0-9\-]/', '', $value);
        $value = preg_replace('/-+/', '-', $value);
        $value = trim($value, '-');

        return $value;
    }
}
