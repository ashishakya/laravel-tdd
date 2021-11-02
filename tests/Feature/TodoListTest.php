<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
    public function fetch_todo_list()
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
}
