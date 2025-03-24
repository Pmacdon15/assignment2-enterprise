<?php

include "config.php";
include "auth.php";


$data = json_decode(file_get_contents("php://input"));

if (!empty($data->message)) {
   $stmt = $conn->prepare("INSERT INTO messages (user_id, message) VALUES (:user_id, :message)");
   $stmt->execute(["user_id" => $user_id, "message" => $data->message]);
   echo json_encode(["message" => "Message stored successfully"]);
}
?>