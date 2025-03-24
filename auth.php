<?php

require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = "OurKey";

$headers = apache_request_headers();

$jwt = isset($headers['Authorization']) ? trim(str_replace("Bearer", "", $headers['Authorization'])) : '';

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