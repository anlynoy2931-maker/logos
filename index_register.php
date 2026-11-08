<?php
include 'db.php';
?>
<!DOCTYPE html>

<html lang="th">

</html>

<head>
    <meta charset="UTF-8">
    <title> </title>

    <style>
    body {
        font-family: "Phetsarath OT", "Times New Roman";
        background: #f3f3f3;
    }



    .banner {
        width: 80%;
        margin: auto;
        margin-top: 50px;
        background: linear-gradient(90deg, #7d125f, #1b0d5b);
        color: white;
        padding: 30px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* ===== QR CENTER ===== */
    .qr-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* กล่อง QR */
    .qr-box {
        background: rgba(255, 255, 255, 0.95);
        padding: 25px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(32, 136, 188, 0.4);
    }

    /* รูป QR */
    .qr-box img {
        width: 220px;
        border: 6px solid #fff;
        border-radius: 10px;
        margin: 10px 0;
    }

    /* ข้อความ */
    .qr-box h3 {
        margin-bottom: 10px;
        color: #000;
    }

    .qr-box p {
        color: #333;
    }

    .logo img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        image-rendering: crisp-edges;
    }

    /* ปุ่ม Admin */
    .admin-btn {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
    }

    .admin-btn a {
        background: #010a03;
        color: white;
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: bold;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        transition: 0.3s;
    }

    /* hover effect */
    .admin-btn a:hover {
        background: #0c0503;
        transform: scale(1.05);
    }

    /* ข้อความ */

    .text {
        flex: 1;
        margin-left: 20px;
    }

    .text h2 {
        margin: 0;
    }

    .text p {
        margin: 5px 0;
    }

    /* ปุ่มสมัคร */

    .btn {
        background: #ffc107;
        color: black;
        padding: 12px 25px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: bold;
        animation: bounce 1.5s infinite;
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }


    .stats {
        width: 80%;
        margin: auto;
        margin-top: 30px;
        display: flex;
        gap: 20px;
    }

    .box {
        flex: 1;
        padding: 20px;
        color: white;
        border-radius: 10px;
        text-align: center;
    }


    .bg-slider {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        background-size: cover;
        background-position: center;

        z-index: -1;
        transition: background-image 1s ease-in-out;
    }

    /* ทำให้พื้นหลังมืดนิดนึง อ่านง่าย */
    .bg-slider::after {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.3);
    }
    </style>

</head>

<body>
<?php include_once __DIR__ . '/site_header.php'; ?>
    <div class="bg-slider"></div>
    <div class="banner">

        <div class="logo">
            <img src="images/logos.png">
        </div>

        <div class="text">
            <h2> ສະໝັກສອບເສັງອອນລາຍ</h2>
            <p>ສະຖາບັນ ພາສາຕ່າງປະເທດ ໂລໂກສ</p>
            <p>Logos institute of Foreign</p>
        </div>


        <a href="register.php" class="btn">ສະໝັກສອບເສັງ</a>

    </div>

    <div style="position:absolute; top:20px; right:20px;">
        <div class="admin-btn">
            <a href="/admission/exam_registration/admin.php">Admin</a>
        </div>
    </div>

    <div class="qr-container">
        <div class="qr-box">
            <h3>ສແກຣນ ບັດເຂົ້າຫ້ອງສອບເສັງ</h3>
            <img src="images/qr_exam.png">
            <p>Scan QR to check your exam card</p>
        </div>
    </div>

    <div class="stats">

        <script>
        const images = [
            "images/About 1.jpg",
            "images/Chinese1.jpg",
            "images/englishS.jpg",
            "images/CS1.jpg",
            "images/KoreanS1.jpg"
        ];

        let index = 0;
        const bg = document.querySelector(".bg-slider");

        function changeBackground() {
            bg.style.backgroundImage = `url('${images[index]}')`;
            index = (index + 1) % images.length;
        }

        setInterval(changeBackground, 5000);
        changeBackground();
        </script>

</body>

</html>