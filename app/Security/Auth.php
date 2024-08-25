<?php

declare(strict_types=1);

namespace App\Security;

use App\Exceptions\AutenticationFailException;
use Illuminate\Support\Facades\Http;

final class Auth
{
    public static ?Auth $singleton = null;

    public static function getInstance(): Auth
    {
        if(self::$singleton == null) {
            self::$singleton = new Auth();
        }
        return self::$singleton;
    }

    public function autenticationPlantup(): Object
    {
        $response = Http::post(env('PLANTUP_API_URL').'/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => env('PLANTUP_CLIENT_ID'),
            'client_secret' => env('PLANTUP_CLIENT_SECRET'),
            'scope' => '*',
        ]);
        $bodyDecode = json_decode($response->body());

        if(!$response->successful()) {
            throw AutenticationFailException::new();
        }
        return $bodyDecode;
    }
}