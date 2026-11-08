<?php
include "db.php";

function cleanPhone($phone){
    return preg_replace('/[^0-9]/', '', $phone);
}

$name = trim($_GET['name'] ?? '');
$surname = trim($_GET['surname'] ?? '');
$phone = trim($_GET['tel'] ?? '');

$student = null;

if($name != '' || $surname != '' || $phone != ''){

    $nameSearch = strtolower($name);
    $surnameSearch = strtolower($surname);
    $phoneSearch = cleanPhone($phone);

    $sql = "
        SELECT *
        FROM students
        WHERE 1=1
    ";

    if($name != ''){
        $sql .= "
        AND (
            name_lao LIKE '%$name%'
            OR LOWER(name_eng) LIKE '%$nameSearch%'
        )
        ";
    }

    if($surname != ''){
        $sql .= "
        AND (
            surname_lao LIKE '%$surname%'
            OR LOWER(surname_eng) LIKE '%$surnameSearch%'
        )
        ";
    }

    if($phone != ''){
        $sql .= "
        AND REPLACE(
                REPLACE(
                    REPLACE(
                        REPLACE(tel,' ',''),'-',''),
                    '+',''),
                '(', '')
        LIKE '%$phoneSearch%'
        ";
    }

    $sql .= " LIMIT 1";

    $result = mysqli_query($conn, $sql);

    if(!$result){
        die("SQL Error: " . mysqli_error($conn));
    }

    if(mysqli_num_rows($result) > 0){
        $student = mysqli_fetch_assoc($result);
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Search Exam Card</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body{
    font-family:"Phetsarath OT", sans-serif;
    background:linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)),
    url("images/Language and computer science fusion.png") no-repeat center;
    background-size:cover;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.box{
    background:#fff;
    width:420px;
    padding:35px;
    border-radius:20px;
    text-align:center;
    position:relative;
}

.logo{
    width:120px;
    border-radius:50%;
    margin-bottom:10px;
}

input,button{
    width:100%;
    padding:12px;
    margin-top:10px;
    border-radius:10px;
    border:1px solid #ccc;
}

button{
    background:linear-gradient(90deg,#c5265b,#1e3c72);
    color:#fff;
    border:none;
    cursor:pointer;
    font-size:16px;
}

.close-btn{
    position:absolute;
    top:15px;
    right:15px;
    background:#dc3545;
    color:#fff;
    border:none;
    width:40px;
    height:40px;
    border-radius:50%;
    font-size:18px;
    cursor:pointer;
}
</style>
</head>

<body>
<?php include_once __DIR__ . '/site_header.php'; ?>

<div class="box">

<button class="close-btn" onclick="window.location='index.html'">✖</button>

<img src="images/logos.png" class="logo">

<h2>
ຄົ້ນຫາບັດສອບ<br>
Find your exam card
</h2>

<form method="GET">

<input 
type="text" 
name="name" 
placeholder="ຊື່ / Name"
value="<?=htmlspecialchars($name)?>"
>

<input 
type="text" 
name="surname" 
placeholder="ນາມສະກຸນ / Surname"
value="<?=htmlspecialchars($surname)?>"
>

<input 
type="text" 
name="tel" 
placeholder="ເບີໂທ / Phone"
value="<?=htmlspecialchars($phone)?>"
>

<button type="submit">
🔍 ຄົ້ນຫາ Search
</button>

</form>
</div>

<?php if(isset($student)): ?>

<script>

let status = "<?= strtolower($student['status'] ?? '') ?>";
let studentId = "<?= $student['id'] ?? '' ?>";

let qrBlock = `
<div style="margin-top:15px;text-align:center;">

    <img 
    src="whatsapp.jpg"
    style="width:160px;border-radius:10px;"
    >

    <div style="margin-top:8px;font-size:14px;color:#555;">
        ເບີຕິດຕໍ່ການສອບຖາມ
    </div>

</div>
`;

if(status === 'approved'){

    Swal.fire({
        icon:'success',
        title:'ອະນຸມັດແລ້ວ Approved',

        html:`
            🎉 ທ່ານໄດ້ຮັບການອະນຸມັດຮຽບຮ້ອຍແລ້ວ<br>

            <small>
            Your application has been approved.
            </small>

            ${qrBlock}
        `,

        confirmButtonText:'ຕົກລົງ OK'

    }).then(()=>{

        window.location='exam_card.php?id='+studentId;

    });

}else{

    Swal.fire({
        icon:'warning',
        title:'ຍັງບໍ່ອະນຸມັດ',

        html:`
            ⏳ ກະລຸນາລໍຖ້າການກວດສອບ

            <div style="color:gray">
            Please wait for verification
            </div>

            ${qrBlock}
        `,

        confirmButtonText:'OK'
    });

}

</script>

<?php endif; ?>

<?php if(isset($error)): ?>

<script>

Swal.fire({
    icon:'error',
    title:'ບໍ່ພົບຂໍ້ມູນ',

    html:`

        ❌ ຂໍ້ມູນບໍ່ຖືກຕ້ອງ

        <div style="color:gray;font-size:14px">
            No data found
        </div>

        <div style="margin-top:15px;text-align:center;">

            <img 
            src="whatsapp.jpg"
            style="width:160px;border-radius:10px;"
            >

            <div style="margin-top:8px;font-size:14px;color:#555;">
                ເບີຕິດຕໍ່ການສອບຖາມ
            </div>

        </div>

    `,

    confirmButtonText:'OK'

});

</script>

<?php endif; ?>

</body>
</html>