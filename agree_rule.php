<?php
session_start();

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $_SESSION['agree_rule_'.$id] = true;
}

echo 'OK';