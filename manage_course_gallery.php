<?php
session_start();

$currentLang = ($_GET['lang'] ?? 'en') === 'la' ? 'la' : 'en';
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php?lang=' . urlencode($currentLang));
    exit();
}

require_once __DIR__ . '/app_config.php';
require_once __DIR__ . '/site_content_localization.php';

$databaseConfig = site_config();
$conn = new mysqli(
    $databaseConfig['website_db_host'],
    $databaseConfig['website_db_username'],
    $databaseConfig['website_db_password'],
    $databaseConfig['website_db_name']
);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
site_ensure_course_gallery_schema($conn);

$galleryItems = [
    1 => [
        'label' => ['en' => 'Lao cultural traditions', 'la' => 'ປະເພນີວັດທະນະທຳລາວ'],
        'alt' => ['en' => 'Students presenting Lao cultural traditions', 'la' => 'ນັກສຶກສານຳສະເໜີປະເພນີວັດທະນະທຳລາວ'],
    ],
    2 => [
        'label' => ['en' => 'Cultural event', 'la' => 'ງານວັດທະນະທຳ'],
        'alt' => ['en' => 'Students performing at a cultural event', 'la' => 'ນັກສຶກສາສະແດງໃນງານວັດທະນະທຳ'],
    ],
    3 => [
        'label' => ['en' => 'Lao traditional dance', 'la' => 'ຟ້ອນລຳປະເພນີລາວ'],
        'alt' => ['en' => 'Lao traditional dance performance', 'la' => 'ການສະແດງຟ້ອນລຳປະເພນີລາວ'],
    ],
];

$galleryImages = [];
$result = $conn->query('SELECT id, image_path FROM website_course_gallery ORDER BY id');
while ($row = $result->fetch_assoc()) {
    $galleryImages[(int) $row['id']] = $row['image_path'];
}

if (empty($_SESSION['course_gallery_csrf'])) {
    $_SESSION['course_gallery_csrf'] = bin2hex(random_bytes(32));
}

$errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($postedToken) || !hash_equals($_SESSION['course_gallery_csrf'], $postedToken)) {
        $errorMessage = 'The form expired. Reload this page and try again.';
    }

    $allowedImages = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];
    $validatedUploads = [];
    foreach ($galleryItems as $id => $item) {
        $field = 'image_' . $id;
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
            continue;
        }
        if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            $errorMessage = 'An image upload failed. Please try again.';
            break;
        }

        $temporaryFile = $_FILES[$field]['tmp_name'];
        if (!is_uploaded_file($temporaryFile)) {
            $errorMessage = 'An uploaded image could not be verified.';
            break;
        }
        $fileSize = filesize($temporaryFile);
        if ($fileSize === false || $fileSize > 5 * 1024 * 1024) {
            $errorMessage = 'Each image must be 5 MB or smaller.';
            break;
        }

        $imageInfo = getimagesize($temporaryFile);
        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $fileInfo->file($temporaryFile);
        if ($imageInfo === false || !isset($allowedImages[$mimeType])) {
            $errorMessage = 'Only JPEG, PNG, and WebP image files are allowed.';
            break;
        }

        $validatedUploads[$id] = [
            'temporary_file' => $temporaryFile,
            'extension' => $allowedImages[$mimeType],
        ];
    }

    if ($errorMessage === '' && $validatedUploads === []) {
        $errorMessage = 'Choose at least one image to upload.';
    }

    $uploadDirectory = __DIR__ . '/uploads/course-gallery';
    $newFiles = [];
    $newImagePaths = [];
    if ($errorMessage === '' && !is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true)) {
        $errorMessage = 'Could not create the course gallery image directory.';
    }
    if ($errorMessage === '' && !is_writable($uploadDirectory)) {
        $errorMessage = 'The course gallery image directory is not writable.';
    }

    if ($errorMessage === '') {
        foreach ($validatedUploads as $id => $upload) {
            $filename = bin2hex(random_bytes(16)) . '.' . $upload['extension'];
            $destination = $uploadDirectory . '/' . $filename;
            if (!move_uploaded_file($upload['temporary_file'], $destination)) {
                $errorMessage = 'Could not save an uploaded image.';
                break;
            }
            $newFiles[] = $destination;
            $newImagePaths[$id] = 'uploads/course-gallery/' . $filename;
        }
    }

    if ($errorMessage === '' && $newImagePaths !== []) {
        try {
            $conn->begin_transaction();
            $update = $conn->prepare('UPDATE website_course_gallery SET image_path = ? WHERE id = ?');
            foreach ($newImagePaths as $id => $imagePath) {
                $update->bind_param('si', $imagePath, $id);
                $update->execute();
            }
            $update->close();
            $conn->commit();

            header('Location: course.php?lang=' . urlencode($currentLang));
            exit();
        } catch (mysqli_sql_exception $exception) {
            $conn->rollback();
            $errorMessage = 'Could not save the course gallery images. Please try again.';
        }
    }

    if ($errorMessage !== '') {
        foreach ($newFiles as $newFile) {
            if (is_file($newFile)) {
                unlink($newFile);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($currentLang, ENT_QUOTES, 'UTF-8'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Lao Gallery Images</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
</head>
<body class="bg-light">
<?php include_once __DIR__ . '/site_header.php'; ?>
<main class="container py-5" style="max-width: 900px;">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h1 class="h4 mb-0">Edit Lao Gallery Images</h1>
        </div>
        <div class="card-body">
            <p class="text-muted">Upload a new image to replace any gallery photo. Images must be JPEG, PNG, or WebP and no larger than 5 MB. Leave a field empty to keep its current image.</p>
            <?php if ($errorMessage !== ''): ?>
            <div class="alert alert-danger" role="alert"><?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token"
                    value="<?= htmlspecialchars($_SESSION['course_gallery_csrf'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php foreach ($galleryItems as $id => $item): ?>
                <?php $label = $item['label'][$currentLang]; ?>
                <div class="form-group mb-4">
                    <label for="image_<?= $id; ?>"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></label>
                    <div class="mb-2">
                        <img src="<?= htmlspecialchars($galleryImages[$id], ENT_QUOTES, 'UTF-8'); ?>"
                            alt="<?= htmlspecialchars($item['alt'][$currentLang], ENT_QUOTES, 'UTF-8'); ?>"
                            style="max-width: 260px; max-height: 180px; object-fit: cover;">
                    </div>
                    <input id="image_<?= $id; ?>" type="file" name="image_<?= $id; ?>" class="form-control-file"
                        accept="image/jpeg,image/png,image/webp">
                </div>
                <?php endforeach; ?>
                <div class="d-flex justify-content-between">
                    <a href="course.php?lang=<?= urlencode($currentLang); ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save images</button>
                </div>
            </form>
        </div>
    </div>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
