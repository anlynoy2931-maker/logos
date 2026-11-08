<?php
require_once __DIR__ . '/db.php';

/** @var mysqli $conn */

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    die("ID ไม่ถูกต้อง");
}

$stmt = $conn->prepare("SELECT * FROM exam_rounds WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    die("ไม่พบข้อมูล");
}

$row = $result->fetch_assoc();

if (isset($_POST['update'])) {

    $round_name = $_POST['round_name'];

    $exam_date_main = !empty($_POST['exam_date_main'])
        ? DateTime::createFromFormat('d/m/Y', $_POST['exam_date_main'])?->format('Y-m-d')
        : null;

    $exam_date_diploma = !empty($_POST['exam_date_diploma'])
        ? DateTime::createFromFormat('d/m/Y', $_POST['exam_date_diploma'])?->format('Y-m-d')
        : null;

  $exam_time_main = !empty($_POST['exam_time_main'])
    ? date("H:i:s", strtotime($_POST['exam_time_main']))
    : '00:00:00';

$exam_time_diploma = !empty($_POST['exam_time_diploma'])
    ? date("H:i:s", strtotime($_POST['exam_time_diploma']))
    : '00:00:00';

    $stmt = $conn->prepare("
        UPDATE exam_rounds SET
        round_name=?,
        exam_date_main=?,
        exam_time_main=?,
        exam_date_diploma=?,
        exam_time_diploma=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "sssssi",
        $round_name,
        $exam_date_main,
        $exam_time_main,
        $exam_date_diploma,
        $exam_time_diploma,
        $id
    );

    if (!$stmt->execute()) {
        die("ERROR: " . $stmt->error);
    }

    header("Location: exam_rounds.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="images/favicon.png" type="image/gif" />
    <title>Edit Exam Round</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
    body {
        background: #f4f6f9;
    }

    .card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    }

    .title {
        font-weight: 700;
        color: #333;
    }

    .section-title {
        margin-top: 20px;
        font-weight: 600;
        color: #0d6efd;
    }

    input {
        border-radius: 10px !important;
    }
    </style>
</head>

<body>
<?php include_once __DIR__ . '/site_header.php'; ?>

    <div class="container mt-5">
        <div class="card p-4">
            <h3 class="title mb-3">📅 ແກ້ໄຂຮອບສອບ</h3>

            <form method="POST">
                <label class="form-label">ຮອບ</label>
                <input type="text" name="round_name" class="form-control mb-3"
                    value="<?= htmlspecialchars($row['round_name']) ?>">

                <div class="section-title">🎓 Bachelor + ຕໍ່ເນື່ອງ</div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">ວັນສອບ</label>
                        <input type="text" id="exam_date_main" name="exam_date_main" class="form-control"
                            value="<?= !empty($row['exam_date_main']) && $row['exam_date_main'] != '0000-00-00' ? date('d/m/Y', strtotime($row['exam_date_main'])) : '' ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">ເວລາ</label>
                        <input type="text" id="exam_time_main" name="exam_time_main" class="form-control"
                            value="<?= (!empty($row['exam_time_main'])) ? date('H:i', strtotime($row['exam_time_main'])) : '' ?>">
                    </div>
                </div>

                <div class="section-title">📘 Diploma</div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">ວັນສອບ</label>
                        <input type="text" id="exam_date_diploma" name="exam_date_diploma" class="form-control"
                            value="<?= !empty($row['exam_date_diploma']) && $row['exam_date_diploma'] != '0000-00-00' ? date('d/m/Y', strtotime($row['exam_date_diploma'])) : '' ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">ເວລາ</label>
                        <input type="text" id="exam_time_diploma" name="exam_time_diploma" class="form-control"
                            value="<?= (!empty($row['exam_time_diploma'])) ? date('H:i', strtotime($row['exam_time_diploma'])) : '' ?>">
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" name="update" class="btn btn-primary px-4">
                        💾ບັນທຶກ
                    </button>
                    <a href="exam_rounds.php" class="btn btn-secondary px-4">
                        ⬅ ກັບ
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
  
    flatpickr("#exam_date_main", {
        dateFormat: "d/m/Y"
    });
    flatpickr("#exam_date_diploma", {
        dateFormat: "d/m/Y"
    });


    flatpickr("#exam_time_main", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K",
        time_24hr: false
    });

    flatpickr("#exam_time_diploma", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K",
        time_24hr: false
    });
    </script>

</body>

</html>