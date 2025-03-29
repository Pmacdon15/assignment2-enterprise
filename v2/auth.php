<?php

require "vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

include "config.php"; // $jwt_secret_key

$headers = apache_request_headers();
$auth_cookie = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : '';

if ($auth_cookie) {
    $jwt = $auth_cookie;
} else {
    $jwt = isset($headers['Authorization']) ? trim(str_replace("Bearer", "", $headers['Authorization'])) : '';
}

if (!$jwt) {
    die(json_encode(["error" => "No token provided"]));
}

try {
    $decoded = JWT::decode($jwt, new Key($jwt_secret_key, "HS256"));
    $uid = $decoded->uid;
    $role = $decoded->role;
} catch (Exception $e) {
    die(json_encode(["error" => "Invalid token: " . $e->getMessage()]));
}

?>