<?php

namespace App\Http\Controllers\Google;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\WebService;
use Google\Client;
use Google\Service\Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use ZipArchive;

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

        $code        = request("code");
        $accessToken = $client->fetchAccessTokenWithAuthCode($code);

        return WebService::create(
            [
                "name"    => "google-drive",
                "user_id" => auth()->id(),
                "token"   => ["access_token" => $accessToken],
            ]
        );

    }

    public function store(Request $request, WebService $service, Client $client)
    {
        // fetch last 7 days tasks
        $tasks = Task::where("created_at", ">=", now()->subDays(7))->get();

        // create a json file with this data
        $fileName = "tasks-dump.json";
        Storage::put("/public/temp/".$fileName, TaskResource::collection($tasks)->toJson());

        // create a zip with this file
        $zip = new \ZipArchive();
        $zipFileName = storage_path("app/public/temp/". now()->timestamp . "-task.zip") ;
        if($zip->open($zipFileName, \ZipArchive::CREATE)=== true){
            $filePath = storage_path("app/public/temp/".$fileName);
            $zip->addFile($filePath);
        }
        $zip->close();
        // send this zip to drive
        $accessToken = $service->token["access_token"];
        $client->setAccessToken($accessToken);

        $service = new Drive($client);
        $file    = new Drive\DriveFile();

//        DEFINE("TESTFILE", 'testfile-small.txt');
//        if (!file_exists(TESTFILE)) {
//            $fh = fopen(TESTFILE, 'w');
//            fseek($fh, 1024 * 1024);
//            fwrite($fh, "!", 1);
//            fclose($fh);
//        }
        $fileToUpload = "";
        $file->setName("Hello World yeah!");
        $result2 = $service->files->create(
            $file,
            [
                'data'       => file_get_contents($zipFileName),
                'mimeType'   => 'application/octet-stream',
                'uploadType' => 'multipart',
            ]
        );

        Storage::deleteDirectory("public/temp");

        return response("Uploaded", Response::HTTP_CREATED);
    }
}
