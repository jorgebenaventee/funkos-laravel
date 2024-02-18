<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Funko;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FunkoFactory extends Factory
{
    protected $model = Funko::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat(2, 0, 1500),
            'stock' => $this->faker->randomNumber(3),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'category_id' => Category::factory()
        ];
    }
}
