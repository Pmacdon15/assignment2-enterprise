<?php

// database connection
$db_host = "localhost";
$db_user = "dev";
$db_password = "dc7c7679-66d2-47ab-8513-dbcfa03718a1";
$db_name = "dev";

// table names
$table_enrollments = "ec_school_oa_enrollments";
$table_courses = "ec_school_oa_courses";
$table_users = "ec_school_oa_users";

// JWT secret key
$jwt_secret_key = "0548e245-f68c-4e0e-849d-57ec3fd4c791";

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["error" => "Connection failed: " . $e->getMessage()]));
}

?>