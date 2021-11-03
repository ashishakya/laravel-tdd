<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 *
 */
class TodoListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @test
     */
    public function fetch_all_todo_list()
    {
        //preparation (prepare)
//        TodoList::create(['name'=>"My List"]);
        $list = TodoList::factory()->create();

        //action (perform)
        $response = $this->getJson(route("api.todo-list.index")); // adds content type as json
//        dd($response->json());

        //assertion (predict)
        $this->assertEquals(1, count($response->json()));
    }


    /**
     * @test
     */
    public function fetch_single_todolist()
    {
        // preparation
        $list = TodoList::factory()->create();

        //action
        $response = $this->getJson(route('api.todo-list.show', $list->id));

        //assertion
        $response->assertOk();
        $this->assertEquals($list->name, $response->json()['name']);
    }
}
