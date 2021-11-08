<?php

namespace Tests;

use App\Models\Label;
use App\Models\TodoList;
use App\Models\User;
use Database\Factories\LabelFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setup(): void
    {
        parent::setup();
        $this->withoutExceptionHandling();
    }

    public function createUser($args = [])
    {
        return User::factory()->create($args);
    }

    public function authUser()
    {
        $user = $this->createUser();
        Sanctum::actingAs($user);

        return $user;
    }

    public function createTodoList($args = [])
    {
        return TodoList::factory()->create($args);
    }

    public function createLabel($args = [])
    {
        return Label::factory()->create($args);
    }
}
