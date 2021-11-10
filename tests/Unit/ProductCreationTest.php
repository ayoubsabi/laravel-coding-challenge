<?php

namespace Tests\Unit;

use Faker\Factory;
use Tests\TestCase;
use App\Models\Category;
use Illuminate\Http\UploadedFile;

class ProductCreationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_product_creation()
    {
        $categories = Category::select('id')->get();

        $faker = Factory::create();

        $this->post('/api/products', [
            'name' => $faker->word,
            'description' => $faker->paragraph,
            'category_id' => $categories[rand(0, count($categories) - 1)]->id, 
            'price' => $faker->randomFloat(2, 0, 10000),
            'image' => UploadedFile::fake()->image('thread.png')
        ])->assertStatus(201);
    }
}
