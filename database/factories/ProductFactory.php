<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categories = Category::select('id')->get();

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'category_id' => $categories[rand(0, count($categories) - 1)], 
            'price' => $this->faker->randomFloat(2, 0, 10000),
            'image' => $this->faker->image('public/storage/images', 640, 480, null, false)
        ];
    }
}
