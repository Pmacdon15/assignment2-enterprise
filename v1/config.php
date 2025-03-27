<?php

$host = "localhost:3308";
$db_name = "assignment2";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    die(json_encode(["error" => "Connection Failed: " . $e->getMessage()]));
}


?>