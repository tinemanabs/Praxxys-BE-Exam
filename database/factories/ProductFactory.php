<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    // protected $model = Product::class;

    public function definition()
    {
        $categories = [
            ['label' => 'Category 1', 'value' => 'C1'],
            ['label' => 'Category 2', 'value' => 'C2'],
            ['label' => 'Category 3', 'value' => 'C3'],
            ['label' => 'Category 4', 'value' => 'C4'],
        ];

        $randomCategory = $categories[array_rand($categories)];

        return [
            'name' => $this->faker->word,
            'category' => $randomCategory['value'],
            'description' => $this->faker->text,
            'date_and_time' => $this->faker->dateTime,
        ];
    }
}
