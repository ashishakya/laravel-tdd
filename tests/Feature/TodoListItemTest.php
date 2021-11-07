<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoListItemTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function fetch_all_items_of_a_todo_list()
    {
        // prepare
        Task::factory()->create();

        //action
        $response = $this->getJson(route("api.tasks.index"))
                         ->assertOk();
    }
}
