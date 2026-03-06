<?php
require "../config/db.php";

$employee_id = $_GET['employee_id'];
$today = date("Y-m-d");
$now = date("Y-m-d H:i:s");

$log = $conn->query("
SELECT time_log_id FROM time_logs
WHERE employee_id=$employee_id
AND log_date='$today'
AND time_out IS NULL
")->fetch_assoc();

if (!$log) {
    echo json_encode(["error" => "Not timed in"]);
    exit;
}

$time_log_id = $log['time_log_id'];

$conn->query("
INSERT INTO breaks (time_log_id, break_start)
VALUES ($time_log_id, '$now')
");

echo json_encode(["status" => "Break Started"]);