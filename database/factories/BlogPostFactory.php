<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'content' => $this->faker->paragraph(5, true)
        ];
    }

    public function newTitle()
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'New title',
                'content' => 'New content'
            ];
        });
    }
}
