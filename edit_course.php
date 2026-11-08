<?php
session_start();

// ກວດສອບວ່າເປັນ Admin ເຂົ້າຮູບແບບລັອກອິນແລ້ວບໍ
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// ເຊື່ອມຕໍ່ Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "exam_registration";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
require_once __DIR__ . '/site_content_localization.php';
site_ensure_multilingual_content_schema($conn);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";

// ກໍລະນີມີການກົດ Submit ແກ້ໄຂຂໍ້ມູນ
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $full_content = $_POST['full_content']; // ຮັບຄ່າຈາກ Summernote
    $image = $_POST['old_image']; // ໃຊ້ຮູບເກົ່າເປັນຄ່າເລີ່ມຕົ້ນ
    $course_name_la = trim($_POST['course_name_la'] ?? '');
    $course_name_ko = trim($_POST['course_name_ko'] ?? '');
    $course_name_zh = trim($_POST['course_name_zh'] ?? '');
    $description_la = trim($_POST['description_la'] ?? '');
    $description_ko = trim($_POST['description_ko'] ?? '');
    $description_zh = trim($_POST['description_zh'] ?? '');
    $full_content_la = trim($_POST['full_content_la'] ?? '');
    $full_content_ko = trim($_POST['full_content_ko'] ?? '');
    $full_content_zh = trim($_POST['full_content_zh'] ?? '');

    // ຖ້າມີການອັບໂຫຼດຮູບໃໝ່
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "images/";
        $target_file = $target_dir . time() . "_" . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file;
        }
    }

    // ອັບເດດຂໍ້ມູນໃນ Database (ເພີ່ມ full_content)
    $stmt = $conn->prepare("
        UPDATE website_courses SET
            course_name = ?, description = ?, image = ?, detail_link = ?, full_content = ?,
            course_name_la = ?, course_name_ko = ?, course_name_zh = ?,
            description_la = ?, description_ko = ?, description_zh = ?,
            full_content_la = ?, full_content_ko = ?, full_content_zh = ?
        WHERE id = ?
    ");
    $stmt->bind_param(
        "ssssssssssssssi",
        $title,
        $description,
        $image,
        $link,
        $full_content,
        $course_name_la,
        $course_name_ko,
        $course_name_zh,
        $description_la,
        $description_ko,
        $description_zh,
        $full_content_la,
        $full_content_ko,
        $full_content_zh,
        $id
    );

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        $message = "ເກີດຂໍ້ຜິດພາດໃນການບັນທຶກ: " . $conn->error;
    }
}

// ດຶງຂໍ້ມູນເກົ່າມາສະແດງໃນຟອມ
$stmt = $conn->prepare("SELECT * FROM website_courses WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();

if (!$course) {
    echo "ບໍ່ພົບຂໍ້ມູນຫຼັກສູດນີ້!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="la">
<head>
    <meta charset="UTF-8">
    <title>ແກ້ໄຂຫຼັກສູດ</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    
    <!-- 1. Summernote CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; padding-top: 50px; padding-bottom: 50px; }
        .form-container { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<?php include_once __DIR__ . '/site_header.php'; ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 form-container">
            <h3 class="mb-4 text-center">ແກ້ໄຂຫຼັກສູດ (Edit Course)</h3>
            
            <?php if ($message): ?>
                <div class="alert alert-danger"><?= $message; ?></div>
            <?php endif; ?>

            <form action="edit_course.php?id=<?= $id; ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="old_image" value="<?= htmlspecialchars($course['image']); ?>">

                <div class="form-group mb-3">
                    <label>ຊື່ຫຼັກສູດ (Course Title)</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($course['course_name']); ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label>ລາຍລະອຽດຫຍໍ້ (Description)</label>
                    <textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($course['description']); ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label>ລິ້ງລາຍລະອຽດ (Detail Link)</label>
                    <input type="text" name="link" class="form-control" value="<?= htmlspecialchars($course['detail_link']); ?>" required>
                </div>

                <!-- 2. ເພີ່ມ Field Summernote ເນື້ອໃນລາຍລະອຽດທັງໝົດ -->
                <div class="form-group mb-3">
                    <label>ເນື້ອໃນລາຍລະອຽດທັງໝົດ (Full Content)</label>
                    <textarea id="summernote" name="full_content"><?= htmlspecialchars($course['full_content'] ?? ''); ?></textarea>
                </div>
                <div class="form-group mb-3">
                    <label>ຊື່ຫຼັກສູດ (Lao)</label>
                    <input type="text" name="course_name_la" class="form-control" value="<?= htmlspecialchars($course['course_name_la'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <label class="mt-2">ຄຳອະທິບາຍ (Lao)</label>
                    <textarea name="description_la" class="form-control" rows="3"><?= htmlspecialchars($course['description_la'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                    <label class="mt-2">ເນື້ອຫາເຕັມ (Lao)</label>
                    <textarea name="full_content_la" class="form-control" rows="4"><?= htmlspecialchars($course['full_content_la'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                <div class="form-group mb-3">
                    <label>Course name (Korean)</label>
                    <input type="text" name="course_name_ko" class="form-control" value="<?= htmlspecialchars($course['course_name_ko'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <label class="mt-2">Description (Korean)</label>
                    <textarea name="description_ko" class="form-control" rows="3"><?= htmlspecialchars($course['description_ko'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                    <label class="mt-2">Full content (Korean)</label>
                    <textarea name="full_content_ko" class="form-control" rows="4"><?= htmlspecialchars($course['full_content_ko'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                <div class="form-group mb-3">
                    <label>课程名称（中文）</label>
                    <input type="text" name="course_name_zh" class="form-control" value="<?= htmlspecialchars($course['course_name_zh'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <label class="mt-2">课程说明（中文）</label>
                    <textarea name="description_zh" class="form-control" rows="3"><?= htmlspecialchars($course['description_zh'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                    <label class="mt-2">详细内容（中文）</label>
                    <textarea name="full_content_zh" class="form-control" rows="4"><?= htmlspecialchars($course['full_content_zh'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label>ຮູບພາບ (ປ່ຽນໃໝ່ ຖ້າຕ້ອງການ)</label><br>
                    <img src="<?= htmlspecialchars($course['image']); ?>" width="120" class="mb-2 img-thumbnail"><br>
                    <input type="file" name="image" class="form-control-file" accept="image/*">
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="index.php" class="btn btn-secondary">ຍົກເລີກ</a>
                    <button type="submit" class="btn btn-primary">ບັນທຶກການແກ້ໄຂ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 3. JS Scripts ທີ່ຈຳເປັນສຳລັບ Summernote -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
  $(document).ready(function() {
    $('#summernote').summernote({
      placeholder: 'ພິມເນື້ອໃນ, ເພີ່ມຫົວຂໍ້, ຫຼື ຮູບພາບຢູ່ທີ່ນີ້...',
      tabsize: 2,
      height: 350
    });
  });
</script>

</body>
</html>