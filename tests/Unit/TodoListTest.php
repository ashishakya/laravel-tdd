<?php

namespace Tests\Unit;


use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

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
}
