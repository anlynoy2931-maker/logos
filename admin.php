<?php
session_start();

require_once __DIR__ . '/db.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

/* ================= SETTINGS ================= */
$setting = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM settings LIMIT 1")
);

$payment_fee = $setting['payment_fee'];

if(isset($_POST['update_setting'])){

    $fee = str_replace(['.', ','], '', $_POST['payment_fee']);

    mysqli_query($conn, "
        UPDATE settings 
        SET payment_fee='$fee'
        LIMIT 1
    ");

    header("Location: admin.php");
    exit();
}

/* ================= DASHBOARD DATA ================= */
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM students"))['total'];

$bachelor = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM students WHERE degree_type='bachelor'"
))['total'];

$diploma = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM students WHERE degree_type='diploma'"
))['total'];

$cont = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM students WHERE degree_type='bachelor_cont'"
))['total'];

$approved = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM students WHERE status='approved'"
))['total'];

$pending = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM students WHERE status='pending'"
))['total'];

$rejected = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM students WHERE status='rejected'"
))['total'];

$exam_done = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM students WHERE exam_round_id IS NOT NULL"
))['total'];

/* ================= EXAM ROUND COUNT ================= */
$q_round = mysqli_query($conn, "SELECT COUNT(*) as total FROM exam_rounds");
$round_total = mysqli_fetch_assoc($q_round)['total'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="icon" href="images/favicon.png" type="image/gif" />

    <title>Admin Dashboard</title>

    <style>
    body {
        font-family: Arial;
        background: #f0f2f5;
        padding: 30px;
    }

    h2 {
        text-align: center;
    }

    .stats {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
    }

    .box {
        background: white;
        padding: 20px;
        border-radius: 10px;
        width: 200px;
        text-align: center;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .box h1 {
        margin: 0;
    }

    .green {
        border-left: 10px solid #4caf50;
    }

    .blue {
        border-left: 10px solid #2196f3;
    }

    .yellow {
        border-left: 10px solid #ff9800;
    }

    .setting-box {
        max-width: 400px;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        box-sizing: border-box;
    }

    button {
        width: 100%;
        padding: 10px;
        background: #2196f3;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }
    </style>
</head>

<body>
<?php include_once __DIR__ . '/site_header.php'; ?>

    <h2>Admin Dashboard</h2>

    <div style="text-align:center;">
        <button onclick="window.location='index.php'"
            style="padding:20px 10px; background:#28a745; color:#fff; border:none; border-radius:5px;">
            ⬅ ກັບໜ້າຫຼັກ
        </button>
    </div>

    <!-- ================= SETTINGS ================= -->
    <div class="setting-box">
        <h3>⚙️ ຕັ້ງຄ່າລະບົບ</h3>

        <form method="POST">
            <label>ຄ່າທຳນຽມສະໝັກ (ກີບ)</label>

            <input type="text" name="payment_fee" value="<?= $payment_fee ?>">

            <button type="submit" name="update_setting">
                💾 ບັນທຶກ
            </button>
        </form>
    </div>

    <!-- ================= STATS ================= -->
    <div class="stats">

        <!-- รอบสอบ -->
        <div class="box green" onclick="window.location='exam_rounds.php';">
            <h2>📅 ຮອບສອບ</h2>
            <h1><?= $round_total ?></h1>
        </div>

        <div class="box green" onclick="window.location='students.php?filter=all';">
            <h2>👨‍🎓ຜູ້ສະໝັກທັງໝົດ</h2>
            <h1><?= $total ?></h1>
        </div>

        <div class="box green" onclick="window.location='students.php?degree=bachelor';">
            <h2>ປະລິນຍາຕີ</h2>
            <h1><?= $bachelor ?></h1>
        </div>

        <div class="box yellow" onclick="window.location='students.php?degree=diploma';">
            <h2>ອະນຸປະລິນຍາ</h2>
            <h1><?= $diploma ?></h1>
        </div>

        <div class="box blue" onclick="window.location='students.php?degree=bachelor_cont';">
            <h2>ຕໍ່ເນືອງ</h2>
            <h1><?= $cont ?></h1>
        </div>

    </div>

</body>

</html>