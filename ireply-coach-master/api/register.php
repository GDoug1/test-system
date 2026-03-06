<?php
require "../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$name = $conn->real_escape_string($data['name']);
$username = $conn->real_escape_string($data['username']);
$password = password_hash($data['password'], PASSWORD_DEFAULT);
$role = $data['role'];

$conn->query("
INSERT INTO users (name, username, password, role)
VALUES ('$name', '$username', '$password', '$role')
");

echo json_encode(["status" => "User registered"]);