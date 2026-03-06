<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
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

$employee = $empRes->fetch_assoc()['employee_id'];

$res = $conn->query("
    SELECT * FROM time_logs
    WHERE employee_id = $employee
    AND log_date = '$today'
    ORDER BY time_log_id DESC
    LIMIT 1
");

if ($res->num_rows === 0) {
    echo json_encode([
        "time_in" => null,
        "time_out" => null,
        "total_hours" => "0h 0m",
        "status" => "Not Present"
    ]);
    exit;
}

$row = $res->fetch_assoc();

$status = "Completed";
if ($row["time_in"] && !$row["time_out"]) {
    $status = "Working";
}

$totalSeconds = 0;

if ($row["time_in"] && $row["time_out"]) {
    $totalSeconds = strtotime($row["time_out"]) - strtotime($row["time_in"]);

    /* subtract breaks */
    $breaks = $conn->query("
        SELECT break_start, break_end 
        FROM breaks 
        WHERE time_log_id = {$row['time_log_id']}
    ");

    while ($b = $breaks->fetch_assoc()) {
        if ($b["break_end"]) {
            $totalSeconds -= (strtotime($b["break_end"]) - strtotime($b["break_start"]));
        }
    }
}

$hours = floor($totalSeconds / 3600);
$minutes = floor(($totalSeconds % 3600) / 60);

echo json_encode([
    "time_in" => $row["time_in"] ? date('g:i A', strtotime($row["time_in"])) : null,
    "time_out" => $row["time_out"] ? date('g:i A', strtotime($row["time_out"])) : null,
    "total_hours" => $hours . "h " . $minutes . "m",
    "status" => $status
]);