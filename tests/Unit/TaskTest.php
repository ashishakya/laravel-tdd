<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function task_belongs_to_a_todo_list()
    {
        $todoList = TodoList::factory()->create();
        $task = Task::factory()->create(["todo_list_id" => $todoList->id]);

        $this->assertInstanceOf(TodoList::class, $task->todoList);
    }
}
