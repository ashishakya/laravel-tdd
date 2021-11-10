<?php

namespace App\Http\Controllers\Google;

use App\Http\Controllers\Controller;
use App\Models\WebService;
use Google\Client;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public const DRIVE_SCOPES = [
        "https://www.googleapis.com/auth/drive",
        "https://www.googleapis.com/auth/drive.file",
    ];

    public function connect(Request $request, $service, Client $client)
    {
        if ( $service === "google-drive" ) {
//            $client = new Client();
//            $client->setClientId(config("google.client_id"));
//            $client->setClientSecret(config("google.client_secret"));
//            $client->setRedirectUri(config("google.redirect_url"));
            $client->setScopes(self::DRIVE_SCOPES);

            // since we are working on api we do not redirect, this is handled from frontend.
            $url = $client->createAuthUrl();

            return response(["authenticate_redirect_url" => $url]);
        }
    }

    public function callback(Request $request, Client $client)
    {
        // laravel lai client ko kura yeta aaye pachi matrai tahha huncha

//        $client = new Client(); // client instance use gareko
//        $client = app(Client::class); // this should come from laravel. resolving it from laravel
//
//        $client->setClientId(config("google.client_id"));
//        $client->setClientSecret(config("google.client_secret"));
//        $client->setRedirectUri(config("google.redirect_url"));

        $code = request("code");
        $accessToken = $client->fetchAccessTokenWithAuthCode($code);

        return WebService::create(
            [
                "name"=>"google-drive",
                "user_id" => auth()->id(),
                "token"   => json_encode(["access_token" => $accessToken]),
            ]
        );

    }
}
