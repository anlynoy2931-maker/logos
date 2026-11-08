<?php
session_start();

// ກວດສອບ Session Admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "exam_registration");
$conn->set_charset("utf8mb4");
require_once __DIR__ . '/site_content_localization.php';
site_ensure_multilingual_content_schema($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = trim($_POST['course_name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $detail_link = trim($_POST['detail_link'] ?? '');
    $full_content = trim($_POST['full_content'] ?? '');
    $course_name_la = trim($_POST['course_name_la'] ?? '');
    $course_name_ko = trim($_POST['course_name_ko'] ?? '');
    $course_name_zh = trim($_POST['course_name_zh'] ?? '');
    $description_la = trim($_POST['description_la'] ?? '');
    $description_ko = trim($_POST['description_ko'] ?? '');
    $description_zh = trim($_POST['description_zh'] ?? '');
    $full_content_la = trim($_POST['full_content_la'] ?? '');
    $full_content_ko = trim($_POST['full_content_ko'] ?? '');
    $full_content_zh = trim($_POST['full_content_zh'] ?? '');

    $stmt = $conn->prepare("
        INSERT INTO website_courses (
            course_name, description, image, detail_link, full_content,
            course_name_la, course_name_ko, course_name_zh,
            description_la, description_ko, description_zh,
            full_content_la, full_content_ko, full_content_zh
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "ssssssssssssss",
        $course_name,
        $description,
        $image,
        $detail_link,
        $full_content,
        $course_name_la,
        $course_name_ko,
        $course_name_zh,
        $description_la,
        $description_ko,
        $description_zh,
        $full_content_la,
        $full_content_ko,
        $full_content_zh
    );

    if ($stmt->execute()) {
        echo "<script>alert('ເພີ່ມຫຼັກສູດໃໝ່ ສຳເລັດແລ້ວ!'); window.location.href='index.php';</script>";
        exit;
    } else {
        $error = "ເກີດຂໍ້ຜິດພາດ: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="la">
<head>
    <meta charset="UTF-8">
    <title>ເພີ່ມຫຼັກສູດໃໝ່</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
</head>
<body class="bg-light">
<?php include_once __DIR__ . '/site_header.php'; ?>

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="fa fa-plus-circle"></i> ເພີ່ມຫຼັກສູດໃໝ່ (Add New Course)</h4>
        </div>
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group mb-3">
                    <label>ຊື່ຫຼັກສູດ (Course Name):</label>
                    <input type="text" name="course_name" class="form-control" placeholder="ເຊັ່ນ: Bachelor of Arts in..." required>
                </div>

                <div class="form-group mb-3">
                    <label>ຄຳອະທິບາຍ (Description):</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="ອະທິບາຍກ່ຽວກັບຫຼັກສູດ..." required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label>ຊື່ຫຼັກສູດ (Lao)</label>
                    <input type="text" name="course_name_la" class="form-control">
                    <label class="mt-2">ຄຳອະທິບາຍ (Lao)</label>
                    <textarea name="description_la" class="form-control" rows="3"></textarea>
                    <label class="mt-2">ເນື້ອຫາເຕັມ (Lao)</label>
                    <textarea name="full_content_la" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label>Course name (Korean)</label>
                    <input type="text" name="course_name_ko" class="form-control">
                    <label class="mt-2">Description (Korean)</label>
                    <textarea name="description_ko" class="form-control" rows="3"></textarea>
                    <label class="mt-2">Full content (Korean)</label>
                    <textarea name="full_content_ko" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label>课程名称（中文）</label>
                    <input type="text" name="course_name_zh" class="form-control">
                    <label class="mt-2">课程说明（中文）</label>
                    <textarea name="description_zh" class="form-control" rows="3"></textarea>
                    <label class="mt-2">详细内容（中文）</label>
                    <textarea name="full_content_zh" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label>Full Content (English)</label>
                    <textarea name="full_content" class="form-control" rows="4"></textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Path ຮູບພາບ (Image Path):</label>
                    <input type="text" name="image" class="form-control" placeholder="ເຊັ່ນ: images/CS1.jpg" required>
                </div>

                <div class="form-group mb-3">
                    <label>Link ລາຍລະອຽດ (Detail Link):</label>
                    <input type="text" name="detail_link" class="form-control" placeholder="ເຊັ່ນ: computer_science.php" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">ຍົກເລີກ</a>
                    <button type="submit" class="btn btn-success">ບັນທຶກຫຼັກສູດໃໝ່</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>