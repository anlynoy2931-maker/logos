<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once __DIR__ . '/app_config.php';
require_once __DIR__ . '/site_content_localization.php';

$currentLang = site_supported_language($_GET['lang'] ?? 'en');
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
site_ensure_holiday_notice_schema($conn);

if (empty($_SESSION['holiday_notice_csrf'])) {
    $_SESSION['holiday_notice_csrf'] = bin2hex(random_bytes(32));
}

$languages = [
    'en' => 'English',
    'la' => 'ພາສາລາວ',
    'ko' => '한국어',
    'zh' => '中文',
];
$stmt = $conn->prepare('SELECT * FROM website_holiday_notice WHERE id = 1');
$stmt->execute();
$notice = $stmt->get_result()->fetch_assoc();
$stmt->close();
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($postedToken) || !hash_equals($_SESSION['holiday_notice_csrf'], $postedToken)) {
        $errorMessage = 'The form expired. Reload this page and try again.';
    }

    foreach ($languages as $language => $languageLabel) {
        $notice['title_' . $language] = trim((string) ($_POST['title_' . $language] ?? ''));
        $notice['body_' . $language] = trim((string) ($_POST['body_' . $language] ?? ''));
        if ($notice['title_' . $language] === '' || $notice['body_' . $language] === '') {
            $errorMessage = 'Please provide a title and announcement text in every language.';
        }
    }

    $imagePaths = [
        'image_one' => $notice['image_one'],
        'image_two' => $notice['image_two'],
    ];
    $newFiles = [];
    $uploadDirectory = __DIR__ . '/uploads/holiday-notices';
    $allowedImages = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    if ($errorMessage === '') {
        foreach ($imagePaths as $field => $oldPath) {
            $clearField = 'clear_' . $field;
            if (isset($_POST[$clearField]) && $_POST[$clearField] === '1') {
                $imagePaths[$field] = '';
            }

            if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
                continue;
            }
            if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
                $errorMessage = 'An image upload failed. Please try again.';
                break;
            }
            $temporaryFile = $_FILES[$field]['tmp_name'];
            if (!is_uploaded_file($temporaryFile)) {
                $errorMessage = 'The uploaded file could not be verified.';
                break;
            }
            if (filesize($temporaryFile) > 5 * 1024 * 1024) {
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

            if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true)) {
                $errorMessage = 'Could not create the holiday image upload directory.';
                break;
            }
            if (!is_writable($uploadDirectory)) {
                $errorMessage = 'The holiday image upload directory is not writable.';
                break;
            }

            $filename = bin2hex(random_bytes(16)) . '.' . $allowedImages[$mimeType];
            $destination = $uploadDirectory . '/' . $filename;
            if (!move_uploaded_file($temporaryFile, $destination)) {
                $errorMessage = 'Could not save an uploaded image.';
                break;
            }

            $imagePaths[$field] = 'uploads/holiday-notices/' . $filename;
            $newFiles[] = $destination;
        }
    }

    if ($errorMessage === '') {
        $update = $conn->prepare("
            UPDATE website_holiday_notice SET
                title_en = ?, body_en = ?, title_la = ?, body_la = ?,
                title_ko = ?, body_ko = ?, title_zh = ?, body_zh = ?,
                image_one = ?, image_two = ?
            WHERE id = 1
        ");
        $update->bind_param(
            'ssssssssss',
            $notice['title_en'],
            $notice['body_en'],
            $notice['title_la'],
            $notice['body_la'],
            $notice['title_ko'],
            $notice['body_ko'],
            $notice['title_zh'],
            $notice['body_zh'],
            $imagePaths['image_one'],
            $imagePaths['image_two']
        );
        $update->execute();
        $update->close();

        header('Location: index.php?lang=' . urlencode($currentLang));
        exit();
    }

    foreach ($newFiles as $newFile) {
        if (is_file($newFile)) {
            unlink($newFile);
        }
    }
    $notice['image_one'] = $imagePaths['image_one'];
    $notice['image_two'] = $imagePaths['image_two'];
}
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($currentLang, ENT_QUOTES, 'UTF-8'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Holiday Announcement</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
</head>
<body class="bg-light">
<?php include_once __DIR__ . '/site_header.php'; ?>
<main class="container py-5" style="max-width: 900px;">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h1 class="h4 mb-0">Edit Holiday Announcement</h1>
        </div>
        <div class="card-body">
            <p class="text-muted">Edit the announcement in all four languages and upload up to two images. Images must be JPEG, PNG, or WebP and no larger than 5 MB each.</p>
            <?php if ($errorMessage !== ''): ?>
            <div class="alert alert-danger" role="alert"><?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token"
                    value="<?= htmlspecialchars($_SESSION['holiday_notice_csrf'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php foreach ($languages as $language => $languageLabel): ?>
                <fieldset class="border rounded p-3 mb-4">
                    <legend class="h5 w-auto px-2"><?= htmlspecialchars($languageLabel, ENT_QUOTES, 'UTF-8'); ?></legend>
                    <div class="form-group mb-3">
                        <label for="title_<?= $language; ?>">Title</label>
                        <input id="title_<?= $language; ?>" name="title_<?= $language; ?>" class="form-control"
                            maxlength="255" required
                            value="<?= htmlspecialchars($notice['title_' . $language], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="body_<?= $language; ?>">Announcement text</label>
                        <textarea id="body_<?= $language; ?>" name="body_<?= $language; ?>" class="form-control"
                            rows="4" required><?= htmlspecialchars($notice['body_' . $language], ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                </fieldset>
                <?php endforeach; ?>

                <?php foreach (['image_one' => 'Announcement image 1', 'image_two' => 'Announcement image 2'] as $field => $label): ?>
                <div class="form-group mb-4">
                    <label for="<?= $field; ?>"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></label>
                    <?php if ($notice[$field] !== ''): ?>
                    <div class="mb-2">
                        <img src="<?= htmlspecialchars($notice[$field], ENT_QUOTES, 'UTF-8'); ?>"
                            alt="<?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>"
                            style="max-width: 240px; max-height: 180px; object-fit: contain;">
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="clear_<?= $field; ?>" value="1"
                            id="clear_<?= $field; ?>">
                        <label class="form-check-label" for="clear_<?= $field; ?>">Remove this image</label>
                    </div>
                    <?php endif; ?>
                    <input id="<?= $field; ?>" type="file" name="<?= $field; ?>" class="form-control-file"
                        accept="image/jpeg,image/png,image/webp">
                </div>
                <?php endforeach; ?>

                <div class="d-flex justify-content-between">
                    <a href="index.php?lang=<?= urlencode($currentLang); ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save announcement</button>
                </div>
            </form>
        </div>
    </div>
</main>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
