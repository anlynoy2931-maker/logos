<?php
require_once __DIR__ . '/db.php';

/** @var mysqli $conn */

$id = intval($_POST['id'] ?? 0);
$exam_round_id = intval($_POST['exam_round_id'] ?? 0);

if ($id <= 0 || $exam_round_id <= 0) {
    die("Invalid input");
}

$stmt = $conn->prepare("
    UPDATE students 
    SET exam_round_id = ?, status = 'approved'
    WHERE id = ?
");

$stmt->bind_param("ii", $exam_round_id, $id);
$stmt->execute();

header("Location: students.php");
exit();
?>