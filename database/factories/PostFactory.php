<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Blog;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->text(rand(6, 60)),
            'content' => fake()->paragraph(),
            'user_id' => function () {
                return User::inRandomOrder()->first()->id ?? User::factory()->create()->id;
            },
            'blog_id' => function () {
                return Blog::inRandomOrder()->first()->id ?? Blog::factory()->create()->id;
            },
        ];
    }
}
