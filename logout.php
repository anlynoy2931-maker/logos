<?php
session_start();

// ລ້າງຕົວປ່ຽນ session ທັງໝົດ
session_unset();

// ທຳລາຍ session
session_destroy();

// Redirect ກັບໄປໜ້າຫຼັກ index.php
header("Location: index.php");
exit();
?>