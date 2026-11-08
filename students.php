<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: admin_system.php");
    exit();
}

include 'db.php';
require_once __DIR__ . '/db.php';
/** @var mysqli $conn */



$filter = $_GET['filter'] ?? 'all';

$degree = isset($_GET['degree']) 
    ? trim($_GET['degree']) 
    : '';

if(isset($_GET['degree'])){
    $degree = trim($_GET['degree']);
}

$program_id = intval($_GET['program_id'] ?? 0);
$round_filter = intval($_GET['round'] ?? 0);

$sql = "
SELECT 
    s.*,
    m.major_name,
    c.course_name,
    t.time_name,
    
    m2.major_name AS backup_major,
    c2.course_name AS backup_course,
    t2.time_name AS backup_time,
    
    r.exam_date_main,
    r.exam_time_main

FROM students s

LEFT JOIN majors m 
ON s.major_id = m.major_id

LEFT JOIN courses c 
ON s.course_id = c.course_id

LEFT JOIN study_time t 
ON s.time_id = t.time_id


LEFT JOIN majors m2
ON s.backup_major_id = m2.major_id

LEFT JOIN courses c2
ON s.backup_course_id = c2.course_id

LEFT JOIN study_time t2
ON s.backup_time_id = t2.time_id

LEFT JOIN exam_rounds r
ON s.exam_round_id = r.id

WHERE 1=1
";


if ($filter === 'approved') {
    $sql .= " AND s.status='approved'";
}

if ($filter === 'pending') {
    $sql .= " AND (s.status IS NULL OR s.status='pending')";
}

if (!empty($degree)) {
    $sql .= " AND s.degree_type = '" . mysqli_real_escape_string($conn, $degree) . "'";
}


if ($program_id > 0) {

    $program_sql = "
        SELECT major_id, course_id, time_id
        FROM program_options
        WHERE program_id = $program_id
        LIMIT 1
    ";

    $program_result = mysqli_query($conn, $program_sql);

    if($program_row = mysqli_fetch_assoc($program_result)){

        $major_id  = $program_row['major_id'];
        $course_id = $program_row['course_id'];
        $time_id   = $program_row['time_id'];

        $sql .= "
            AND s.major_id = '$major_id'
            AND s.course_id = '$course_id'
            AND s.time_id = '$time_id'
        ";
    }
}


if ($round_filter > 0) {
    $sql .= " AND s.exam_round_id = $round_filter";
}

$sql .= " ORDER BY s.id DESC";


$result = mysqli_query($conn, $sql);

if(!$result){
    die("Query Error: " . mysqli_error($conn));
}
?>

<?php
$major_text = [
    1 => "ສາຂາ ພາສາອັງກິດ(English Language)",
    2 => "ສາຂາ ພາສາຈີນ (Chinese Language)",
    3 => "ສາຂາ ພາສາອັງເກົາຫຼີ (Korean Language)",
    4 => "ສາຂາ ວິທະຍາສາດຄອມພິວເຕີ (Computer Science)"
];


$course_text = [];
$course_query = mysqli_query($conn, "SELECT * FROM courses");

while($c = mysqli_fetch_assoc($course_query)){
    $course_text[$c['course_id']] = $c['course_name'];
}

$time_text = [];
$time_query = mysqli_query($conn, "
    SELECT program_options.time_id, study_time.time_name
    FROM program_options
    LEFT JOIN study_time
    ON program_options.time_id = study_time.time_id
");

while($t = mysqli_fetch_assoc($time_query)){
    $time_text[$t['time_id']] = $t['time_name'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="icon" href="images/favicon.png" type="image/gif" />

    <title>Exam Registration System</title>

    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <style>
    body {
        font-family: "Phetsarath OT", "Times New Roman";
        background: #f4f6f9;
        margin: 40px;
    }

    h2 {
        margin-bottom: 20px;
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
        white-space: nowrap;
    }

    tr:hover {
        background: #f1f1f1;
    }

    .logout {
        text-align: right;
        margin-bottom: 20px;
    }

    .logout a {
        background: #e74c3c;
        color: white;
        padding: 8px 15px;
        text-decoration: none;
        border-radius: 5px;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
    }

    .edit {
        color: #2980b9;
        text-decoration: none;
    }

    .delete {
        color: #e74c3c;
        text-decoration: none;
    }

    .btn-card {
        background: #27ae60;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
    }

    .btn-red {
        background: #e74c3c;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-excel {
        background: #217346;
        color: white;
        padding: 6px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-family: "Phetsarath OT", sans-serif;
        text-decoration: none;
        display: inline-block;
        margin-top: 8px;
        font-weight: bold;
    }

    .btn-excel:hover {
        background: #154c2e;
    }
    </style>
</head>

<body>
<?php include_once __DIR__ . '/site_header.php'; ?>

    <form method="GET" class="mb-3">
        <input type="hidden" name="degree" value="<?= $_GET['degree'] ?? '' ?>">

        <select id="program_id" name="program_id" class="form-select" onchange="this.form.submit()">

            <option value="">-- ເລືອກ --</option>

            <?php
    $program_sql = "
    SELECT 
        p.program_id,
        m.major_name,
        c.course_name,
        t.time_name
        
        
        
        
        

    FROM program_options p

    LEFT JOIN majors m 
    ON p.major_id = m.major_id

    LEFT JOIN courses c 
    ON p.course_id = c.course_id

    LEFT JOIN study_time t 
    ON p.time_id = t.time_id
    ";

    $data = mysqli_query($conn, $program_sql);

    while ($row = mysqli_fetch_assoc($data)) {

        $text = $row['major_name'] . ' - ' . 
                $row['course_name'] . ' - ' . 
                $row['time_name'];

        $selected = (
            ($_GET['program_id'] ?? '') == $row['program_id']
        ) ? 'selected' : '';
    ?>

            <option value="<?= $row['program_id']; ?>" <?= $selected; ?>>
                <?= $text; ?>
            </option>

            <?php } ?>

        </select>


        <br><br>

        <!-- ຮອບສອບ -->
        <select name="round" class="form-select" onchange="this.form.submit()">
            <option value="">-- ເລືອກຮອບສອບ --</option>
            <?php
    $rounds = mysqli_query($conn, "SELECT * FROM exam_rounds");
    while($r = mysqli_fetch_assoc($rounds)){
    ?>
            <option value="<?= $r['id'] ?>" <?= (($_GET['round'] ?? '') == $r['id']) ? 'selected' : '' ?>>
                <?= $r['round_name'] ?>
            </option>
            <?php } ?>
        </select>
        <br>
        <a href="students.php?degree=<?= $_GET['degree'] ?? '' ?>" class="btn btn-secondary mt-2"
            style="background:#7f8c8d; color:white; padding:6px 15px; text-decoration:none; border-radius:4px; display:inline-block;">
            Reset
        </a>

        <button type="button" onclick="exportTableToExcel()" class="btn-excel">
            📊 ດາວໂຫຼດ Excel
        </button>
    </form>

    <h2 style="text-align:center; margin-top:20px;">ລາຍຊື່ຜູ້ສະໝັກສອບ</h2>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <table id="studentTable">
        <tr>
            <th>No.</th>
            <th>name_lao</th>
            <th>surname_lao</th>
            <th>name_eng</th>
            <th>surname_eng</th>
            <th>gender</th>
            <th>dob</th>
            <th>nationality</th>
            <th>religion</th>
            <th>Birth_village</th>
            <th>Birth_District</th>
            <th>Birth_Province</th>
            <th>Current_Address</th>
            <th>Current_district</th>
            <th>Current_Province</th>
            <th>Tel</th>
            <th>Highschool</th>
            <th>Parent_Name</th>
            <th>Parent_Tel</th>
            <th>Program</th>
            <th>photo</th>
            <th>ID_Card</th>
            <th>Highschool_Certificate</th>
            <th>Payment_Slip</th>
            <th>Created_At</th>
            <th>Status</th>
            <th>Exam Date & Time</th>
            <th>reg_Number</th>
            <th>Manage</th>
        </tr>
        <?php 
        $i = 1;
        while($row = mysqli_fetch_assoc($result)){ 
            
            ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row['name_lao']; ?></td>
            <td><?php echo $row['surname_lao']; ?></td>
            <td><?php echo $row['name_eng']; ?></td>
            <td><?php echo $row['surname_eng']; ?></td>
            <td><?php echo $row['gender']; ?></td>
            <td>
                <?php 
                if(!empty($row['dob'])){
                    echo date("d/m/Y", strtotime($row['dob']));
                } else {
                    echo "-";
                }
                ?>
            </td>
            <td><?php echo $row['nationality']; ?></td>
            <td><?php echo $row['religion']; ?></td>
            <td><?php echo $row['birth_village']; ?></td>
            <td><?php echo $row['birth_district']; ?></td>
            <td><?php echo $row['birth_province']; ?></td>
            <td><?php echo $row['current_address']; ?></td>
            <td><?php echo $row['current_district']; ?></td>
            <td><?php echo $row['current_province']; ?></td>
            <td><?php echo $row['tel']; ?></td>
            <td><?php echo $row['highschool']; ?></td>
            <td><?php echo $row['parent_name']; ?></td>
            <td><?php echo $row['parent_tel']; ?></td>
            <td style="min-width:350px; text-align:left;">

                <div style="
        background:#e8f1ff;
        padding:8px;
        border-radius:6px;
        margin-bottom:8px;
    ">
                    <b style="color:#0d6efd;">ຫຼັກສູດຫຼັກ</b><br>

                    <b>ສາຂາ:</b>
                    <?= !empty($row['major_name']) ? $row['major_name'] : '-' ?><br>

                    <b>ຫຼັກສູດ:</b>
                    <?= !empty($row['course_name']) ? $row['course_name'] : '-' ?><br>

                    <b>ເວລາ:</b>
                    <?= !empty($row['time_name']) ? $row['time_name'] : '-' ?>
                </div>

                <div style="
        background:#fff4e5;
        padding:8px;
        border-radius:6px;
    ">
                    <b style="color:#e67e22;">ຫຼັກສູດສຳຮອງ</b><br>

                    <b>ສາຂາ:</b>
                    <?= !empty($row['backup_major']) ? $row['backup_major'] : '-' ?><br>

                    <b>ຫຼັກສູດ:</b>
                    <?= !empty($row['backup_course']) ? $row['backup_course'] : '-' ?><br>

                    <b>ເວລາ:</b>
                    <?= !empty($row['backup_time']) ? $row['backup_time'] : '-' ?>
                </div>

            </td>

            <td>
                <?php if(!empty($row['photo'])){ ?>
                <a href="uploads/<?= rawurlencode(basename($row['photo'])) ?>" target="_blank">
                    View photo
                </a>
                <?php } else { echo "-"; } ?>
            </td>

            <td>
                <?php if(!empty($row['id_card'])): ?>
                <a href="uploads/<?= htmlspecialchars($row['id_card']) ?>" target="_blank">
                    📄 View id_card
                </a>
                <?php else: ?>
                -
                <?php endif; ?>

            </td>

            <td>
                <?php if(!empty($row['highschool_certificate'])){ ?>
                <a href="uploads/<?= rawurlencode(basename($row['highschool_certificate'])) ?>" target="_blank">
                    📄 View highschool certificate
                </a>
                <?php } else { echo "-"; } ?>
            </td>

            <td>
                <?php if(!empty($row['payment_slip'])){ ?>
                <a href="uploads/<?= rawurlencode(basename($row['payment_slip'])) ?>" target="_blank">
                    📄 View payment_slip
                </a>
                <?php } else { echo "-"; } ?>
            </td>

            <td><?php echo $row['created_at']; ?></td>
            <td>
                <?php if($row['status'] == 'approved'): ?>
                <span style="color:green; font-weight:bold;">✔ approved</span>
                <?php else: ?>
                <span style="color:red;">⏳ pending</span>
                <?php endif; ?>
            </td>

            <td>
                <?php 
if(!empty($row['exam_date_main'])){
    echo $row['exam_date_main'] . " " . $row['exam_time_main'];
} else {
    echo "ຍັງບໍ່ໄດ້ກຳນົດ";
}
?>
            </td>

            <td>
                <?php
if(!empty($row['reg_number'])){
    echo $row['reg_number'];
} else {
    echo '<span style="color:red;">NO REG</span>';
}
?>
            </td>

            <td>

                <a href="edit_student.php?id=<?= $row['id']; ?>">Edit</a> |
                <a href="delete_student.php?id=<?= $row['id']; ?>">Delete</a> |
                <a href="exam_card.php?id=<?= $row['id']; ?>" target="_blank" class="btn-card">
                    🪪 TEST CARD
                </a>
                <br><br>

                <?php if($row['status'] != 'approved'): ?>
                <a href="approve.php?id=<?= $row['id']; ?>" style="color:green; font-weight:bold;">
                    ✔ Approve
                </a>
                <?php else: ?>
                <span style="color:green; font-weight:bold;">
                    ✔ APPROVED
                </span>
                <br>
                <a href="receipt.php?id=<?= $row['id']; ?>" target="_blank">
                    🧾 View receipt
                </a>
                <?php endif; ?>

                <?php if($filter == 'pending'): ?>
                <br><br>
                <form method="POST" action="set_exam.php" style="display:flex; gap:5px; justify-content:center;">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <select name="exam_round_id" required>
                        <?php
            $rounds = mysqli_query($conn,"SELECT * FROM exam_rounds WHERE status='open'");
            while($r = mysqli_fetch_assoc($rounds)){
               echo "<option value='{$r['id']}'>
    {$r['round_name']} - {$r['exam_date_main']} {$r['exam_time_main']}
</option>";
            }
            ?>
                    </select>
                    <button type="submit" class="btn-red">📅 ກຳນົດ</button>
                </form>
                <?php endif; ?>


            </td>
        </tr>
        <?php } ?>
    </table>

    <script>
    function exportTableToExcel() {
        var table = document.getElementById("studentTable");
        if (!table) {
            alert("ບໍ່ພົບຕາຕະລາງຂໍ້ມູນ");
            return;
        }

        var rows = table.querySelectorAll("tr");
        var data = [];

        var headers = [];
        var headerCells = rows[0].querySelectorAll("th");
        for (var h = 0; h < headerCells.length - 1; h++) {
            headers.push(headerCells[h].innerText.trim());
        }
        data.push(headers);

        var baseUrl = window.location.origin + window.location.pathname.replace(/\/[^\/]*$/, '/');

        for (var i = 1; i < rows.length; i++) {
            var rowData = [];
            var cells = rows[i].querySelectorAll("td");


            for (var j = 0; j < cells.length - 1; j++) {
                var cell = cells[j];
                var anchor = cell.querySelector("a");

                if (anchor) {
                    var href = anchor.getAttribute("href") || "";

                    if (href.includes("uploads/")) {
                        var fullUrl = baseUrl + href;
                        var fileName = href.replace("uploads/", "");


                        rowData.push({
                            v: fileName,
                            f: 'HYPERLINK("' + fullUrl + '", "' + fileName + '")'
                        });
                    } else {
                        rowData.push(cell.innerText.trim());
                    }
                } else {

                    rowData.push(cell.innerText.trim());
                }
            }
            data.push(rowData);
        }

        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.aoa_to_sheet(data);


        var colWidths = [];
        var range = XLSX.utils.decode_range(ws['!ref']);

        for (var R = range.s.r; R <= range.e.r; ++R) {
            for (var C = range.s.c; C <= range.e.c; ++C) {
                var cell_address = XLSX.utils.encode_cell({
                    r: R,
                    c: C
                });
                if (!ws[cell_address]) continue;

                var cell = ws[cell_address];

                if (C === 15 || C === 18) {
                    cell.t = 's';
                    if (cell.v) cell.v = String(cell.v);
                }

                var valStr = cell.v ? String(cell.v) : "";
                var cellLength = valStr.length;


                if (/[ຊ-ໝກ-ຮະ-ູັ-ົ໌]/.test(valStr)) {
                    cellLength = cellLength * 1.5;
                }

                if (!colWidths[C] || cellLength > colWidths[C]) {
                    colWidths[C] = cellLength;
                }
            }
        }

        ws['!cols'] = colWidths.map(w => ({
            wch: Math.max(w + 3, 12)
        }));

        XLSX.utils.book_append_sheet(wb, ws, "ລາຍຊື່ຜູ້ສະໝັກສອບ");
        XLSX.writeFile(wb, "ລາຍຊື່ຜູ້ສະໝັກສອບ.xlsx");
    }
    </script>

</body>

</html>