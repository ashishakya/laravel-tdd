<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 *
 */
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

    /**
     * @test
     */
    public function store_task_for_a_todo_list()
    {
        $task = Task::factory()->make();

        $response = $this->postJson(route("api.tasks.store"), ["title" => $task->title])
                         ->assertCreated();

        $this->assertDatabaseHas("tasks", ["title" => $task->title]);
    }

    /**
     * @test
     */
    public function delete_task()
    {
        $task = Task::factory()->create();

        $this->deleteJson(route("api.tasks.destroy", $task->id))
             ->assertNoContent();

        $this->assertDatabaseMissing("tasks", ["title" => $task->title]);
    }
}
