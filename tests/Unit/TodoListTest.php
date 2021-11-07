<?php

namespace Tests\Unit;


use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 *
 */
class TodoListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function todo_list_can_have_many_tasks()
    {
        $todoList = TodoList::factory()->create();
        Task::factory()->create(["todo_list_id" => $todoList->id]);

        $this->assertInstanceOf(Collection::class, $todoList->tasks);
        $this->assertInstanceOf(Task::class, $todoList->tasks->first());
    }

    /**
     * @test
     */
    public function if_todo_list_is_deleted_all_its_tasks_are_deleted()
    {
        $todoList = TodoList::factory()->create();
        $task     = Task::factory()->create(["todo_list_id" => $todoList->id]);
        $anotherTask = Task::factory()->create();

        $todoList->delete();

        $this->assertDatabaseMissing("todo_lists", ["id" => $todoList->id]);
        $this->assertDatabaseMissing("tasks", ["id" => $task->id]);
        $this->assertDatabaseHas("tasks", ["id" => $anotherTask->id]);
    }
}
