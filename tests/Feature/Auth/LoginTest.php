<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 *
 */
class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function token_is_return_with_successful_login()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route("api.login"), [
            "email"    => $user->email,
            "password" => "password", // defined in factory
        ])->assertOk();

        $this->arrayHasKey("token", $response->json());
    }

    /**
     * @test
     */
    public function email_and_password_is_required_for_login()
    {
        $response = $this->postJson(route("api.login"), [
            "email"    => "ashish@ashish.com",
            "password" => "secret",
        ])->assertUnauthorized();
    }

    /**
     * @test
     */
    public function raise_error_if_password_is_incorrect()
    {
        $user = User::factory()->create();

        $this->postJson(route("api.login"), [
            "email"    => $user->email,
            "password" => "randomPassword",
        ])->assertUnauthorized();

    }
}
