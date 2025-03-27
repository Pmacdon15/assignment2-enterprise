<?php

require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = "OurKey";

$headers = apache_request_headers();
$auth_cookie = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : '';
if ($auth_cookie) {
    $jwt = $auth_cookie;
} else {
    $jwt = isset($headers['Authorization']) ? trim(str_replace("Bearer", "", $headers['Authorization'])) : '';
}

if (!$jwt) {
    die(json_encode(array('message' => 'Token not found')));
}
try {
    $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));

    $user_id = $decoded->user_id;

} catch (Exception $e) {
    die(json_encode(array('message' => 'Invalid Token', 'error' => $e->getMessage())));
}
?>