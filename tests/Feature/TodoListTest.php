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

        $list = TodoList::factory()->make();
        // action
        $response = $this->postJson(route('api.todo-lists.store'), ["name" => $list->name])
                         ->assertCreated()
                         ->json();


        // assertion
        $this->assertEquals($response["name"], $list->name);
        $this->assertDatabaseHas('todo_lists', ["name" => $list->name]);
    }

    /**
     * @test
     */
    public function name_field_is_required_while_storing()
    {
        $this->withExceptionHandling();

        $this->postJson(route('api.todo-lists.store'))
             ->assertUnprocessable() //422
             ->assertJsonValidationErrors(["name"]);
    }

    /**
     * @test
     */
    public function delete_todo_list()
    {
        $this->deleteJson(route('api.todo-lists.destroy', $this->list->id))
             ->assertNoContent();

        $this->assertDatabaseMissing('todo_lists', ['name' => $this->list->name]);
    }

    /**
     * @test
     */
    public function update_todo_list()
    {
        $this->patchJson(route('api.todo-lists.update', $this->list->id), ["name" => "updated name"])
             ->assertOk();

        $this->assertDatabaseHas("todo_lists", ["name" => "updated name"]);
    }

    /**
     * @test
     */
    public function name_field_is_required_while_updating()
    {
        $this->withExceptionHandling();

        $this->patchJson(route('api.todo-lists.update', $this->list->id))
             ->assertUnprocessable() //422
             ->assertJsonValidationErrors(["name"]);
    }
}
