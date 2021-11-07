<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_register()
    {
        $this->postJson(route("api.auth.register"), [
            "name"                  => "Ashish",
            "email"                 => "ashish@ashish.com",
            "password"              => "secret",
            "password_confirmation" => "secret",
        ])
             ->assertCreated();

        $this->assertDatabaseHas("users", ["name" => "Ashish"]);

    }
}
