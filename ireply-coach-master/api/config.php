
<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "system_hris_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "DB Connection Failed"]));
}

date_default_timezone_set("Asia/Manila");
?>
