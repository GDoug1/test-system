<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "timelogger");

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}
?>