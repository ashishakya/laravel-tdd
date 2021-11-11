<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WebService;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebServiceFactory extends Factory
{
    protected $model = WebService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name"    => "google-drive",
            "user_id" => function () {
                return User::factory()->create()->id;
            },
            "token"   => ["access_token" => "fake-token"],
        ];
    }
}
