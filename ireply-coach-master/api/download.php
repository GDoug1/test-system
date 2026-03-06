<?php
require "../config/db.php";

$employee = "tester";

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="attendance.csv"');

$output = fopen("php://output", "w");

fputcsv($output, ['Date','Time In','Time Out','Total Hours']);

$res = $conn->query("
  SELECT log_date, time_in, time_out, total_hours
  FROM time_logs    
  WHERE employee_name='$employee'
  ORDER BY log_date DESC
");

while($row = $res->fetch_assoc()){
  fputcsv($output,$row);
}

fclose($output);
exit;
