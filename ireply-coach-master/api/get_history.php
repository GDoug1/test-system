<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
require "../config/db.php";

$employeeName = "tester";

$empRes = $conn->query("
    SELECT employee_id 
    FROM employees 
    WHERE first_name = '$employeeName'
    LIMIT 1
");

$employee = $empRes->fetch_assoc()['employee_id'];

$res = $conn->query("
  SELECT log_date, time_in, time_out
  FROM time_logs
  WHERE employee_id = $employee
  ORDER BY log_date DESC
");

$data = [];

while ($row = $res->fetch_assoc()) {
  $data[] = $row;
}

echo json_encode($data);