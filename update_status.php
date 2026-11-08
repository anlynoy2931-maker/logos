<?php
include __DIR__ . '/db.php';

$id = intval($_GET['id'] ?? 0);
$status = 'approved';

$sql = "UPDATE students 
        SET status='$status' 
        WHERE id=$id";

$conn->query($sql);

header("Location: admin.php");
exit();
?>