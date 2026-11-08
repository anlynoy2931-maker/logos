<?php
session_start();
require_once __DIR__ . '/app_config.php';

if(isset($_POST['username']) && isset($_POST['password'])){

    $username = is_string($_POST['username']) ? $_POST['username'] : '';
    $password = is_string($_POST['password']) ? $_POST['password'] : '';

    if(site_admin_authenticate($username, $password)){
        $_SESSION['admin'] = $username;
        $_SESSION['admin_logged_in'] = true;
        
        header("Location: index.php");
        exit();
    }else{
        $error = site_admin_is_configured()
            ? "Username or Password incorrect"
            : "Admin login is not configured. Set admin credentials in config.local.php.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="icon" href="images/favicon.png" type="image/gif" />
    <title>Admin Login</title>

    <style>
    body {
        font-family: Arial;
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
    }

    .login-box {
        background: white;
        padding: 40px;
        width: 320px;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        text-align: center;
        position: relative;
    }

    h2 {
        margin-bottom: 20px;
    }

    input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    .login-button {
        width: 100%;
        padding: 10px;
        background: #4facfe;
        border: none;
        color: white;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }

    .login-button:hover {
        background: #2a7de1;
    }

    /* ปุ่ม X */
    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 35px;
        height: 35px;
        background: red;
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close-btn:hover {
        background: darkred;
    }

    .error {
        color: red;
        margin-bottom: 15px;
        font-size: 14px;
    }
    </style>

</head>

<body>
<?php include_once __DIR__ . '/site_header.php'; ?>

    <div class="login-box">

        <!-- ປ່ຽນປຸ່ມ X ໃຫ້ກັບໄປໜ້າ index.php -->
        <button onclick="window.location='index.php'" class="close-btn">
            ✖
        </button>

        <h2>Admin Login</h2>

        <?php if(isset($error)){ ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
        <?php } ?>

        <form method="post">

            <input type="text" name="username" placeholder="Username" required>

            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" class="login-button">
                Login
            </button>

        </form>

    </div>

</body>

</html>