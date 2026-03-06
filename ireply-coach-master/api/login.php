<?php
require "../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$username = $conn->real_escape_string($data['username']);
$password = $data['password'];

$res = $conn->query("SELECT * FROM users WHERE username='$username'");

if ($res->num_rows === 0) {
    echo json_encode(["error" => "User not found"]);
    exit;
}

$user = $res->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    echo json_encode(["error" => "Invalid password"]);
    exit;
}

echo json_encode([
    "status" => "Login successful",
    "user" => [
        "id" => $user['id'],
        "name" => $user['name'],
        "role" => $user['role']
    ]
]);