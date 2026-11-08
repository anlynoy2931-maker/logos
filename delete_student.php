<?php
session_start();
include __DIR__ . '/db.php';

if(!isset($_SESSION['admin'])){
    header("Location: admin_system.php");
    exit();
}

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM students WHERE id=$id");

header("Location: students.php");