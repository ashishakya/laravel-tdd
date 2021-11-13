<?php

namespace App\Providers;

use Google\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function () {
            $client = new Client(); // this should come from laravel. resolving it from laravel
            $client->setClientId(config("google.client_id"));
            $client->setClientSecret(config("google.client_secret"));
            $client->setRedirectUri(config("google.redirect_url"));

            return $client;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
