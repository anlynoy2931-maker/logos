<?php
require_once __DIR__ . '/site_content_localization.php';
// ກວດສອບວ່າ session ຖືກ start ຫანიຍັງ
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_lang = site_supported_language($_GET['lang'] ?? 'en');
$is_course_page = basename($_SERVER['PHP_SELF'] ?? '') === 'course.php';
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($current_lang, ENT_QUOTES, 'UTF-8'); ?>">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="images/favicon.png" type="image/gif" />
  <meta name="keywords" content="logos institute of foreign language Laos" />
  <meta name="description" content="Major in English studies, English, Foreign language, Chinese, Korean, Computer science" />
  <meta name="author" content="Panyasak HEUANGVONGSA" />

  <title><?php echo $is_course_page && $current_lang === 'la' ? 'ຫຼັກສູດ | ສະຖາບັນໂລໂກສ' : 'Logos Institute of Foreign Language'; ?></title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  
  <!-- Owl Carousel CDN CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
  
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />

  <style>
    /* Sticky Navbar Styling */
    .header_section {
      background-color: #ffffff;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 9999;
    }

    /* ເຊື່ອງປຸ່ມລູກສອນ Owl Carousel ທຸກອັນ */
    .owl-nav, 
    .owl-prev, 
    .owl-next {
        display: none !important;
    }

    .custom_nav-container .navbar-nav .nav-item {
      position: relative;
    }

    .custom_nav-container .navbar-nav .nav-item .nav-link {
      color: #333333;
      font-weight: 500;
      padding: 10px 15px !important;
      transition: color 0.3s;
    }
    
    .custom_nav-container .navbar-nav .nav-item:hover .nav-link,
    .custom_nav-container .navbar-nav .nav-item.active .nav-link {
      color: #002b49;
    }

    /* Animated Underline Effect */
    .custom_nav-container .navbar-nav .nav-item .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 3px;
      bottom: 2px;
      left: 50%;
      background-color: #002b49;
      transition: all 0.3s ease-in-out;
      transform: translateX(-50%);
      border-radius: 2px;
    }

    .custom_nav-container .navbar-nav .nav-item:hover .nav-link::after,
    .custom_nav-container .navbar-nav .nav-item.active .nav-link::after {
      width: 80%;
    }

    /* Hero Section */
    .slider_section {
      position: relative;
      background: linear-gradient(to right, rgba(11, 37, 25, 0.95) 0%, rgba(11, 37, 25, 0.85) 35%, rgba(11, 37, 25, 0.3) 65%, rgba(11, 37, 25, 0) 90%), url('images/logosss.jpg');
      background-size: cover;
      background-position: center;
      padding: 160px 0 100px 0;
      color: #ffffff;
      min-height: 90vh;
      display: flex;
      align-items: center;
    }
    .slider_section .detail-box {
      text-align: center !important;
      max-width: 900px;
    }
    .slider_section .detail-box h1 {
      font-size: 3.2rem;
      font-weight: 700;
      line-height: 1.25;
      margin-bottom: 20px;
      color: #ffffff;
    }
    .slider_section .detail-box p {
      font-size: 1.1rem;
      margin-bottom: 30px;
      color: #e0e0e0;
    }
    .slider_section .btn-box {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
      justify-content: flex-start;
    }
    .slider_section .btn-box a {
      padding: 12px 25px;
      border-radius: 30px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
      text-align: center;
    }
    .slider_section .btn-box .btn1 {
      background-color: #dc3545;
      color: #ffffff;
    }
    .slider_section .btn-box .btn2 {
      background-color: #ffffff;
      color: #002b49;
    }

    /* Custom Card Fix */
    .course_section .card-item {
      background: #ffffff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      margin-bottom: 20px;
      transition: transform 0.3s ease;
    }
    .course_section .card-item:hover {
      transform: translateY(-5px);
    }
    .course_section .card-item .img-box {
      width: 100%;
      height: 200px;
      overflow: hidden;
    }
    .course_section .card-item .img-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .course_section .card-item .detail-box {
      padding: 20px;
      text-align: center;
    }
    .course_section .card-item .detail-box h4 {
      font-size: 1.1rem;
      font-weight: 600;
      color: #002b49;
      margin-bottom: 10px;
    }
    .course_section .card-item .detail-box p {
      font-size: 0.9rem;
      color: #666;
      margin-bottom: 15px;
    }
    .course_section .card-item .detail-box a {
      display: inline-block;
      padding: 8px 20px;
      background-color: #002b49;
      color: #ffffff;
      border-radius: 20px;
      text-decoration: none;
      font-size: 0.9rem;
    }

    /* Popup Modal CSS */
    .popup-modal {
      display: none;
      position: fixed;
      z-index: 99999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      align-items: center;
      justify-content: center;
    }
    .popup-content {
      position: relative;
      background-color: #ffffff;
      padding: 15px;
      border-radius: 12px;
      max-width: 450px;
      width: 90%;
      text-align: center;
      box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.4);
    }
    .popup-close {
      position: absolute;
      top: -12px;
      right: -12px;
      background: #dc3545;
      color: #ffffff;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      line-height: 28px;
      font-size: 22px;
      font-weight: bold;
      cursor: pointer;
      border: 2px solid #ffffff;
    }
    .popup-poster-img {
      width: 100%;
      max-height: 65vh;
      object-fit: contain;
      border-radius: 8px;
    }
    .course_owl-carousel:not(.owl-loaded) {
      display: grid !important;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 20px;
    }
    .course_owl-carousel:not(.owl-loaded) > .item {
      width: 100%;
    }
    .navbar-collapse.show {
      display: block;
    }
    @media (max-width: 991.98px) {
      .course_owl-carousel:not(.owl-loaded) {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }
    @media (max-width: 575.98px) {
      .course_owl-carousel:not(.owl-loaded) {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body class="site-content-page<?php echo $is_course_page ? ' course-page' : ''; ?>">

  <div class="hero_area">
    <?php include_once __DIR__ . '/site_header.php'; ?>