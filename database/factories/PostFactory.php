<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 5),
            'title' => fake()->sentence(),
            'body' => implode("\n\n", fake()->paragraphs(3)),
            'image' => fake()->randomElement([
                'posts_images/image1.jpeg',
                'posts_images/image2.jpeg',
                'posts_images/image3.jpeg',
                'posts_images/image4.jpeg',
                'posts_images/image5.jpeg',
                'posts_images/image6.jpeg',
                'posts_images/image7.jpeg',
                'posts_images/image8.jpeg',
                'posts_images/image9.jpeg',
                null
            ]),
        ];
    }
}
