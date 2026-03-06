<?php
require "../config/db.php";

$employee_id = $_GET['employee_id'];
$today = date("Y-m-d");
$now = date("Y-m-d H:i:s");

$check = $conn->query("
SELECT * FROM time_logs
WHERE employee_id=$employee_id
AND log_date='$today'
");

if ($check->num_rows > 0) {
    echo json_encode(["error" => "Already timed in"]);
    exit;
}

$conn->query("
INSERT INTO time_logs (employee_id, log_date, time_in)
VALUES ($employee_id, '$today', '$now')
");

$conn->query("
INSERT INTO attendance (employee_id, attendance_date, attendance_status)
VALUES ($employee_id, '$today', 'Present')
");

echo json_encode(["status" => "Timed In"]);