<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vote>
 */
class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $votable = Post::factory(1)->create()->first();
    
        return [
            'user_id' => function () {
                return User::inRandomOrder()->first()->id;
            },
            'votable_id' => $votable->id,
            'votable_type' => Post::class,
            'value' => fake()->boolean(),
        ];
    }
}
