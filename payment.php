<?php
include 'db.php';
session_start();

/* SETTINGS */
$setting = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT payment_fee, qr_image FROM settings LIMIT 1")
);

$payment_fee = $setting['payment_fee'];
$qr_image = $setting['qr_image'] ?? 'QR.png';

/* STUDENT */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ Missing student ID (please open from registration)");
}

$student_id = (int)$_GET['id'];
$stmt = $conn->prepare("
SELECT name_lao, surname_lao, tel, highschool
FROM students
WHERE id=?
");

$stmt->bind_param("i", $student_id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student) {
    die("❌ Student not found (ID = $student_id)");
}

/* HANDLE UPLOAD */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. เช็กว่ามีการแนบไฟล์และไม่มี error
    if (!isset($_FILES['payment_slip']) || $_FILES['payment_slip']['error'] !== UPLOAD_ERR_OK) {
        die("❌ Upload error code: " . ($_FILES['payment_slip']['error'] ?? 'No file uploaded'));
    }

    // 2. กำหนด Path แบบ Absolute ให้ถูกต้อง
    $uploadDir = __DIR__ . '/uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // ลบอักขระพิเศษออกจากชื่อไฟล์ ป้องกันปัญหา Path มีช่องว่างหรือภาษาไทย
    $originalName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES['payment_slip']['name']));
    $fileName = time() . '_' . $originalName;
    $targetPath = $uploadDir . $fileName;

    // 3. ตรวจสอบว่า move_uploaded_file สำเร็จจริงหรือไม่ก่อน UPDATE DB
    if (move_uploaded_file($_FILES['payment_slip']['tmp_name'], $targetPath)) {
        
        $stmt = $conn->prepare("
            UPDATE students 
            SET payment_status='paid',
                payment_slip=?,
                status='pending'
            WHERE id=?
        ");

        $stmt->bind_param("si", $fileName, $student_id);
        $stmt->execute();

        header("Location: success.php?id=" . $student_id);
        exit();
    } else {
        die("❌ Cannot move uploaded file to destination folder. Please check directory permissions.");
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="images/favicon.png" type="image/gif" />
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
<?php include_once __DIR__ . '/site_header.php'; ?>

    <div class="card shadow p-4">

        <h4>ຂໍ້ມູນຜູ້ສະໝັກ (Applicants List)</h4>

        <p><b>ຊື່ Name:</b> <?= htmlspecialchars($student['name_lao']) ?> <?= htmlspecialchars($student['surname_lao']) ?></p>
        <p><b>ເບີໂທ Phone number:</b> <?= htmlspecialchars($student['tel']) ?></p>

        <hr>

        <h5>
            ຄ່າທຳນຽມການສະໝັກ application fee:
            <span class="text-danger"><?= number_format($payment_fee) ?> ກີບ</span>
        </h5>

        <hr>

        <h5 class="text-center">QR Payment</h5>

        <div class="text-center mb-3">
            <img src="<?= htmlspecialchars($qr_image) ?>" width="250" class="border p-2">
        </div>

        <div class="alert alert-info text-center">
            ຫຼັງຈາກໂອນເງິນແລ້ວ → ອັບໂຫລດຫລັກຖານການໂອນລົງໃສ່<br>
            <small>
                After completing the transfer, please upload the payment receipt.
            </small>
        </div>
        
        <form method="POST" enctype="multipart/form-data">

            <input type="file" name="payment_slip" class="form-control" accept="image/*" required>

            <br>

            <button class="btn btn-success w-100">
                ຢືນຢັນການຊຳລະແລ້ວ Payment confirmed
            </button>

        </form>

    </div>

</body>

</html>