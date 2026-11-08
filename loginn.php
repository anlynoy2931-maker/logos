<?php
session_start();
require_once __DIR__ . '/app_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = is_string($_POST['username'] ?? null) ? $_POST['username'] : '';
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';

    // ກວດສອບ Username & Password ຈາກ Database ຫຼື ເຊັກຕາມຕົວຢ່າງ
    if (site_admin_authenticate($username, $password)) {
        
        // ເມື່ອ Login ຜ່ານ ໃຫ້ສ້າງ Session ໂຕນີ້
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username']  = $username;

        header("Location: index.php");
        exit();
    } else {
        $error = site_admin_is_configured()
            ? "Username ຫຼື Password ບໍ່ຖືກຕ້ອງ!"
            : "Admin login is not configured. Set admin credentials in config.local.php.";
    }
}
?>