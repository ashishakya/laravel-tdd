<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 *
 */
class TodoListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private $list;

    /**
     *
     */
    public function setup(): void
    {
        parent::setup();
        $this->list = TodoList::factory()->create();
    }

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

        //action (perform)
        $response = $this->getJson(route("api.todo-lists.index")); // adds content type as json
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
//        $list = $this->list;

        //action
        $response = $this->getJson(route('api.todo-lists.show', $this->list->id));

        //assertion
        $response->assertOk();
        $this->assertEquals($this->list->name, $response->json()['name']);
    }

    /**
     * @test
     */
    public function store_new_todo_list()
    {
        // preparation

        // action
        $this->postJson(route('api.todo-lists.store'), $this->list->toArray())
        ->assertCreated();


        // assertion
        $this->assertDatabaseHas('todo_lists', $this->list->toArray());

    }
}
