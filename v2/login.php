<?php

require "vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

include "config.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "GET") {
    $login_data = json_decode(file_get_contents("php://input"));

    if (isset($login_data->username) && isset($login_data->password)) {
        $username = $login_data->username;
        $password = $login_data->password;

        $stmt = $conn->prepare("SELECT * FROM $table_users WHERE username = :username");
        $stmt->execute(["username" => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            $payload = [
                "iss" => "localhost",
                "iat" => time(),
                "exp" => time() + 3600,
                "uid" => $user["uid"],
                "role" => $user["role"]
            ];

            $jwt = JWT::encode($payload, $jwt_secret_key, "HS256");
            setcookie('auth_token', $jwt, time() + (60 * 60), '/');
            echo json_encode(["token" => $jwt]);
        } else {
            echo json_encode(["error" => "Invalid username or password"]); // Invalid credentials
        }

    } else {
        echo json_encode(["error" => "Username and password are required"]);
    }

} else {
    echo json_encode(["error" => "Only the GET method allowed"]);
}

?>