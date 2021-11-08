<?php

namespace Database\Factories;

use App\Models\TodoList;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskFactory extends Factory
{
    use RefreshDatabase;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title"        => $this->faker->sentence,
            "description"  => $this->faker->paragraph,
            "todo_list_id" => function () {
                return TodoList::factory()->create()->id;
            },
        ];
    }
}
