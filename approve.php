<?php
include "db.php";

$id = intval($_GET['id']);

$reg_number = date('Y') . '-' . str_pad($id, 4, '0', STR_PAD_LEFT);

/* ดึงรอบสอบที่เปิดอยู่ */
$round = mysqli_query(
    $conn,
    "SELECT id FROM exam_rounds
     WHERE status='open'
     ORDER BY id DESC
     LIMIT 1"
);

$round_row = mysqli_fetch_assoc($round);

$exam_round_id = $round_row['id'] ?? 0;

/* อนุมัติ */
$sql = "
UPDATE students
SET
    status='approved',
    reg_number='$reg_number',
    exam_round_id='$exam_round_id'
WHERE id='$id'
";

mysqli_query($conn, $sql);

header("Location: students.php");
exit;
?>