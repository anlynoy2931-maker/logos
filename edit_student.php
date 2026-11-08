<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include __DIR__ . '/db.php';

if(!isset($_SESSION['admin'])){
    header("Location: admin_system.php");
    exit();
}

// ================= SECURITY FUNCTION =================
function clean($conn,$data){
    return mysqli_real_escape_string(
        $conn,
        trim($data)
    );
}

// ================= SAFE FILE NAME =================
function safeFileName($file){

    return time().'_'.preg_replace(
        "/[^A-Za-z0-9\._-]/",
        "_",
        basename($file)
    );
}

// ================= GET ID =================
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ================= PROGRAMS =================
$programs = mysqli_query($conn, "
    SELECT 
        po.program_id,
        po.major_id,
        po.course_id,
        po.time_id,

        m.major_name,
        c.course_name,
        t.time_name

    FROM program_options po

    JOIN majors m 
    ON po.major_id = m.major_id

    JOIN courses c 
    ON po.course_id = c.course_id

    JOIN study_time t 
    ON po.time_id = t.time_id

    ORDER BY po.program_id ASC
");

if(!$programs){
    die(mysqli_error($conn));
}

// ================= GET STUDENT =================
$result = mysqli_query($conn,"SELECT * FROM students WHERE id='$id'");

if(!$result){
    die(mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

if(!$row){
    die("Student not found");
}

// ================= DATE FORMAT =================
$dob_value = !empty($row['dob'])
    ? date('Y-m-d', strtotime($row['dob']))
    : '';

$exam_date_value = !empty($row['exam_date'])
    ? date('Y-m-d', strtotime($row['exam_date']))
    : '';

$issue_date_value = !empty($row['issue_date'])
    ? date('Y-m-d', strtotime($row['issue_date']))
    : '';

// ================= UPDATE =================
if(isset($_POST['update'])){

    $name_lao = clean($conn,$_POST['name_lao']);
    $surname_lao = clean($conn,$_POST['surname_lao']);

    $name_eng = clean($conn,$_POST['name_eng']);
    $surname_eng = clean($conn,$_POST['surname_eng']);

    $gender = clean($conn,$_POST['gender']);
    $dob = clean($conn,$_POST['dob']);

    $nationality = clean($conn,$_POST['nationality']);
    $religion = clean($conn,$_POST['religion']);

    $birth_village = clean($conn,$_POST['birth_village']);
    $birth_district = clean($conn,$_POST['birth_district']);
    $birth_province = clean($conn,$_POST['birth_province']);

    $current_address = clean($conn,$_POST['current_address']);
    $current_district = clean($conn,$_POST['current_district']);
    $current_province = clean($conn,$_POST['current_province']);

    $tel = clean($conn,$_POST['tel']);

    $highschool = clean($conn,$_POST['highschool']);

    $parent_name = clean($conn,$_POST['parent_name']);
    $parent_tel = clean($conn,$_POST['parent_tel']);

    // ================= PROGRAM =================
    $program_id = intval($_POST['program_id']);

    $backup_program_id =
isset($_POST['backup_program_id']) &&
$_POST['backup_program_id'] !== ''
? intval($_POST['backup_program_id'])
: $row['backup_program_id'];

    // ================= MAIN PROGRAM =================
    $getProgram = mysqli_query($conn,"
        SELECT * 
        FROM program_options
        WHERE program_id='$program_id'
    ");

    if(!$getProgram){
        die(mysqli_error($conn));
    }

    $p = mysqli_fetch_assoc($getProgram);

    $major_id = $p['major_id'];
    $course_id = $p['course_id'];
    $time_id = $p['time_id'];

    // ================= BACKUP PROGRAM =================
   $backup_major_id = $row['backup_major_id'];
$backup_course_id = $row['backup_course_id'];
$backup_time_id = $row['backup_time_id'];

    if($backup_program_id > 0){

        $getBackup = mysqli_query($conn,"
            SELECT *
            FROM program_options
            WHERE program_id='$backup_program_id'
        ");

        if($getBackup){

            $bp = mysqli_fetch_assoc($getBackup);

            if($bp){

                $backup_major_id = $bp['major_id'];
                $backup_course_id = $bp['course_id'];
                $backup_time_id = $bp['time_id'];
            }
        }
    }

    // ================= EXAM =================
    $exam_date = !empty($_POST['exam_date'])
    ? clean($conn,$_POST['exam_date'])
    : NULL;

    $exam_time = !empty($_POST['exam_time'])
    ? clean($conn,$_POST['exam_time'])
    : NULL;

    $issue_date = !empty($_POST['issue_date'])
    ? clean($conn,$_POST['issue_date'])
    : NULL;

    // ================= PHOTO =================
    if(!empty($_FILES['photo']['name'])){

        $photo = safeFileName($_FILES['photo']['name']);

        move_uploaded_file(
            $_FILES['photo']['tmp_name'],
            'uploads/'.$photo
        );

    }else{

        $photo = $row['photo'];
    }

    // ================= ID CARD =================
    if(!empty($_FILES['id_card']['name'])){

        $id_card = safeFileName($_FILES['id_card']['name']);

        move_uploaded_file(
            $_FILES['id_card']['tmp_name'],
            'uploads/'.$id_card
        );

    }else{

        $id_card = $row['id_card'];
    }

    // ================= CERTIFICATE =================
    if(!empty($_FILES['highschool_certificate']['name'])){

        $highschool_certificate =
        safeFileName($_FILES['highschool_certificate']['name']);

        move_uploaded_file(
            $_FILES['highschool_certificate']['tmp_name'],
            'uploads/'.$highschool_certificate
        );

    }else{

        $highschool_certificate =
        $row['highschool_certificate'];
    }

    // ================= PAYMENT =================
    if(!empty($_FILES['payment_slip']['name'])){

        $payment_slip =
        safeFileName($_FILES['payment_slip']['name']);

        move_uploaded_file(
            $_FILES['payment_slip']['tmp_name'],
            'uploads/'.$payment_slip
        );

    }else{

        $payment_slip = $row['payment_slip'];
    }


    // ================= UPDATE QUERY =================
    $sql = "
        UPDATE students SET

        name_lao='$name_lao',
        surname_lao='$surname_lao',

        name_eng='$name_eng',
        surname_eng='$surname_eng',

        gender='$gender',
        dob='$dob',

        nationality='$nationality',
        religion='$religion',

        birth_village='$birth_village',
        birth_district='$birth_district',
        birth_province='$birth_province',

        current_address='$current_address',
        current_district='$current_district',
        current_province='$current_province',

        tel='$tel',

        highschool='$highschool',

        parent_name='$parent_name',
        parent_tel='$parent_tel',

        program_id='$program_id',

        major_id='$major_id',
        course_id='$course_id',
        time_id='$time_id',

        backup_program_id='$backup_program_id',
       backup_major_id=" . ($backup_major_id !== NULL ? $backup_major_id : "NULL") . ",
backup_course_id=" . ($backup_course_id !== NULL ? $backup_course_id : "NULL") . ",
backup_time_id=" . ($backup_time_id !== NULL ? $backup_time_id : "NULL") . ",

        exam_date=" . ($exam_date ? "'$exam_date'" : "NULL") . ",
        exam_time=" . ($exam_time ? "'$exam_time'" : "NULL") . ",
        issue_date=" . ($issue_date ? "'$issue_date'" : "NULL") . ",

        photo='".mysqli_real_escape_string($conn,$photo)."',
        id_card='".mysqli_real_escape_string($conn,$id_card)."',
        highschool_certificate='".mysqli_real_escape_string($conn,$highschool_certificate)."',
       payment_slip='".mysqli_real_escape_string($conn,$payment_slip)."'

        WHERE id='$id'
    ";

    $update = mysqli_query($conn,$sql);

    if(!$update){
        die(mysqli_error($conn));
    }

    header("Location: students.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<title>Edit Student</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#eef1f5;
    font-family: Arial, Helvetica, sans-serif;
}

.container{
    max-width:1100px;
    margin-top:40px;
    margin-bottom:40px;
}

.card{
    border:none;
    border-radius:20px;
    background:#fff;
    box-shadow:0 5px 25px rgba(0,0,0,0.08);
    padding:35px;
}

h3{
    font-weight:700;
    color:#222;
}

h4{
    font-size:24px;
    font-weight:700;
    color:#222;
}

.form-control,
.form-select{
    height:48px;
    border-radius:10px;
    border:1px solid #dcdfe6;
}

.btn-primary,
.btn-secondary{
    border-radius:10px;
    height:48px;
    font-weight:600;
}

.preview-img{
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:10px;
    border:1px solid #ddd;
    margin-top:10px;
}

</style>

</head>

<body>
<?php include_once __DIR__ . '/site_header.php'; ?>

<div class="container">

<div class="card">

<h3 class="text-center mb-5">
✏️ Edit Student Information
</h3>

<form method="post" enctype="multipart/form-data">

<div class="row g-3">

<div class="col-md-6">
<label>Name (Lao)</label>
<input class="form-control" type="text" name="name_lao"
value="<?php echo $row['name_lao']; ?>">
</div>

<div class="col-md-6">
<label>Surname (Lao)</label>
<input class="form-control" type="text" name="surname_lao"
value="<?php echo $row['surname_lao']; ?>">
</div>

<div class="col-md-6">
<label>Name (English)</label>
<input class="form-control" type="text" name="name_eng"
value="<?php echo $row['name_eng']; ?>">
</div>

<div class="col-md-6">
<label>Surname (English)</label>
<input class="form-control" type="text" name="surname_eng"
value="<?php echo $row['surname_eng']; ?>">
</div>

<div class="col-md-4">
<label>Gender</label>
<input class="form-control" type="text" name="gender"
value="<?php echo $row['gender']; ?>">
</div>

<div class="col-md-4">
<label>DOB</label>
<input class="form-control" type="date" name="dob"
value="<?php echo $dob_value; ?>">
</div>

<div class="col-md-4">
<label>Nationality</label>
<input class="form-control" type="text" name="nationality"
value="<?php echo $row['nationality']; ?>">
</div>

<div class="col-md-12">
<label>Religion</label>
<input class="form-control" type="text" name="religion"
value="<?php echo $row['religion']; ?>">
</div>

<hr class="my-4">

<h4 class="mb-3">Address Info</h4>

<div class="col-md-6">
<label>Birth Village</label>
<input class="form-control" type="text" name="birth_village"
value="<?php echo $row['birth_village']; ?>">
</div>

<div class="col-md-6">
<label>Birth District</label>
<input class="form-control" type="text" name="birth_district"
value="<?php echo $row['birth_district']; ?>">
</div>

<div class="col-md-6">
<label>Birth Province</label>
<input class="form-control" type="text" name="birth_province"
value="<?php echo $row['birth_province']; ?>">
</div>

<div class="col-md-6">
<label>Current Address</label>
<input class="form-control" type="text" name="current_address"
value="<?php echo $row['current_address']; ?>">
</div>

<div class="col-md-6">
<label>Current District</label>
<input class="form-control" type="text" name="current_district"
value="<?php echo $row['current_district']; ?>">
</div>

<div class="col-md-6">
<label>Current Province</label>
<input class="form-control" type="text" name="current_province"
value="<?php echo $row['current_province']; ?>">
</div>

<div class="col-md-6">
<label>Phone</label>
<input class="form-control" type="text" name="tel"
value="<?php echo $row['tel']; ?>">
</div>

<hr class="my-4">

<h4 class="mb-3">Education</h4>

<div class="col-md-6">
<label>High School</label>
<input class="form-control" type="text" name="highschool"
value="<?php echo $row['highschool']; ?>">
</div>

<div class="col-md-6">
<label>Parent Name</label>
<input class="form-control" type="text" name="parent_name"
value="<?php echo $row['parent_name']; ?>">
</div>

<div class="col-md-6">
<label>Parent Phone</label>
<input class="form-control" type="text" name="parent_tel"
value="<?php echo $row['parent_tel']; ?>">
</div>

<div class="col-md-6">
<label>Main Program</label>

<select class="form-select" name="program_id">

<?php mysqli_data_seek($programs,0); ?>

<?php while($p = mysqli_fetch_assoc($programs)){ ?>

<option value="<?php echo $p['program_id']; ?>"

<?php
if($p['program_id'] == $row['program_id']){
    echo "selected";
}
?>

>

<?php echo $p['major_name']; ?>
-
<?php echo $p['course_name']; ?>
-
<?php echo $p['time_name']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-6">

<label>Backup Program</label>

<?php
$backupPrograms = mysqli_query($conn,"
    SELECT 
        po.program_id,
        m.major_name,
        c.course_name,
        t.time_name
    FROM program_options po
    JOIN majors m ON po.major_id = m.major_id
    JOIN courses c ON po.course_id = c.course_id
    JOIN study_time t ON po.time_id = t.time_id
    ORDER BY po.program_id ASC
");
?>

<select class="form-select" name="backup_program_id">

<option value="0">
-- Select Backup Program --
</option>

<?php while($bp = mysqli_fetch_assoc($backupPrograms)){ ?>

<option value="<?php echo $bp['program_id']; ?>"

<?php
if(
isset($row['backup_program_id']) &&
$bp['program_id'] == $row['backup_program_id']
){
    echo "selected";
}
?>

>

<?php echo $bp['major_name']; ?>
-
<?php echo $bp['course_name']; ?>
-
<?php echo $bp['time_name']; ?>

</option>

<?php } ?>

</select>

</div>

<hr class="my-4">

<h4 class="mb-3">Exam Settings</h4>

<div class="col-md-4">
<label>Exam Date</label>
<input class="form-control" type="date" name="exam_date"
value="<?php echo $exam_date_value; ?>">
</div>

<div class="col-md-4">
<label>Exam Time</label>
<input class="form-control" type="time" name="exam_time"
value="<?php echo $row['exam_time']; ?>">
</div>

<div class="col-md-4">
<label>Issue Date</label>
<input class="form-control" type="date" name="issue_date"
value="<?php echo $issue_date_value; ?>">
</div>

<hr class="my-4">

<h4 class="mb-3">Upload Files</h4>

<div class="col-md-6">

<label>Photo</label>

<input type="file"
class="form-control"
name="photo">

<?php if(!empty($row['photo'])){ ?>

<img
src="uploads/<?php echo $row['photo']; ?>"
class="preview-img">

<?php } ?>

</div>

<div class="col-md-6">

<label>ID Card</label>

<input type="file"
class="form-control"
name="id_card">

<?php if(!empty($row['id_card'])){ ?>

<div class="mt-2">

<a target="_blank"
class="btn btn-dark btn-sm"
href="uploads/<?php echo $row['id_card']; ?>">

View File

</a>

</div>

<?php } ?>

</div>

<div class="col-md-6">

<label>Highschool Certificate</label>

<input type="file"
class="form-control"
name="highschool_certificate">

<?php if(!empty($row['highschool_certificate'])){ ?>

<div class="mt-2">

<a target="_blank"
class="btn btn-dark btn-sm"
href="uploads/<?php echo $row['highschool_certificate']; ?>">

View File

</a>

</div>

<?php } ?>

</div>

<div class="col-md-6">

<label>Payment Slip</label>

<input type="file"
class="form-control"
name="payment_slip">

<?php if(!empty($row['payment_slip'])){ ?>

<div class="mt-2">

<a target="_blank"
class="btn btn-dark btn-sm"
href="uploads/<?php echo $row['payment_slip']; ?>">

View File

</a>

</div>

<?php } ?>

</div>

<div class="col-12 text-center mt-4">

<button class="btn btn-primary px-5" name="update">
💾 Update
</button>

<a href="students.php"
class="btn btn-secondary px-4">
Back
</a>

</div>

</div>

</form>

</div>

</div>

</body>
</html>