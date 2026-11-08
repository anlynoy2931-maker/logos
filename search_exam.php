<?php
include "db.php";

/** @var mysqli $conn */

$error = "";

if(isset($_GET['name']) && isset($_GET['surname'])){

    $name = trim($_GET['name']);
    $surname = trim($_GET['surname']);

    $sql = "SELECT * FROM students
            WHERE (name_lao LIKE '%$name%' OR name_eng LIKE '%$name%')
            AND (surname_lao LIKE '%$surname%' OR surname_eng LIKE '%$surname%')";

    $result = mysqli_query($conn, $sql);

    if(!$result){
        die("SQL Error: " . mysqli_error($conn));
    }

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        header("Location: exam_card.php?id=".$row['id']);
        exit();

    }else{
        $error = "ບໍ່ພົບຂໍ້ມູນ";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Search Exam Card</title>

    <style>
    body {
        font-family: "Phetsarath OT", "Times New Roman";
        background: #f3f3f3;
        text-align: center;
        margin-top: 80px;
    }

    .box {
        background: white;
        width: 400px;
        margin: auto;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px #ccc;
    }

    input {
        width: 90%;
        padding: 10px;
        margin-top: 10px;
    }

    button {
        padding: 10px 20px;
        margin-top: 10px;
    }

    .error {
        color: red;
        margin-top: 15px;
        font-weight: bold;
    }
    </style>

</head>

<body>
<?php include_once __DIR__ . '/site_header.php'; ?>

    <div class="box">

        <h2>ຄົ້ນຫາບັດສອບ</h2>

        <form method="GET" action="search_exam.php">

            <input type="text" name="name" placeholder="ຊື່" required>

            <input type="text" name="surname" placeholder="ນາມສະກຸນ" required>

            <button type="submit">Search</button>

        </form>

        <?php if(!empty($error)){ ?>
        <div class="error"><?= $error ?></div>
        <?php } ?>

    </div>

</body>

</html>