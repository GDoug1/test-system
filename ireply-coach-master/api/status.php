<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
require "../config/db.php";

$employeeName = "tester";
$today = date("Y-m-d");

/* Get employee_id */
$empRes = $conn->query("
    SELECT employee_id 
    FROM employees 
    WHERE first_name = '$employeeName'
    LIMIT 1
");

if ($empRes->num_rows === 0) {
    echo json_encode(["error" => "Employee not found"]);
    exit;
}

$employee = $empRes->fetch_assoc()['employee_id'];

/* Get latest log */
$res = $conn->query("
    SELECT * FROM time_logs
    WHERE employee_id = $employee
    AND log_date = '$today'
    ORDER BY time_log_id DESC
    LIMIT 1
");

if ($res->num_rows === 0) {
    echo json_encode([
        "timedIn" => false,
        "onBreak" => false,
        "timeIn" => null,
        "timeOut" => null,
        "breakStart" => null
    ]);
    exit;
}

$log = $res->fetch_assoc();

/* Check break table */
$breakRes = $conn->query("
    SELECT * FROM breaks
    WHERE time_log_id = {$log['time_log_id']}
    AND break_end IS NULL
    ORDER BY id DESC
    LIMIT 1
");

$onBreak = $breakRes->num_rows > 0;

echo json_encode([
    "timedIn"    => $log["time_in"] && !$log["time_out"],
    "onBreak"    => $onBreak,
    "timeIn"     => $log["time_in"],
    "timeOut"    => $log["time_out"],
    "breakStart" => $onBreak ? $breakRes->fetch_assoc()["break_start"] : null
]);