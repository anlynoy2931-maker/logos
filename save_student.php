<?php 
require_once 'db.php'; 
 
/* ================= DEBUG ================= */ 
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL); 
 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
 
/* ================= CHECK METHOD ================= */ 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
    die("Invalid request"); 
} 

/* ================= UPLOAD FILES ================= */

$upload_dir = __DIR__ . '/uploads/';

if (!is_dir($upload_dir)) {
    if (!mkdir($upload_dir, 0755, true)) {
        die("❌ Cannot create upload directory");
    }
}

if (!is_writable($upload_dir)) {
    die("❌ Upload directory is not writable");
}


/* ================= UPLOAD FUNCTION ================= */

function uploadFile($field, $dir)
{
    if (!isset($_FILES[$field])) {
        return '';
    }

    $file = $_FILES[$field];

    /* Upload error */
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die(
            "❌ UPLOAD ERROR<br>" .
            "Field: " . htmlspecialchars($field) . "<br>" .
            "Error: " . $file['error']
        );
    }

    $tmp = $file['tmp_name'];

    /* Check temporary file */
    if (!file_exists($tmp)) {
        die("❌ Temporary file does not exist: " . $field);
    }

    if (!is_readable($tmp)) {
        die("❌ Temporary file is not readable: " . $field);
    }

    if (!is_uploaded_file($tmp)) {
        die("❌ Not a valid uploaded file: " . $field);
    }


    /* Get extension */
    $extension = strtolower(
        pathinfo($file['name'], PATHINFO_EXTENSION)
    );

    if ($extension === '') {
        $extension = 'jpg';
    }


    /* Generate filename */
    $filename = uniqid('student_', true) . '.' . $extension;

    $target = $dir . $filename;


    /* ================= DEBUG ================= */

    echo "<pre>";

    echo "FIELD: " . $field . "\n";
    echo "ORIGINAL NAME: " . $file['name'] . "\n";
    echo "TYPE: " . $file['type'] . "\n";
    echo "SIZE: " . $file['size'] . "\n";
    echo "TMP: " . $tmp . "\n";
    echo "TARGET: " . $target . "\n";
    echo "DIR EXISTS: " . (is_dir($dir) ? 'YES' : 'NO') . "\n";
    echo "DIR WRITABLE: " . (is_writable($dir) ? 'YES' : 'NO') . "\n";

    echo "</pre>";


    /* ================= MOVE ================= */

    if (!move_uploaded_file($tmp, $target)) {

        echo "<h3 style='color:red;'>❌ MOVE FAILED</h3>";

        echo "<pre>";

        echo "FIELD: " . $field . "\n";
        echo "TMP: " . $tmp . "\n";
        echo "TARGET: " . $target . "\n";

        $error = error_get_last();

        echo "\nPHP ERROR:\n";

        if ($error) {
            print_r($error);
        } else {
            echo "Unknown";
        }

        echo "</pre>";

        die();
    }


    /* ================= VERIFY ================= */

    if (!file_exists($target)) {
        die("❌ File does not exist after move: " . $field);
    }

    if (filesize($target) <= 0) {
        unlink($target);
        die("❌ Uploaded file is empty: " . $field);
    }


    echo "<h3 style='color:green;'>✅ UPLOAD SUCCESS: $field</h3>";

    return $filename;
}


/* ================= SAVE ALL FILES ================= */

$photo = uploadFile("photo", $upload_dir);

$id_card = uploadFile("id_card", $upload_dir);

$certificate = uploadFile("highschool_certificate",$upload_dir);

$payment_slip = uploadFile("payment_slip",$upload_dir);



/* ================= REQUIRED CHECK ================= */ 
$required = ['name_lao','surname_lao','tel','program_id','dob']; 
 
foreach ($required as $r) { 
    if (empty($_POST[$r])) { 
        die("❌ Missing field: $r"); 
    } 
} 
 
/* ================= DOB ================= */ 
$date = DateTime::createFromFormat('d/m/Y', $_POST['dob']); 
if (!$date) { 
    die("❌ Invalid DOB format (d/m/Y)"); 
} 
$dob = $date->format('Y-m-d'); 
 
/* ================= INPUT ================= */ 
$name_lao = $_POST['name_lao']; 
$surname_lao = $_POST['surname_lao']; 
$name_eng = $_POST['name_eng'] ?? ''; 
$surname_eng = $_POST['surname_eng'] ?? ''; 
$gender = $_POST['gender'] ?? ''; 
 
$nationality = $_POST['nationality'] ?? ''; 
$religion = $_POST['religion'] ?? ''; 
 
$birth_village = $_POST['birth_village'] ?? ''; 
$birth_district = $_POST['birth_district'] ?? ''; 
$birth_province = $_POST['birth_province'] ?? ''; 
 
$current_address = $_POST['current_address'] ?? ''; 
$current_district = $_POST['current_district'] ?? ''; 
$current_province = $_POST['current_province'] ?? ''; 
 
$tel = trim($_POST['tel']); 
 
$highschool = $_POST['highschool'] ?? ''; 
 
$parent_name = $_POST['parent_name'] ?? ''; 
$parent_tel = $_POST['parent_tel'] ?? ''; 
 
$program_id = (int)$_POST['program_id']; 
$backup_program_id = (int)($_POST['backup_program_id'] ?? 0); 
 
/* ================= PROGRAM ================= */ 
$stmt = $conn->prepare("SELECT major_id, course_id, time_id FROM program_options WHERE program_id=?"); 
$stmt->bind_param("i", $program_id); 
$stmt->execute(); 
$program = $stmt->get_result()->fetch_assoc(); 
 
if (!$program) { 
    die("❌ Program not found"); 
} 
 
$major_id = $program['major_id']; 
$course_id = $program['course_id']; 
$time_id = $program['time_id']; 
 
/* ================= BACKUP ================= */ 
$backup_major_id = null; 
$backup_course_id = null; 
$backup_time_id = null; 
 
if ($backup_program_id > 0) { 
    $stmt = $conn->prepare("SELECT major_id, course_id, time_id FROM program_options WHERE program_id=?"); 
    $stmt->bind_param("i", $backup_program_id); 
    $stmt->execute(); 
    $backup = $stmt->get_result()->fetch_assoc(); 
 
    if ($backup) { 
        $backup_major_id = $backup['major_id']; 
        $backup_course_id = $backup['course_id']; 
        $backup_time_id = $backup['time_id']; 
    } 
} 
 
/* ================= COURSE TYPE ================= */ 
$stmt = $conn->prepare("SELECT course_type FROM courses WHERE course_id=?"); 
$stmt->bind_param("i", $course_id); 
$stmt->execute(); 
$course = $stmt->get_result()->fetch_assoc(); 
 
$degree_type = $course['course_type'] ?? ''; 
if (!$degree_type) { 
    die("❌ course_type missing"); 
} 




/* ================= INSERT ================= */ 
$stmt = $conn->prepare(" 
INSERT INTO students ( 
    name_lao, surname_lao, name_eng, surname_eng, gender, 
    dob, nationality, religion, 
    birth_village, birth_district, birth_province, 
    current_address, current_district, current_province, 
    tel, highschool, 
    parent_name, parent_tel, 
    major_id, course_id, time_id, 
    photo, id_card, highschool_certificate, payment_slip, 
    created_at, status, 
    reg_number, exam_date, exam_time, 
    issue_date, payment_status, 
    exam_round_id, degree_type, exam_round, 
    approved_at, 
    backup_major_id, backup_course_id, backup_time_id, 
    program_id, backup_program_id 
) VALUES ( 
    ?,?,?,?,?,?, 
    ?,?,?, 
    ?,?,?,?, 
    ?,?,?,?, 
    ?,?,?,?, 
    ?,?,?,?, 
    NOW(),'pending', 
    '',NULL,NULL, 
    NULL,'unpaid', 
    0,?,0, 
    NULL, 
    ?,?,?,?, 
    ? 
) 
"); 
 
/* ================= FIXED bind_param (100% MATCH 31 VARIABLES) ================= */ 
$stmt->bind_param( 
    "ssssssssssssssssssiiisssssiiiii", 
    $name_lao, 
    $surname_lao, 
    $name_eng, 
    $surname_eng, 
    $gender, 
    $dob, 
    $nationality, 
    $religion, 
    $birth_village, 
    $birth_district, 
    $birth_province, 
    $current_address, 
    $current_district, 
    $current_province, 
    $tel, 
    $highschool, 
    $parent_name, 
    $parent_tel, 
    $major_id, 
    $course_id, 
    $time_id, 
    $photo, 
    $id_card, 
    $certificate, 
    $payment_slip, 
    $degree_type, 
    $backup_major_id, 
    $backup_course_id, 
    $backup_time_id, 
    $program_id, 
    $backup_program_id 
); 
 
/* ================= EXECUTE ================= */ 
if (!$stmt->execute()) { 
    die("❌ INSERT ERROR: " . $stmt->error); 
} 
 
$student_id = $conn->insert_id; 
 
if ($student_id <= 0) { 
    die("❌ INSERT FAILED - NO ID"); 
} 
 
/* ================= SUCCESS ================= */ 
header("Location: payment.php?id=" . $student_id); 
exit;