<?php
session_start();
require_once __DIR__ . '/app_config.php';

if(isset($_POST['login'])){
    $username = is_string($_POST['username'] ?? null) ? $_POST['username'] : '';
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';

    if(site_admin_authenticate($username, $password)){
        $_SESSION['admin'] = $username;
        header("Location: admin.php");
        exit();
    }else{
        echo site_admin_is_configured()
            ? "Username or Password wrong!"
            : "Admin login is not configured. Set admin credentials in config.local.php.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <!-- IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Icon -->
    <link rel="icon" href="images/favicon.png" type="image/gif" />

    <title>Admin Login</title>
</head>

<body>
<?php include_once __DIR__ . '/site_header.php'; ?>

    <form method="post">
        <h2>Admin</h2>

        Username:<br>
        <input type="text" name="username"><br><br>

        Password:<br>
        <input type="password" name="password"><br><br>

        <button type="submit" name="login">Login</button>
    </form>

</body>

</html>