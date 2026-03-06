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

// Get user_id from query parameter (default to 1 for tester1)
$user_id = $_GET['user_id'] ?? 1;

// Fetch user and employee data
$query = "SELECT 
    u.user_id, u.email, 
    e.employee_id, e.first_name, e.middle_name, e.last_name, 
    e.position, e.cluster_id, 
    r.role_name
FROM users u
LEFT JOIN employees e ON u.user_id = e.user_id
LEFT JOIN roles r ON u.role_id = r.role_id
WHERE u.user_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode(["status" => "success", "data" => $user]);
} else {
    echo json_encode(["status" => "error", "message" => "User not found"]);
}

$stmt->close();
$conn->close();
?>
