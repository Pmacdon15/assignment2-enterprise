<?php

include "config.php";
require "vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


$secretkey = "OurKey";

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->username) && !empty($data->password)){
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(["username" => $data->username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($data->password, $user["password"])) {
        $payload = [
            "iss" => "localhost",
            "iat" => time(),
            "exp" => time() + (60 * 60),
            "user_id" => $user["id"]
        ];

        $jwt = JWT::encode($payload, $secretkey, "HS256");
        echo json_encode(["token" => $jwt]);
    } else {
        echo json_encode(["error" => "Invalid credentials."]);
    }

} else {
    echo json_encode(["error" => "User and password are required."]);
}

?>