<?php

namespace Tests\Unit;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_has_many_todo_lists()
    {
        $user     = $this->createUser();
        $todoList = $this->createTodoList(["user_id" => $user->id]);

        $this->assertInstanceOf(Collection::class, $user->todoLists);
        $this->assertInstanceOf(TodoList::class, $user->todoLists->first());
    }
}
