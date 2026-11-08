<!DOCTYPE html>
<html lang="lo">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Success</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    <style>
    body {
        font-family: 'Noto Sans Lao', sans-serif;
        background: linear-gradient(135deg, #f0f4ff, #f9f9f9);
        text-align: center;
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .box {
        background: #fff;
        width: 520px;
        padding: 45px 35px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.5s ease-in-out;
    }

    .success {
        color: #1a7f37;
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .wait {
        color: #555;
        font-size: 18px;
        line-height: 1.6;
        margin-top: 10px;
    }

    .btn {
        display: inline-block;
        margin-top: 30px;
        padding: 12px 28px;
        background: #2563eb;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-size: 16px;
        transition: 0.3s;
    }

    .btn:hover {
        background: #1e4fd6;
        transform: translateY(-2px);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>

<body>
<?php include_once __DIR__ . '/site_header.php'; ?>

    <div class="box">

        <div class="success">
            ການລົງທະບຽນສຳເລັດແລ້ວ<br>
            Registration completed
        </div>

        <div class="wait">
            ກະລຸນາລໍຖ້າພະນັກງານກວດສອບບັດສອບເສັງ<br>
            Please wait for staff to verify the exam card.
        </div>

        <a href="index.html" class="btn">Back to home</a>

    </div>

</body>

</html>