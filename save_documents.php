<?php
require_once __DIR__ . '/db.php';

if (
    empty($_FILES['photo']['name']) ||
    empty($_FILES['id_card']['name']) ||
    empty($_FILES['highschool_certificate']['name']) ||
    empty($_FILES['certificate']['name'])
) {
    echo "ກະລຸນາອັບໂຫລດເອກກະສານໃຫ້ຄົບ";
    exit();
}

$upload_dir = "uploads/";

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

function uploadFile($file, $upload_dir) {
    $filename = time() . "_" . uniqid() . "_" . basename($file["name"]);
    $target = $upload_dir . $filename;

    move_uploaded_file($file["tmp_name"], $target);

    return $filename;
}

$student_id = intval($_POST['student_id']);

$photo = uploadFile($_FILES['photo'], $upload_dir);
$id_card = uploadFile($_FILES['id_card'], $upload_dir);
$highschool_certificate = uploadFile($_FILES['highschool_certificate'], $upload_dir);
$certificate = uploadFile($_FILES['certificate'], $upload_dir);

$sql = "UPDATE students SET
    photo = '$photo',
    id_card = '$id_card',
    highschool_certificate = '$highschool_certificate',
    certificate = '$certificate'
WHERE id = $student_id";

if ($conn->query($sql) === TRUE) {
    header("Location: payment.php?id=" . $student_id);
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>