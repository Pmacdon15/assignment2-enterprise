<?php

include "config.php";
include "auth.php"; // middleware for authentication

$method = $_SERVER['REQUEST_METHOD'];

$data = json_decode(file_get_contents("php://input"));

if ($role !== "instructor") {
    echo json_encode(["error" => "Only instructors can access this resource"]);
    exit;
}

if ($method === "POST") {
    if (isset($data->student_id) && isset($data->course_id) && isset($data->grade)) {
        $student_uid = $data->student_id;
        $cid = $data->course_id;
        $grade = $data->grade;

        if ($grade < 0 || $grade > 100) {
            echo json_encode(["error" => "Grade must be between 0 and 100"]);
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM $table_courses WHERE cid = :cid");
        $stmt->execute(["cid" => $cid]);
        $course = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$course) {
            echo json_encode(["error" => "Course not found"]);
            exit;
        }

        if ($course["instructor_uid"] !== $uid) {
            echo json_encode(["error" => "You are not the instructor of this course"]);
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM $table_users WHERE uid = :uid AND role = 'student'");
        $stmt->execute(["uid" => $student_uid]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student) {
            echo json_encode(["error" => "Student not found"]);
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM $table_enrollments WHERE student_uid = :student_uid AND cid = :cid");
        $stmt->execute(["student_uid" => $student_uid, "cid" => $cid]);
        $enrollment = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($enrollment) {
            $stmt = $conn->prepare("UPDATE $table_enrollments SET grade = :grade WHERE student_uid = :student_uid AND cid = :cid");
            $stmt->execute(["student_uid" => $student_uid, "cid" => $cid, "grade" => $grade]);
            echo json_encode(["message" => "Grade updated successfully"]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO $table_enrollments (student_uid, cid, grade) VALUES (:student_uid, :cid, :grade)");
        $stmt->execute(["student_uid" => $student_uid, "cid" => $cid, "grade" => $grade]);

        echo json_encode(["message" => "Grade set successfully"]);

    } else {
        echo json_encode(["error" => "student_id, course_id and grade are required"]);
    }


} else if ($method === "DELETE") {
    if (isset($data->student_id) && isset($data->course_id)) {
        $student_uid = $data->student_id;
        $cid = $data->course_id;

        $stmt = $conn->prepare("SELECT * FROM $table_courses WHERE cid = :cid");
        $stmt->execute(["cid" => $cid]);
        $course = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$course) {
            echo json_encode(["error" => "Course not found"]);
            exit;
        }

        if ($course["instructor_uid"] !== $uid) {
            echo json_encode(["error" => "You are not the instructor of this course"]);
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM $table_users WHERE uid = :uid AND role = 'student'");
        $stmt->execute(["uid" => $student_uid]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student) {
            echo json_encode(["error" => "Student not found"]);
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM $table_enrollments WHERE student_uid = :student_uid AND cid = :cid");
        $stmt->execute(["student_uid" => $student_uid, "cid" => $cid]);
        $enrollment = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$enrollment) {
            echo json_encode(["error" => "Enrollment not found"]);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM $table_enrollments WHERE student_uid = :student_uid AND cid = :cid");
        $stmt->execute(["student_uid" => $student_uid, "cid" => $cid]);

        echo json_encode(["message" => "Grade deleted successfully"]);

    } else {
        echo json_encode(["error" => "student_id and course_id are required"]);
    }

} else {
    echo json_encode(["error" => "Only the POST and DELETE methods allowed"]);
}

?>