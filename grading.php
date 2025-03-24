<?php

include "config.php";
include "auth.php";


$data = json_decode(file_get_contents("php://input"));

if (!empty($data->user_id) && !empty($data->course_id) && !empty($data->grade)) {
    $stmt = $conn->prepare("INSERT INTO enrollments (user_id, course_id, grade) VALUES (:user_id, :course_id, :grade)");
    $stmt->execute(["user_id" => $user_id, "course_id" => $data->course_id, "grade" => $data->grade]);
    echo json_encode(["message" => "grade stored successfully"]);
} else {
    echo json_encode(["message" => "Error missing value"]);
}
?>