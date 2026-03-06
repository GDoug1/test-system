<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'config.php';

$employee_id = $_GET['employee_id'] ?? 1;

$query = "SELECT 
    schedule_id, shift_type, 
    DATE_FORMAT(start_time, '%h:%i %p') as start_time,
    DATE_FORMAT(end_time, '%h:%i %p') as end_time,
    work_setup
FROM schedules
WHERE employee_id = ? OR employee_id IS NULL
ORDER BY day_of_week ASC
LIMIT 1";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();

$schedule = null;
if ($result->num_rows > 0) {
    $schedule = $result->fetch_assoc();
}

echo json_encode(["status" => "success", "data" => $schedule]);
$stmt->close();
$conn->close();
?>
