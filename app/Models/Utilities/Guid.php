<?php

namespace App\Models\Utilities;

class Guid
{
    public static function generate($length = 16) {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }
}
