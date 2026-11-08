<?php
include 'db.php';
require_once __DIR__ . '/db.php';

$fee = 0;

$res = mysqli_query($conn, "SELECT payment_fee FROM settings LIMIT 1");
if($res){
    $row = mysqli_fetch_assoc($res);
    $fee = $row['payment_fee'] ?? 0;
}

$time_options = [
    1 => "ພາກເຊົ້າ",
    2 => "ພາກບ່າຍ",
    3 => "ພາກຄໍ່າ"
];

$id = intval($_GET['id'] ?? 0);

// ✅ เช็ค ID
if ($id <= 0) {
    die("❌ ບໍ່ພົບ ID");
}

// ✅ Query
$sql = "
SELECT
    students.*,
    majors.major_name,
    courses.course_name,
    program_options.time_id
FROM students
LEFT JOIN majors ON students.major_id = majors.major_id
LEFT JOIN courses ON students.course_id = courses.course_id
LEFT JOIN program_options ON students.time_id = program_options.time_id
WHERE students.id = $id
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}

$student = mysqli_fetch_assoc($result);

if (!$student) {
    die("❌ ບໍ່ພົບຂໍ້ມູນ");
}
?>

<!DOCTYPE html>
<html lang="lo">

<head>
    <meta charset="UTF-8">

    <!-- IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Favicon -->
    <link rel="icon" href="images/favicon.png" type="image/gif" />

    <title>Receipt</title>

    <style>
    @page {
        size: A5 portrait;
        margin: 15mm;
    }

    .receipt-wrapper {
        margin-top: 40px;
    }

    .receipt {
        width: 175mm;
        min-height: 199mm;
        margin: auto;
        background: white;
        padding: 20mm;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        font-family: "Phetsarath OT";
        position: relative;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        page-break-inside: avoid;
    }

    .header {
        text-align: center;
    }

    .header h2 {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
    }

    .header h3 {
        margin: 0;
        font-size: 16px;
    }

    .top {
        display: flex;
        justify-content: space-between;
        margin-top: 5px;
    }

    hr {
        border: 1px solid black;
        margin: 5px 0;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 6px;
    }

    .no-border td {
        border: none;
        padding: 3px;
    }

    .summary {
        width: 100%;
        border: 1px solid #000;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .summary td {
        border: none;
        padding: 6px;
    }

    .summary td:last-child {
        width: 110px;
    }

    .paid-stamp {
        position: absolute;
        top: 35%;
        left: 25%;
        transform: rotate(-20deg);
        font-size: 70px;
        color: red;
        border: 5px solid red;
        padding: 10px 30px;
        font-weight: bold;
        opacity: 0.15;
        pointer-events: none;
    }

    .note {
        color: red;
        font-weight: bold;
        margin-top: 10px;
    }

    .btn {
        text-align: center;
        margin-top: 20px;
    }

    @media print {
        .btn {
            display: none;
        }
    }
    </style>
</head>

<body>
<?php include_once __DIR__ . '/site_header.php'; ?>

    <div class="receipt-wrapper">

       <?php if ($student['status'] != 'approved') { ?>

        <div class="receipt">
            <h3 style="color:red;text-align:center;">
                ❌ ຍັງບໍ່ທັນຈ່າຍເງິນ
            </h3>
        </div>

        <?php } else { ?>

        <div class="receipt">

            <div class="paid-stamp">PAID</div>

            <div class="header">
                <h2>ບິນຮັບເງິນ-ລົງທະບຽນເສັງ</h2>
                <h3>Entrance Exam Bill</h3>
            </div>

            <div class="top">
                <div>

                    Print: <?= date("d/m/Y H:i:s", strtotime($student['approved_at'])) ?>
                    <br>
                    By: Logos
                </div>

                <div style="text-align:right;">
                    ເລກທີ: ENR-<?= str_pad($student['id'],6,"0",STR_PAD_LEFT) ?><br>
                </div>
            </div>

            <hr>

            <table class="no-border">
                <tr>
                    <td>
                        ຊື່ (LA): <?= $student['name_lao'] ?> <?= $student['surname_lao'] ?><br>

                        ຊື່ (EN): <?= $student['name_eng'] ?> <?= $student['surname_eng'] ?><br>

                        ຫຼັກສູດ:
                        <?= $student['course_name'] ?>
                        <?= $time_options[$student['time_id']] ?? '-' ?>
                        <?= $student['major_name'] ?><br>

                        ວັນສອບ:
                        <?= !empty($student['exam_date_main']) ? date("d/m/Y", strtotime($student['exam_date_main'])) : '-' ?>
                        <br>

                        ວັນອອກບິນ:
                        <?= date("d/m/Y") ?>
                    </td>

                    <td style="text-align:right;">
                        ເບີໂທ: <?= $student['tel'] ?><br>
                    </td>
                </tr>
            </table>

            <table style="margin-top:8px;">
                <tr>
                    <th>ລາຍການ</th>
                    <th>ຈຳນວນ</th>
                    <th>ລາຄາ</th>
                    <th>ລວມ</th>
                </tr>

                <tr>
                    <td>- ຄ່າລົງທະບຽນເສັງ</td>

                    <td style="text-align:center;">1</td>

                    <td style="text-align:right;">
                        <?= number_format($fee) ?>
                    </td>

                    <td style="text-align:right;">
                        <?= number_format($fee) ?>
                    </td>
                </tr>
            </table>

            <table class="summary">
                <tr>
                    <td style="text-align:right;">ລວມເງິນທັງໝົດ =</td>
                    <td style="text-align:right;">
                        <?= number_format($fee) ?>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:right;">ສ່ວນຫຼຸດ =</td>
                    <td style="text-align:right;">0</td>
                </tr>

                <tr>
                    <td style="text-align:right;">
                        <b>ລວມຕ້ອງຈ່າຍ =</b>
                    </td>

                    <td style="text-align:right;">
                        <b><?= number_format($fee) ?></b>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:right;">ຈ່າຍແລ້ວ =</td>

                    <td style="text-align:right;">
                        <?= number_format($fee) ?>
                    </td>
                </tr>
            </table>

            <p class="note">
                ໝາຍເຫດ:
                ຄ່າລົງທະບຽນແມ່ນບໍ່ສາມາດຖອນຄືນໄດ້,
                ຖ້າໃນກໍລະນີຜູ້ກ່ຽວບໍ່ສະດວກສອບເສັງໃນເທີມດັ່ງກ່າວ,
                ທາງສະຖາບັນຈະໂອນຄ່າລົງທະບຽນໄປຄັ້ງຕໍ່ໄປ.
            </p>

        </div>

        <?php } ?>

        <div class="btn">
            <button onclick="window.print()">🖨 Print Receipt</button>
        </div>

    </div>

</body>

</html>