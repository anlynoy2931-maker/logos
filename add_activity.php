<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "exam_registration");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
require_once __DIR__ . '/site_content_localization.php';
site_ensure_multilingual_content_schema($conn);

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $detail_link = trim($_POST['detail_link'] ?? '');
    $full_content = trim($_POST['full_content'] ?? '');
    $title_la = trim($_POST['title_la'] ?? '');
    $title_ko = trim($_POST['title_ko'] ?? '');
    $title_zh = trim($_POST['title_zh'] ?? '');
    $description_la = trim($_POST['description_la'] ?? '');
    $description_ko = trim($_POST['description_ko'] ?? '');
    $description_zh = trim($_POST['description_zh'] ?? '');
    $full_content_la = trim($_POST['full_content_la'] ?? '');
    $full_content_ko = trim($_POST['full_content_ko'] ?? '');
    $full_content_zh = trim($_POST['full_content_zh'] ?? '');

    if ($title === '' || $description === '' || $image === '' || $detail_link === '') {
        $error = "Please fill in all required fields.";
    } else {
        $stmt = $conn->prepare("
            INSERT INTO website_activities (
                title, description, image, detail_link, full_content,
                title_la, title_ko, title_zh,
                description_la, description_ko, description_zh,
                full_content_la, full_content_ko, full_content_zh
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "ssssssssssssss",
            $title,
            $description,
            $image,
            $detail_link,
            $full_content,
            $title_la,
            $title_ko,
            $title_zh,
            $description_la,
            $description_ko,
            $description_zh,
            $full_content_la,
            $full_content_ko,
            $full_content_zh
        );
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Activity</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
</head>
<body class="bg-light">
<?php include_once __DIR__ . '/site_header.php'; ?>
    <main class="container mt-5" style="max-width: 700px;">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h1 class="h4 mb-0"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Activity</h1>
            </div>
            <div class="card-body">
                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="form-group mb-3">
                        <label for="title">Activity title</label>
                        <input id="title" type="text" name="title" class="form-control" required
                            value="<?= htmlspecialchars($_POST['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="3" required><?= htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                    <fieldset class="mb-3">
                        <legend class="h6">ພາສາລາວ</legend>
                        <label for="title_la">ຊື່ກິດຈະກຳ</label>
                        <input id="title_la" name="title_la" class="form-control">
                        <label for="description_la" class="mt-2">ຄຳອະທິບາຍ</label>
                        <textarea id="description_la" name="description_la" class="form-control" rows="3"></textarea>
                        <label for="full_content_la" class="mt-2">ເນື້ອຫາເຕັມ</label>
                        <textarea id="full_content_la" name="full_content_la" class="form-control" rows="4"></textarea>
                    </fieldset>
                    <fieldset class="mb-3">
                        <legend class="h6">한국어</legend>
                        <label for="title_ko">활동 제목</label>
                        <input id="title_ko" name="title_ko" class="form-control">
                        <label for="description_ko" class="mt-2">설명</label>
                        <textarea id="description_ko" name="description_ko" class="form-control" rows="3"></textarea>
                        <label for="full_content_ko" class="mt-2">전체 내용</label>
                        <textarea id="full_content_ko" name="full_content_ko" class="form-control" rows="4"></textarea>
                    </fieldset>
                    <fieldset class="mb-3">
                        <legend class="h6">中文</legend>
                        <label for="title_zh">活动标题</label>
                        <input id="title_zh" name="title_zh" class="form-control">
                        <label for="description_zh" class="mt-2">说明</label>
                        <textarea id="description_zh" name="description_zh" class="form-control" rows="3"></textarea>
                        <label for="full_content_zh" class="mt-2">完整内容</label>
                        <textarea id="full_content_zh" name="full_content_zh" class="form-control" rows="4"></textarea>
                    </fieldset>
                    <div class="form-group mb-3">
                        <label for="image">Image path</label>
                        <input id="image" type="text" name="image" class="form-control" required
                            placeholder="images/activities 2.jpg"
                            value="<?= htmlspecialchars($_POST['image'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail_link">Detail link</label>
                        <input id="detail_link" type="text" name="detail_link" class="form-control" required
                            placeholder="Activities.php"
                            value="<?= htmlspecialchars($_POST['detail_link'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="full_content">Full details (optional)</label>
                        <textarea id="full_content" name="full_content" class="form-control" rows="5"><?= htmlspecialchars($_POST['full_content'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">Save activity</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
