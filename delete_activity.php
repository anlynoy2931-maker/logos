<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$activity_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$activity_id || $activity_id < 1) {
    http_response_code(400);
    exit("Invalid activity ID.");
}

$conn = new mysqli("localhost", "root", "", "exam_registration");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

$stmt = $conn->prepare("DELETE FROM website_activities WHERE id = ?");
$stmt->bind_param("i", $activity_id);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: index.php");
exit();
