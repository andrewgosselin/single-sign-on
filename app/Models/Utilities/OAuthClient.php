<?php

namespace App\Models\Utilities;
use Laravel\Passport\Passport;
use Illuminate\Support\Str;

class OAuthClient
{
    public static function create($userId, $name, $redirect, $provider = null, $personalAccess = false, $password = false, $confidential = true)
    {
        $client = Passport::client()->forceFill([
            'user_id' => $userId,
            'name' => $name,
            'secret' => ($confidential || $personalAccess) ? Str::random(40) : null,
            'provider' => $provider,
            'redirect' => $redirect,
            'personal_access_client' => $personalAccess,
            'password_client' => $password,
            'revoked' => false,
        ]);

        $client->save();

        return $client;
    }
}
