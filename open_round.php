<?php
require_once __DIR__ . '/db.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    die("Invalid ID");
}

mysqli_query($conn, "
    UPDATE exam_rounds 
    SET status='open'
    WHERE id=$id
");

header("Location: exam_rounds.php");
exit();
?>