<?php
require_once __DIR__ . '/app_config.php';

$config = site_config();
$conn = new mysqli(
    $config['db_host'],
    $config['db_username'],
    $config['db_password'],
    $config['db_name']
);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>