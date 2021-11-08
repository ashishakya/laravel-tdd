<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * @test
     */
    public function a_user_can_login_with_email_and_password()
    {
        $response = $this->postJson(route("api.login"), [
            "email"    => "ashish@ashish.com",
            "password" => "secreta",
        ])->assertOk();

        $this->arrayHasKey("token", $response->json());
    }
}
