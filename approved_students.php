<?php
session_start();
require_once __DIR__ . '/db.php';

/** @var mysqli $conn */

if (!isset($_SESSION['admin'])) {
    header("Location: admin_system.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM students WHERE status='approved'");

if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}


$major_text = [
    1 => "ສາຂາ ພາສາອັງກິດ(English Language)",
    2 => "ສາຂາ ພາສາຈີນ (Chinese Language)",
    3 => "ສາຂາ ພາສາອັງເກົາຫຼີ (Korean Language)",
    4 => "ສາຂາ ວິທະຍາສາດຄອມພິວເຕີ (Computer Science)"
];

$course_text = [];
$course_query = mysqli_query($conn, "SELECT * FROM courses");
while ($c = mysqli_fetch_assoc($course_query)) {
    $course_text[$c['course_id']] = $c['course_name'];
}

$time_text = [];
$time_query = mysqli_query($conn, "
    SELECT program_options.time_id, study_time.time_name
    FROM program_options
    LEFT JOIN study_time 
    ON program_options.time_id = study_time.time_id
");

while ($t = mysqli_fetch_assoc($time_query)) {
    $time_text[$t['time_id']] = $t['time_name'];
}
?>

<!DOCTYPE html>
<html lang="lo">

<head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="icon" href="images/favicon.png" type="image/gif" />

    <title>Approved Students</title>

    <style>
    body {
        font-family: "Phetsarath OT";
        background: #f4f6f9;
        margin: 40px;
    }

    h2 {
        text-align: center;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        background: white;
        font-size: 14px;
    }

    th {
        position: sticky;
        top: 0;
        background: #3498db;
        color: white;
        z-index: 10;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    tr:hover {
        background: #f1f1f1;
    }

    .logout {
        position: fixed;
        top: 20px;
        right: 20px;
    }

    .logout a {
        background: #e74c3c;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
    }
    </style>
</head>

<body>
<?php include_once __DIR__ . '/site_header.php'; ?>

    <!-- HEADER -->
    <h2>ລາຍຊື່ທີ່ອະນຸມັດແລ້ວ</h2>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <!-- TABLE -->
    <table>
        <tr>
            <th>No</th>
            <th>Name Lao</th>
            <th>Surname</th>
            <th>Eng Name</th>
            <th>Gender</th>
            <th>DOB</th>
            <th>Tel</th>
            <th>Major</th>
            <th>Course</th>
            <th>Time</th>
            <th>Photo</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Reg</th>
            <th>Manage</th>
        </tr>

        <?php
$i = 1;
while ($row = mysqli_fetch_assoc($result)) {
?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= $row['name_lao'] ?></td>
            <td><?= $row['surname_lao'] ?></td>
            <td><?= $row['name_eng'] ?></td>
            <td><?= $row['gender'] ?></td>
            <td><?= !empty($row['dob']) ? date("d/m/Y", strtotime($row['dob'])) : "-" ?></td>
            <td><?= $row['tel'] ?></td>
            <td><?= $major_text[$row['major_id']] ?? "-" ?></td>
            <td><?= $course_text[$row['course_id']] ?? "-" ?></td>
            <td><?= $time_text[$row['time_id']] ?? "-" ?></td>
            <td><a href="uploads/<?= $row['photo'] ?>" target="_blank">View</a></td>
            <td><a href="uploads/<?= $row['payment_slip'] ?>" target="_blank">Slip</a></td>
            <td><?= $row['status'] ?></td>
            <td><?= $row['reg_number'] ?></td>
            <td><a href="exam_card.php?id=<?= $row['id'] ?>" target="_blank">🖨 Card</a></td>
        </tr>
        <?php } ?>

    </table>

</body>

</html>