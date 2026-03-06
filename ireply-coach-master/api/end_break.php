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
UPDATE breaks
SET break_end='$now'
WHERE time_log_id=$time_log_id
AND break_end IS NULL
");

echo json_encode(["status" => "Break Ended"]);