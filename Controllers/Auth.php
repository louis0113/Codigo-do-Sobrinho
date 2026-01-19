<?php

require_once 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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

    public static function validateToken() {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            throw new Exception('Token de autorização não encontrado');
        }

        $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        $arr = explode(' ', $authHeader);
        $token = $arr[1];

        return JWT::decode($token, new Key(self::$secret_key, 'HS256'));
    }
}

Auth::init();

?>
