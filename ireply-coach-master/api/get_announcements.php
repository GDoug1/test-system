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
    announcement_id, title, content, 
    DATE_FORMAT(date_posted, '%M %d, %Y • %h:%i %p') as meta
FROM announcements
ORDER BY date_posted DESC
LIMIT 5";

$result = $conn->query($query);
$announcements = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $announcements[] = [
            'id' => $row['announcement_id'],
            'title' => $row['title'],
            'meta' => $row['meta'],
            'type' => 'Announcement'
        ];
    }
}

echo json_encode(["status" => "success", "data" => $announcements]);
$conn->close();
?>
