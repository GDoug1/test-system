<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
require "../config/db.php";

$employeeName = "tester";
$today = date("Y-m-d");

$empRes = $conn->query("
    SELECT employee_id 
    FROM employees 
    WHERE first_name = '$employeeName'
    LIMIT 1
");

$employee = $empRes->fetch_assoc()['employee_id'];

$res = $conn->query("
    SELECT * FROM time_logs
    WHERE employee_id = $employee
    AND log_date = '$today'
    AND time_out IS NULL
    LIMIT 1
");

if ($res->num_rows === 0) {
    echo json_encode(["error" => "No active Time In"]);
    exit;
}

$row = $res->fetch_assoc();

$conn->query("
    UPDATE time_logs
    SET time_out = NOW()
    WHERE time_log_id = {$row['time_log_id']}
");

echo json_encode(["success" => "Time Out recorded"]);