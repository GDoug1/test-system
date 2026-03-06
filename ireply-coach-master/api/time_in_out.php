<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'config.php';

$data = json_decode(file_get_contents("php://input"), true);

$user_id = intval($data['user_id'] ?? 1);
$employee_id = intval($data['employee_id'] ?? 1);
$action = $data['action'] ?? 'time_in';
$timestamp = $data['timestamp'] ?? date('Y-m-d H:i:s');

// Debug log
error_log("Time In/Out Request: user_id=$user_id, employee_id=$employee_id, action=$action, timestamp=$timestamp");

if ($action === 'time_in') {
    $query = "INSERT INTO time_logs (user_id, employee_id, time_in, log_date, tag) 
              VALUES (?, ?, ?, DATE(?), 'On Time')";
    
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
        exit();
    }
    
    $stmt->bind_param("iiss", $user_id, $employee_id, $timestamp, $timestamp);
    
    if ($stmt->execute()) {
        $time_log_id = $stmt->insert_id;
        error_log("Time In recorded successfully. ID: $time_log_id");
        echo json_encode(["status" => "success", "message" => "Time in recorded successfully", "time_log_id" => $time_log_id]);
    } else {
        error_log("Time In failed: " . $stmt->error);
        echo json_encode(["status" => "error", "message" => "Failed to record time in: " . $stmt->error]);
    }
    $stmt->close();
} else {
    // Time Out - Get the latest time log for this employee today
    $today = date('Y-m-d');
    $select_query = "SELECT time_log_id, time_in FROM time_logs 
                    WHERE employee_id = ? AND log_date = ? AND time_out IS NULL 
                    ORDER BY time_log_id DESC LIMIT 1";
    $select_stmt = $conn->prepare($select_query);
    if (!$select_stmt) {
        echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
        exit();
    }
    
    $select_stmt->bind_param("is", $employee_id, $today);
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $log = $result->fetch_assoc();
        $time_log_id = $log['time_log_id'];
        $time_in = $log['time_in'];
        
        // Calculate total hours
        $time_in_obj = new DateTime($time_in);
        $time_out_obj = new DateTime($timestamp);
        $interval = $time_in_obj->diff($time_out_obj);
        $total_hours = $interval->h + ($interval->i / 60);
        
        $update_query = "UPDATE time_logs SET time_out = ?, total_hours = ? WHERE time_log_id = ?";
        $update_stmt = $conn->prepare($update_query);
        if (!$update_stmt) {
            echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
            exit();
        }
        
        $update_stmt->bind_param("sdi", $timestamp, $total_hours, $time_log_id);
        
        if ($update_stmt->execute()) {
            error_log("Time Out recorded successfully. ID: $time_log_id, Hours: $total_hours");
            echo json_encode(["status" => "success", "message" => "Time out recorded", "total_hours" => round($total_hours, 2)]);
        } else {
            error_log("Time Out failed: " . $update_stmt->error);
            echo json_encode(["status" => "error", "message" => "Failed to record time out: " . $update_stmt->error]);
        }
        $update_stmt->close();
    } else {
        error_log("No active time in found for employee_id=$employee_id on $today");
        echo json_encode(["status" => "error", "message" => "No active time in found for today"]);
    }
    $select_stmt->close();
}

$conn->close();
?>
