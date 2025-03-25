<?php

include "config.php";
include "auth.php";

$data = json_decode(file_get_contents("php://input"));

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    if (!empty($data->user_id) && !empty($data->course_id) && !empty($data->grade)) {
        try {
            $stmt = $conn->prepare("INSERT INTO enrollments (user_id, course_id, grade) 
                          SELECT :user_id, :course_id, :grade 
                          FROM courses 
                          WHERE id = :course_id");
            $stmt->execute(["user_id" => $user_id, "course_id" => $data->course_id, "grade" => $data->grade]);
            if ($stmt->rowCount() === 0) {
                http_response_code(404);
                echo json_encode(["error" => "Error adding grade" ]);
                return;
            }
            echo json_encode(["message" => "grade added successfully"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error adding grade " .  $e ->getMessage()]);
        }

    } else {
        echoMissingValueError();
    }
} elseif ($method === 'DELETE') {
    if (!empty($data->user_id) && !empty($data->course_id)) {
        try {
            $stmt = $conn->prepare("DELETE FROM enrollments WHERE user_id = :user_id AND course_id = :course_id");
            $stmt->execute(["user_id" => $user_id, "course_id" => $data->course_id]);
            if ($stmt->rowCount() === 0) {
                http_response_code(404);
                echo json_encode(["error" => "Error deleting grade" .  $e ->getMessage()]);
                return;
            }
            echo json_encode(["message" => "grade deleted successfully"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error deleting grade"]);
        }

    } else {
        echoMissingValueError();
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}


function echoMissingValueError()
{
    echo json_encode(["message" => "Error missing value"]);
}
?>