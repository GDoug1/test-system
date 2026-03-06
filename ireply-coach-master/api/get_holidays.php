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

$query = "SELECT 
    holiday_id, holiday_name, 
    DATE_FORMAT(holiday_date, '%B %d') as date
FROM holidays
ORDER BY holiday_date ASC";

$result = $conn->query($query);
$holidays = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $holidays[] = [
            'id' => $row['holiday_id'],
            'label' => $row['holiday_name'],
            'date' => $row['date'],
            'kind' => 'Holiday'
        ];
    }
}

echo json_encode(["status" => "success", "data" => $holidays]);
$conn->close();
?>
