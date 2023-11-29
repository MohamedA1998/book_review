<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'review'        => fake()->sentence(3)                  ,
            'rating'        => fake()->numberBetween(1 , 5)         ,
            'book_id'       => null                                 ,
            'created_at'    => fake()->dateTimeBetween('-2 years')  ,
            'updated_at'    => fake()->dateTimeBetween('-2 years')
        ];
    }

    
    public function good(){
        return $this->state(fn(array $attributes) => [
                'rating' => fake()->numberBetween(4 , 5)
            ]);
    }


    public function average(){
        return $this->state(fn(array $attributes) => [
                'rating' => fake()->numberBetween(3 , 4)
            ]);
    }

    public function bad(){
        return $this->state(fn(array $attributes) => [
                'rating' => fake()->numberBetween(1 , 3)
            ]);
    }

}
