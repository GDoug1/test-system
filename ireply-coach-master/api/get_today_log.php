<?php
require_once "db.php";

if (!isset($_GET['employee_id'])) {
    echo json_encode(null);
    exit;
}

$employee_id = intval($_GET['employee_id']);
$date = date("Y-m-d");

$query = "
SELECT 
    tl.time_log_id,
    tl.time_in,
    tl.time_out,
    tl.total_hours,
    al.attendance_status,
    e.first_name,
    e.last_name
FROM time_logs tl
JOIN attendance_logs al ON tl.attendance_id = al.attendance_id
JOIN employees e ON tl.employee_id = e.employee_id
WHERE tl.employee_id = ?
AND tl.log_date = ?
LIMIT 1
";

$stmt = $conn->prepare($query);
$stmt->bind_param("is", $employee_id, $date);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(null);
}

$conn->close();
?>