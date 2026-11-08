<?php
session_start();

// ກວດສອບ Login Admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// ເຊື່ອມຕໍ່ Database
$conn = new mysqli("localhost", "root", "", "exam_registration");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
require_once __DIR__ . '/site_content_localization.php';
site_ensure_multilingual_content_schema($conn);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";

// ກໍລະນີ Submit ແກ້ໄຂ
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $full_content = $_POST['full_content']; // ຮັບຄ່າເນື້ອໃນ+ຮູບພາບຈາກ Summernote
    $image = $_POST['old_image']; // ຮູບ Cover ຫຼັກ
    $title_la = trim($_POST['title_la'] ?? '');
    $title_ko = trim($_POST['title_ko'] ?? '');
    $title_zh = trim($_POST['title_zh'] ?? '');
    $description_la = trim($_POST['description_la'] ?? '');
    $description_ko = trim($_POST['description_ko'] ?? '');
    $description_zh = trim($_POST['description_zh'] ?? '');
    $full_content_la = trim($_POST['full_content_la'] ?? '');
    $full_content_ko = trim($_POST['full_content_ko'] ?? '');
    $full_content_zh = trim($_POST['full_content_zh'] ?? '');

    // ຖ້າມີການອັບໂຫຼດຮູບ Cover ໃໝ່
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "images/";
        $target_file = $target_dir . time() . "_" . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file;
        }
    }

    $stmt = $conn->prepare("
        UPDATE website_activities SET
            title = ?, description = ?, image = ?, detail_link = ?, full_content = ?,
            title_la = ?, title_ko = ?, title_zh = ?,
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
        $title_la,
        $title_ko,
        $title_zh,
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
        $message = "ເກີດຂໍ້ຜິດພາດ: " . $conn->error;
    }
}

// ດຶງຂໍ້ມູນເກົ່າມາສະແດງ
$stmt = $conn->prepare("SELECT * FROM website_activities WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$act = $stmt->get_result()->fetch_assoc();

if (!$act) {
    echo "ບໍ່ພົບຂໍ້ມູນກິດຈະກຳນີ້!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="la">
<head>
    <meta charset="UTF-8">
    <title>ແກ້ໄຂກິດຈະກຳ (Edit Activity)</title>
    
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    
    <!-- Summernote CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; padding-top: 40px; padding-bottom: 50px; }
        .form-container { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<?php include_once __DIR__ . '/site_header.php'; ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 form-container">
            <h3 class="mb-4 text-center">ແກ້ໄຂກິດຈະກຳ (Edit Activity)</h3>
            
            <?php if ($message): ?>
                <div class="alert alert-danger"><?= $message; ?></div>
            <?php endif; ?>

            <form action="edit_activity.php?id=<?= $id; ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="old_image" value="<?= htmlspecialchars($act['image']); ?>">

                <div class="form-group mb-3">
                    <label>ຊື່ກິດຈະກຳ (Title)</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($act['title']); ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label>ລາຍລະອຽດຫຍໍ້ (Description)</label>
                    <textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($act['description']); ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label>ລິ້ງລາຍລະອຽດ (Detail Link)</label>
                    <input type="text" name="link" class="form-control" value="<?= htmlspecialchars($act['detail_link']); ?>" required>
                </div>

                <!-- Field Summernote Editor ສຳລັບໃສ່ເນື້ອໃນ ແລະ ຮູບພາບຫຼາຍໆຮູບ -->
                <div class="form-group mb-3">
                    <label>ເນື້ອໃນລາຍລະອຽດທັງໝົດ & ຮູບພາບປະກອບ (Full Content & Gallery)</label>
                    <textarea id="summernote" name="full_content"><?= htmlspecialchars($act['full_content'] ?? ''); ?></textarea>
                </div>
                <fieldset class="mb-3">
                    <legend class="h6">ພາສາລາວ</legend>
                    <label for="title_la">ຊື່ກິດຈະກຳ</label>
                    <input id="title_la" name="title_la" class="form-control" value="<?= htmlspecialchars($act['title_la'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <label for="description_la" class="mt-2">ຄຳອະທິບາຍ</label>
                    <textarea id="description_la" name="description_la" class="form-control" rows="3"><?= htmlspecialchars($act['description_la'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                    <label for="full_content_la" class="mt-2">ເນື້ອຫາເຕັມ</label>
                    <textarea id="full_content_la" name="full_content_la" class="form-control" rows="4"><?= htmlspecialchars($act['full_content_la'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </fieldset>
                <fieldset class="mb-3">
                    <legend class="h6">한국어</legend>
                    <label for="title_ko">활동 제목</label>
                    <input id="title_ko" name="title_ko" class="form-control" value="<?= htmlspecialchars($act['title_ko'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <label for="description_ko" class="mt-2">설명</label>
                    <textarea id="description_ko" name="description_ko" class="form-control" rows="3"><?= htmlspecialchars($act['description_ko'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                    <label for="full_content_ko" class="mt-2">전체 내용</label>
                    <textarea id="full_content_ko" name="full_content_ko" class="form-control" rows="4"><?= htmlspecialchars($act['full_content_ko'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </fieldset>
                <fieldset class="mb-3">
                    <legend class="h6">中文</legend>
                    <label for="title_zh">活动标题</label>
                    <input id="title_zh" name="title_zh" class="form-control" value="<?= htmlspecialchars($act['title_zh'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <label for="description_zh" class="mt-2">说明</label>
                    <textarea id="description_zh" name="description_zh" class="form-control" rows="3"><?= htmlspecialchars($act['description_zh'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                    <label for="full_content_zh" class="mt-2">完整内容</label>
                    <textarea id="full_content_zh" name="full_content_zh" class="form-control" rows="4"><?= htmlspecialchars($act['full_content_zh'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </fieldset>

                <div class="form-group mb-3">
                    <label>ຮູບ Cover ຫຼັກ (ປ່ຽນໃໝ່ ຖ້າຕ້ອງການ)</label><br>
                    <?php if (!empty($act['image'])): ?>
                        <img src="<?= htmlspecialchars($act['image']); ?>" width="120" class="mb-2 img-thumbnail"><br>
                    <?php endif; ?>
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

<!-- JS Scripts ສຳລັບ Summernote -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
  $(document).ready(function() {
    $('#summernote').summernote({
      placeholder: 'ພິມເນື້ອໃນ, ແນບຮູບພາບຫຼາຍໆຮູບ, ຫຼື ຈັດຮູບແບບຕາມຕ້ອງການຢູ່ບ່ອນນີ້...',
      tabsize: 2,
      height: 350
    });
  });
</script>

</body>
</html>