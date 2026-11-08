<?php
require_once __DIR__ . '/db.php';

$id = intval($_GET['id'] ?? 0);

$stmt = $conn->prepare("UPDATE exam_rounds SET status='closed' WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: exam_rounds.php");
exit();
?>