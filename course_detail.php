<?php
session_start();
require_once __DIR__ . '/site_content_localization.php';
$current_lang = site_supported_language($_GET['lang'] ?? 'en');

// ເຊື່ອມຕໍ່ Database
$conn = new mysqli("localhost", "root", "", "exam_registration");
$conn->set_charset("utf8mb4");
site_ensure_multilingual_content_schema($conn);

// ຮັບ ID ຈາກ URL (ຖ້າບໍ່ມີໃຫ້ Default ເປັນ ID 1)
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// ດຶງຂໍ້ມູນຫຼັກສູດຕາມ ID
$stmt = $conn->prepare("SELECT * FROM website_courses WHERE id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$course = $stmt->get_result()->fetch_assoc();

// ຖ້າບໍ່ພົບ ID ນີ້ໃຫ້ Redirect ກັບໜ້າຫຼັກ
if (!$course) {
    header("Location: index.php");
    exit();
}
$courseTitle = site_localized_value($course, 'course_name', $current_lang);
$courseDescription = site_localized_value($course, 'description', $current_lang);
$courseContent = site_localized_value($course, 'full_content', $current_lang);
?>

<!DOCTYPE html>
<html lang="<?= $current_lang; ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?= htmlspecialchars($courseTitle, ENT_QUOTES, 'UTF-8'); ?> - Logos Institute</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />

    <style>
        .header_section {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: fixed;
            top: 0; left: 0; width: 100%; z-index: 9999;
        }
        .detail_container {
            padding-top: 35px;
            padding-bottom: 60px;
        }
        .course-banner-img {
            width: 100%;
            max-height: 380px;
            object-fit: cover;
            border-radius: 8px;
        }
        /* Style ສໍາລັບຈັດຮູບແບບເນື້ອໃນທີ່ມາຈາກ Summernote Editor */
        .course-body-content {
            line-height: 1.8;
            color: #333;
        }
        .course-body-content h2, 
        .course-body-content h3, 
        .course-body-content h4 {
            color: #002b49;
            font-weight: 700;
            margin-top: 25px;
            margin-bottom: 15px;
        }
        .course-body-content img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
<?php include_once __DIR__ . '/site_header.php'; ?>

    <!-- Header Section -->
    <header class="header_section">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg custom_nav-container">
                <a class="navbar-brand" href="index.php">
                    <img src="images/logo.png" height="50px" alt="Logo">
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">HOME</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">ABOUT IFL</a></li>
                        <li class="nav-item active"><a class="nav-link" href="course.php">PROGRAMS</a></li>
                        <li class="nav-item"><a class="nav-link" href="teacher.php">PROFESSOR</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">CONTACT</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content Dynamic -->
    <div class="container detail_container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4">
                <img src="<?= htmlspecialchars($course['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($courseTitle, ENT_QUOTES, 'UTF-8'); ?>" class="course-banner-img shadow-sm">
            </div>
            <div class="col-md-6 mb-4">
                <h2 class="font-weight-bold text-uppercase" style="color: #111;"><?= htmlspecialchars($courseTitle, ENT_QUOTES, 'UTF-8'); ?></h2>
                <h5 class="text-secondary mt-3">Summary</h5>
                <p class="text-muted" style="line-height: 1.7;"><?= nl2br(htmlspecialchars($courseDescription, ENT_QUOTES, 'UTF-8')); ?></p>
            </div>
        </div>

        <hr class="my-4">

        <!-- ສະແດງເນື້ອໃນ HTML ທັງໝົດທີ່ບັນທຶກຈາກ Summernote Editor -->
        <div class="row">
            <div class="col-12 course-body-content">
                <?php if (!empty($courseContent)): ?>
                    <?= $courseContent; ?>
                <?php else: ?>
                    <p class="text-muted">ບໍ່ມີຂໍ້ມູນລາຍລະອຽດເພີ່ມເຕີມ</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-5">
            <a href="index.php" class="btn btn-outline-secondary">&larr; Back to Home</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer_section bg-dark text-white text-center py-3">
        <p class="mb-0">&copy; <?= date('Y'); ?> Logos Institute. All Rights Reserved.</p>
    </footer>

</body>
</html>