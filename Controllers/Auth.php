<?php

require_once 'vendor/autoload.php';

use Firebase\JWT\JWT;

class Auth {
    private static $secret_key;

    public static function init() {
        self::$secret_key = $_ENV['JWT_SECRET'];
    }

    public static function generateToken($data) {
        $payload = [
            'iat' => time(),
            'exp' => time() + (60*60), // 1 hour
            'data' => $data
        ];

        return JWT::encode($payload, self::$secret_key, 'HS256');
    }
}

Auth::init();

?>
