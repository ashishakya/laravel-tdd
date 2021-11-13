<?php

namespace Tests\Feature;

use App\Models\WebService;
use Google\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private $user;

    public function setup(): void
    {
        parent::setup(); // TODO: Change the autogenerated stub
        $this->user = $this->authUser();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_connect_to_service_and_authenticate_redirect_url_is_returned()
    {
        $this->mock(Client::class, function (MockInterface $mock) {
//            since we have defined this is servic provider we dont actually call it
//            $mock->shouldReceive("setClientId")->once();
//            $mock->shouldReceive("setClientSecret")->once();
//            $mock->shouldReceive("setRedirectUri")->once();
            $mock->shouldReceive("setScopes")->once();
            $mock->shouldReceive("createAuthUrl")
                 ->andReturn('fake-mocked-url')
                 ->once();
        });

        $response = $this->getJson(route("api.google.service.connect", "google-drive"))
                         ->assertOk();

        $this->assertArrayHasKey("authenticate_redirect_url", $response->json());
    }

    public function test_service_callback_will_store_token()
    {
        $this->mock(Client::class, function (MockInterface $mock) {
//            since we have defined this is servic provider we dont actually call it
//            $mock->shouldReceive("setClientId")->once();
//            $mock->shouldReceive("setClientSecret")->once();
//            $mock->shouldReceive("setRedirectUri")->once();
            $mock->shouldReceive("fetchAccessTokenWithAuthCode")
                 ->andReturn('fake-mocked-token')
                 ->once();
        });
        $response = $this->postJson(route("api.google.service.callback", ["code" => "dummy-code"]))
                         ->assertCreated();

        //token field in db as json
        $this->assertDatabaseHas("web_services", [
            "user_id" => $this->user->id,
            "token"   => '{"access_token":"fake-mocked-token"}',
        ]);
    }

    public function test_data_of_a_week_can_be_stored_in_google_drive()
    {
        $this->createTask(["created_at"=>now()->subDays(2)]);
        $this->createTask(["created_at"=>now()->subDays(3)]);
        $this->createTask(["created_at"=>now()->subDays(4)]);
        $this->createTask(["created_at"=>now()->subDays(6)]);

        $this->createTask(["created_at"=>now()->subDays(14)]);
        $this->mock(Client::class, function (MockInterface $mock) {
            $mock->shouldReceive("setAccessToken");
            $mock->shouldReceive("getLogger->info");
            $mock->shouldReceive("shouldDefer");
            $mock->shouldReceive("execute");
        });

        $webService = $this->createWebService();

        $this->postJson(route("api.google.service.store", $webService))
             ->assertCreated();
    }
}
