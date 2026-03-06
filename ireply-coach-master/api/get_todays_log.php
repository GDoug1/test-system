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
$today = date('Y-m-d');

$query = "SELECT 
    time_log_id, 
    DATE_FORMAT(time_in, '%h:%i %p') as time_in,
    DATE_FORMAT(time_out, '%h:%i %p') as time_out,
    total_hours,
    tag
FROM time_logs
WHERE employee_id = ? AND log_date = ?
ORDER BY time_log_id DESC
LIMIT 1";

$stmt = $conn->prepare($query);
$stmt->bind_param("is", $employee_id, $today);
$stmt->execute();
$result = $stmt->get_result();

$log = null;
if ($result->num_rows > 0) {
    $log = $result->fetch_assoc();
}

echo json_encode(["status" => "success", "data" => $log]);
$stmt->close();
$conn->close();
?>
