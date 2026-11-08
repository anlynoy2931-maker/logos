<?php
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $student_id = intval($_POST['student_id']);

    if (empty($_FILES['payment_slip']['name']) || $_FILES['payment_slip']['error'] !== 0) {
        die("ກະລຸນາອັບໂຫລດສະລິບການໂອນເງິນ");
    }

    $uploadDir = 'uploads/';

    $fileExt = pathinfo($_FILES['payment_slip']['name'], PATHINFO_EXTENSION);
    $fileName = time() . '_' . uniqid() . '.' . $fileExt;

    $targetFile = $uploadDir . $fileName;

    if (!move_uploaded_file($_FILES['payment_slip']['tmp_name'], $targetFile)) {
        die("Failed to move uploaded file.");
    }

  
    $countResult = $conn->query("SELECT COUNT(*) as total FROM students WHERE reg_number IS NOT NULL");
    $row = $countResult->fetch_assoc();
    $nextNumber = $row['total'] + 1;

    $reg_number = date('Y') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

 
    $sql = "UPDATE students 
            SET payment_slip = ?,
                payment_status = 'paid',
                reg_number = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $fileName, $reg_number, $student_id);

    if (!$stmt->execute()) {
        die("Database update error: " . $stmt->error);
    }

    header("Location: exam_card.php?id=" . $student_id);
    exit();

} else {
    die("Invalid request.");
}
?>