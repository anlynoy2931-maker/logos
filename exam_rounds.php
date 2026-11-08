<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/db.php';

/** @var mysqli $conn */

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

if(!isset($_SESSION['admin'])){
    header("Location: admin_system.php");
    exit();
}

$sql = "SELECT * FROM exam_rounds ORDER BY id DESC";
$result = $conn->query($sql);

if(!$result){
    die("SQL ERROR: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="lo">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="images/favicon.png" type="image/gif" />
    <title>Exam Rounds</title>

    <style>
        body {
            font-family: Phetsarath OT;
            background: #f4f6f9;
            padding: 20px;
        }
        h2 { text-align: center; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #3498db;
            color: white;
        }
        .status-open { color: green; font-weight: bold; }
        .status-close { color: red; font-weight: bold; }
    </style>
</head>

<body>
<?php include_once __DIR__ . '/site_header.php'; ?>

<h2>📅 ຈັດການຮອບສອບ</h2>

<div style="text-align:center;">
    <button onclick="window.location='admin.php'"
        style="background:#28a745; color:#fff; border:none; padding:10px 25px; border-radius:8px;">
        ⬅ ກັບໄປໜ້າຫຼັກ
    </button>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Round</th>
        <th>🌅 ພາກເຊົ້າ (Morning)</th>
        <th>🌆 ພາກຄໍ່າ (Evening)</th>
        <th>Status</th>
        <th>Manage</th>
    </tr>

<?php while($row = $result->fetch_assoc()){ ?>

    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['round_name']) ?></td>

        <!-- 🌅 Morning (from DB) -->
<td>
    <?= date("d/m/Y", strtotime($row['exam_date_main'])) ?><br>
    <b>
        <?= date("h:i A", strtotime($row['exam_time_main'])) ?>
    </b>
</td>

        <!-- 🌆 Evening (from DB) -->
       <td>
    <?= date("d/m/Y", strtotime($row['exam_date_diploma'])) ?><br>
    <b>
        <?= date("h:i A", strtotime($row['exam_time_diploma'])) ?>
    </b>
</td>

        <!-- Status -->
        <td>
            <?php if($row['status'] == 'open'){ ?>
                <span class="status-open">open</span>
            <?php } else { ?>
                <span class="status-close">closed</span>
            <?php } ?>
        </td>

        <!-- Manage -->
        <td>
            <?php if($row['status']=='open'){ ?>
                <a href="close_round.php?id=<?= $row['id'] ?>">🔒 ປິດ</a>
            <?php } else { ?>
                <a href="open_round.php?id=<?= $row['id'] ?>">🔓 ເປີດ</a>
            <?php } ?>
            |
            <a href="edit_round.php?id=<?= $row['id'] ?>">✏️ ແກ້ໄຂ</a>
            |
            <a href="delete_round.php?id=<?= $row['id'] ?>" 
               onclick="return confirm('คุณแน่ใจจะลบหรือไม่?')">
               🗑 ລົບ
            </a>
        </td>
    </tr>

<?php } ?>

</table>

</body>
</html>