<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('drive', function () {
    $client = new Google\Client();
    $client->setClientId(config("google.client_id"));
    $client->setClientSecret(config("google.client_secret"));
    $client->setRedirectUri(config("google.redirect_url"));
    $client->setScopes(
        [
            "https://www.googleapis.com/auth/drive",
            "https://www.googleapis.com/auth/drive.file",
        ]
    );
    $url = $client->createAuthUrl();

    return redirect($url);
});
Route::get("login/google-drive/callback", function () {
    $client = new Google\Client();
    $client->setClientId(config("google.client_id"));
    $client->setClientSecret(config("google.client_secret"));
    $client->setRedirectUri(config("google.redirect_url"));

    $code = request("code");

    return $client->fetchAccessTokenWithAuthCode($code);
});

Route::get("upload", function () {
    $accessToken = config("google.access_token");

    $client = new Google\Client();
    $client->setAccessToken($accessToken);

    $service = new Google\Service\Drive($client);
    $file    = new \Google\Service\Drive\DriveFile();

    DEFINE("TESTFILE", 'testfile-small.txt');
    if (!file_exists(TESTFILE)) {
        $fh = fopen(TESTFILE, 'w');
        fseek($fh, 1024 * 1024);
        fwrite($fh, "!", 1);
        fclose($fh);
    }

    $file->setName("Hello World!");
    $result2 = $service->files->create(
        $file,
        array(
            'data' => file_get_contents(TESTFILE),
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'multipart'
        )
    );
});
