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

$cluster_id = $_GET['cluster_id'] ?? 1;
$today = date('Y-m-d');

$query = "SELECT 
    e.employee_id,
    CONCAT(e.first_name, ' ', e.last_name) as name,
    CASE 
        WHEN tl.time_in IS NOT NULL AND tl.time_out IS NULL THEN 'Present'
        WHEN tl.time_in IS NOT NULL AND tl.time_out IS NOT NULL THEN 'Completed'
        ELSE 'Absent'
    END as status
FROM employees e
LEFT JOIN cluster_members cm ON e.employee_id = cm.employee_id
LEFT JOIN time_logs tl ON e.employee_id = tl.employee_id AND tl.log_date = ?
WHERE cm.cluster_id = ?
ORDER BY FIELD(status, 'Present', 'Completed', 'Absent'), e.first_name";

$stmt = $conn->prepare($query);
$stmt->bind_param("si", $today, $cluster_id);
$stmt->execute();
$result = $stmt->get_result();

$members = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }
}

echo json_encode(["status" => "success", "data" => $members]);
$stmt->close();
$conn->close();
?>
