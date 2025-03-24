<?php
include "config.php";

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->email) && !empty($data->password) && !empty($data->role_id)){
    $hashedPassword = password_hash($data->password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (email, password, role_id) VALUES (:email, :password, :role_id)");

    try {
        $stmt->execute([
            "email" => $data->email, 
            "password" => $hashedPassword, 
            "role_id" => $data->role_id
        ]);
        echo json_encode(["message" => "User registered successfully"]);
    } 
    catch (PDOException $e) {
        echo json_encode(["error" => "User already exists"]);
    }

}else{
    echo json_encode(["error" => "email ,password and role id are required."]);
}

?>