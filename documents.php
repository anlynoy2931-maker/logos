<?php
include __DIR__ . '/db.php';


$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($student_id <= 0){
    die("No student ID provided");
}


$student_check = $conn->query("SELECT id, name_eng, surname_eng FROM students WHERE id=$student_id");
if($student_check->num_rows === 0){
    die("Student not found");
}
$student = $student_check->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Upload Documents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
<?php include_once __DIR__ . '/site_header.php'; ?>

    <h3>ອັບໂຫລດເອກກະສານ</h3>
    <p>Student: <?= htmlspecialchars($student['name_eng'] . ' ' . $student['surname_eng']) ?></p>
    <hr>

    <form action="save_documents.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="student_id" value="<?= $student_id ?>">

        <label>ຮູບຖ່າຍຕິດບັດ 3x4</label>
        <input type="file" name="photo" class="form-control" required><br>

        <label>ບັດປະຈຳຕົວ</label>
        <input type="file" name="id_card" class="form-control" required><br>

        <label>ສຳເນົາໃບປະກາດມ.ປາຍ</label>
        <input type="file" name="highschool_certificate" class="form-control" required><br>

        <label>ໃບຄະແນນມ.ປາຍ</label>
        <input type="file" name="certificate" class="form-control" required><br>

        <button type="submit" class="btn btn-primary w-100 mt-3">ຕໍ່ໄປ</button>
    </form>

    <script>
    document.querySelector("form").addEventListener("submit", function(e) {

        let photo = document.querySelector('input[name="photo"]').files.length;
        let id_card = document.querySelector('input[name="id_card"]').files.length;
        let highschool = document.querySelector('input[name="highschool_certificate"]').files.length;
        let certificate = document.querySelector('input[name="certificate"]').files.length;

        if (photo === 0 || id_card === 0 || highschool === 0 || certificate === 0) {
            alert("ກະລຸນາອັບໂຫລດເອກກະສານໃຫ້ຄົບ");
            e.preventDefault();
        }
    });
    </script>

</body>

</html>