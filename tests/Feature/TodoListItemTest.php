<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TodoList;
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
        $todoList = TodoList::factory()->create();
        $task     = Task::factory()->create(
            [
                'todo_list_id' => $todoList->id,
            ]
        );

//        Task::factory()->create(
//            [
//                'todo_list_id' => 200,
//            ]
//        );

        //action
        $response = $this->getJson(route("api.todo-lists.tasks.index", $todoList->id))
                         ->assertOk();
//        dd($response->json());

        $this->assertEquals(1, count($response->json()));
    }

    /**
     * @test
     */
    public function store_task_for_a_todo_list()
    {
        $task     = Task::factory()->make();
        $todoList = TodoList::factory()->create();


        $response = $this->postJson(route("api.todo-lists.tasks.store", $todoList->id), ["title" => $task->title])
                         ->assertCreated();

        $this->assertDatabaseHas("tasks", [
            "title"        => $task->title,
            "todo_list_id" => $todoList->id,
        ]);
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

    /**
     * @test
     */
    public function update_task_of_a_todo_list()
    {
        $task = Task::factory()->create();

        $this->patchJson(route("api.tasks.update", $task->id), ["title" => "updated title"])
             ->assertOk();

        $this->assertDatabaseHas("tasks", ["title" => "updated title"]);
    }
}
