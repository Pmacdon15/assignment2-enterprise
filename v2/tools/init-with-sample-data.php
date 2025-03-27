<?php

include "config.php";

// clear table data
$conn->exec("DELETE FROM $table_enrollments");
$conn->exec("DELETE FROM $table_courses");
$conn->exec("DELETE FROM $table_users");

$instructors = [
    ["username" => "instructor1", "password" => "password1", "uid" => "1"],
    ["username" => "instructor2", "password" => "password2", "uid" => "2"],
    ["username" => "instructor3", "password" => "password3", "uid" => "3"]
];

$students = [
    ["username" => "student1", "password" => "password1", "uid" => "4"],
    ["username" => "student2", "password" => "password2", "uid" => "5"],
    ["username" => "student3", "password" => "password3", "uid" => "6"]
];

foreach ($instructors as $instructor) {
    $stmt = $conn->prepare("INSERT INTO $table_users (uid, username, password, role) VALUES (:uid, :username, :password, 'instructor')");
    $stmt->execute(["uid" => $instructor["uid"], "username" => $instructor["username"], "password" => password_hash($instructor["password"], PASSWORD_BCRYPT)]);
}

foreach ($students as $student) {
    $stmt = $conn->prepare("INSERT INTO $table_users (uid, username, password, role) VALUES (:uid, :username, :password, 'student')");
    $stmt->execute(["uid" => $student["uid"], "username" => $student["username"], "password" => password_hash($student["password"], PASSWORD_BCRYPT)]);
}

$courses = [
    ["course_name" => "Course 1", "instructor_uid" => "1", "cid" => "1"],
    ["course_name" => "Course 2", "instructor_uid" => "2", "cid" => "2"],
    ["course_name" => "Course 3", "instructor_uid" => "3", "cid" => "3"]
];

foreach ($courses as $course) {
    $stmt = $conn->prepare("INSERT INTO $table_courses (cid, course_name, instructor_uid) VALUES (:cid, :course_name, :instructor_uid)");
    $stmt->execute(["cid" => $course["cid"], "course_name" => $course["course_name"], "instructor_uid" => $course["instructor_uid"]]);
}

echo json_encode(["message" => "Initialized successfully with sample data"]);
exit;

?>