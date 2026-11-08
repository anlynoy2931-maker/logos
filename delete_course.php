<?php
session_start();

// ກວດສອບວ່າເປັນ Admin ເຂົ້າຮູບແບບລັອກອິນແລ້ວບໍ
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// ເຊື່ອມຕໍ່ Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "exam_registration";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // ດຶງຮູບເພື່ອລົບໄຟລ໌ອອກຈາກໂຟນເດີ (ຖ້າຕ້ອງການ)
    $stmt_img = $conn->prepare("SELECT image FROM website_courses WHERE id = ?");
    $stmt_img->bind_param("i", $id);
    $stmt_img->execute();
    $res = $stmt_img->get_result();
    if ($row = $res->fetch_assoc()) {
        if (file_exists($row['image']) && strpos($row['image'], 'images/') !== false) {
            @unlink($row['image']); // ລົບໄຟລ໌ຮູບພາບ
        }
    }

    // ລົບຂໍ້ມູນອອກຈາກ Database
    $stmt = $conn->prepare("DELETE FROM website_courses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// ເມື່ອລົບເສັດແລ້ວ ໃຫ້ກັບໄປໜ້າ index.php
header("Location: index.php");
exit();
?>