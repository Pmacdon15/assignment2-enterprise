<?php
include "config.php";

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->username) && !empty($data->password)){
    $hashedPassword = password_hash($data->password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");

    try {
        $stmt->execute(["username" => $data->username, "password" => $hashedPassword]);
        echo json_encode(["message" => "User registered successfully"]);
    } 
    catch (PDOException $e) {
        echo json_encode(["error" => "User already exists"]);
    }

}else{
    echo json_encode(["error" => "User and password are required."]);
}

?>