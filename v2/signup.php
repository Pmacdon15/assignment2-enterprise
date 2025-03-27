<?php

include "config.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "POST") {
    $new_user_data = json_decode(file_get_contents("php://input"));

    if (isset($new_user_data->username) && isset($new_user_data->password) && isset($new_user_data->role)) {
        $username = $new_user_data->username;
        $hashed_password = password_hash($new_user_data->password, PASSWORD_BCRYPT);
        $role = $new_user_data->role;

        if ($role !== "student" && $role !== "instructor") {
            echo json_encode(["error" => "Invalid role"]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO $table_users (username, password, role) VALUES (:username, :password, :role)");

        try {
            $stmt->execute(["username" => $username, "password" => $hashed_password, "role" => $role]);
            echo json_encode(["message" => "User registered successfully"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "User already exists"]);
        }
    
    } else {
        echo json_encode(["error" => "Username, password and role are required"]);
    }

} else {
    echo json_encode(["error" => "Only the POST method allowed"]);
}

?>