<!DOCTYPE html>
<html>

<head>
  <!-- Google Fonts: Phetsarath OT -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Phetsarath:wght@400;700&display=swap" rel="stylesheet">

  <style>
    /* ຕັ້ງຄ່າຟອນ Phetsarath OT ໃຫ້ທຸກອົງປະກອບ */
    body, h1, h2, h3, h4, h5, h6, p, a, span, button, input, div, iframe {
      font-family: 'Phetsarath', 'Phetsarath OT', 'Noto Sans Lao', sans-serif !important;
    }

    /* ຫ້າມ Highlight ຂໍ້ຄວາມ */
    body, iframe {
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    /* ປ້ອງກັນ Owl Carousel ສະແດງຜົນຜິດພາດ */
    .about-owl-carousel img {
      width: 100%;
      height: 400px;
      object-fit: cover;
    }

    /* ຊ່ອນ dots ທັງໝົດຂອງ Owl Carousel */
    .owl-dots {
      display: none !important;
    }

    /* CSS Animation ສຳລັບປຸ່ມ WhatsApp ເຕັ້ນ */
    @keyframes whatsapp-bounce {
      0%, 100% {
        transform: translateY(0) scale(1);
      }
      50% {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 8px 18px rgba(37, 211, 102, 0.45);
      }
    }

    .whatsapp-btn-bounce {
      background-color: #25D366;
      color: white !important;
      padding: 8px 18px;
      border-radius: 8px;
      text-decoration: none !important;
      font-weight: bold;
      display: inline-block;
      font-size: 14px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
      animation: whatsapp-bounce 1.4s infinite ease-in-out;
    }

    .whatsapp-btn-bounce:hover {
      background-color: #1ebc57;
      transform: scale(1.05);
    }
  </style>

  <script>
    // ຫ້າມຄລິກຂວາ (Disable Right Click)
    document.addEventListener('contextmenu', event => event.preventDefault());
  </script>    

  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <link rel="icon" href="images/favicon.png" type="image/gif" />
  <meta name="keywords" content="About Logos institute of foreign language Laos" />
  <meta name="description" content="About Logos institute" />
  <meta name="author" content="Panyasak HEUANGVONGSA" />

  <title>Logos institute</title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet" />
  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  
  <!-- owl carousel CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body class="sub_page">
<?php include_once __DIR__ . '/site_header.php'; ?>

  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="index.html">
            <span>
              <img src="images/logo.png" height="60px">
            </span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="index.html">Home </a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="about.html"> About <span class="sr-only">(current)</span> </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="course.html">Courses</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="teacher.html">Professor</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contact.html">Contact Us</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="Regulations.html">Regulations</a>
                </li>
                </ul>
            </div>
            <div class="quote_btn-container">
              <a href="">
                <span>Login</span>
                <i class="fa fa-user" aria-hidden="true"></i>
              </a>
              <form class="form-inline">
                <button class="btn my-2 my-sm-0 nav_search-btn" type="submit">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </button>
              </form>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>

  <!-- about section -->
  <section class="about_section layout_padding">
    <div class="container">
      <div class="row align-items-center">
        
        <!-- Slider / Carousel -->
        <div class="col-md-6 mb-4 mb-md-0">
          <div class="about-owl-carousel owl-carousel owl-theme shadow-sm rounded overflow-hidden">
            <div class="item">
              <img src="festival/IMG_5064.jpg" alt="LOGOS Festival 1">
            </div>
            <div class="item">
              <img src="festival/IMG_5213.jpg" alt="LOGOS Festival 2">
            </div>
            <div class="item">
              <img src="festival/IMG_5217.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_5237.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_5251.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_5453.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_5640.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_5666.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_5812.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_5812.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_5864.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_5888.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_5978.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_6018.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_6475.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_6505.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_6577.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_6656.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_6740.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_6831.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_6850.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_7176.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_7179.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_7212.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_7705.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_7710.jpg" alt="LOGOS Festival 3">
            </div>
            <div class="item">
              <img src="festival/IMG_7822.jpg" alt="LOGOS Festival 3">
            </div>
          </div>
        </div>
          
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>LOGOS Festival 2026</h2>
            </div>
            <p>
                ບຸນມະໂຫລານໂລໂກສແມ່ນຈັດຂຶ້ນເພື່ອເປັນພິທີສະເຫຼີມສະຫຼອງວັນຄົບຮອບສະຖານການສຶກສາໂລໂກສ ເລີ່ມຈັດຕັ້ງປະຕິບັດຢ່າງເປັນຮູບປະທຳຕັ້ງແຕ່ປີ 2016 ເປັນຕົ້ນມາ, ເຊິ່ງຈະຈັດຂຶ້ນທຸກໆປີໃນລະຫວ່າງເດືອນມີນາ ຫາ ເດືອນເມສາ, ໃນປີ 2026 ເປັນຄັ້ງທີ 07, ເພື່ອເຮັດໃຫ້ການສະເຫຼີມສະຫຼອງວັນຄົບຮອບສະຖານການສຶກສາໂລໂກສມີຄວາມໝາຍ ແລະ ຄວາມສຳຄັນ ພ້ອມຍັງສອດຄ່ອງກັບ 03 ລັກສະນະ ແລະ 05 ຫຼັກມຸມຂອງການສຶກສາລາວອີກດ້ວຍ...
            </p>
          </div>
        </div>
      </div>

      <!-- ສ່ວນສະແດງການແຂ່ງຂັນ -->
      <div class="container my-5">
        <div class="heading_container mb-4 text-center">
          <h2>ກົດລະບຽບການແຂ່ງຂັນ</h2>
        </div>

        <div class="row justify-content-center">
          <!-- ຂໍ້ 1: English Speaking Contest -->
          <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card h-100 border-0 shadow-sm rounded-lg overflow-hidden" data-toggle="modal" data-target="#docModal1" style="cursor: pointer;">
              <img src="festival/speaking.jpg" class="card-img-top" alt="English Speaking Contest" style="height: 260px; object-fit: cover; width: 100%;">
              <div class="card-body bg-light text-center p-3">
                <h6 class="card-title font-weight-bold mb-1">1. English Speaking</h6>
                <p class="card-text text-muted small mb-0">ການແຂ່ງຂັນເວົ້າພາສາອັງກິດ</p>
              </div>
            </div>
          </div>

          <!-- ຂໍ້ 2: Chinese Speaking Contest -->
          <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card h-100 border-0 shadow-sm rounded-lg overflow-hidden" data-toggle="modal" data-target="#docModal2" style="cursor: pointer;">
              <img src="festival/IMG_6018.jpg" class="card-img-top" alt="Chinese Speaking Contest" style="height: 260px; object-fit: cover; width: 100%;">
              <div class="card-body bg-light text-center p-3">
                <h6 class="card-title font-weight-bold mb-1">2. Chinese Speaking</h6>
                <p class="card-text text-muted small mb-0">ການແຂ່ງຂັນເວົ້າພາສາຈີນ</p>
              </div>
            </div>
          </div>

          <!-- ຂໍ້ 3: Korean Speaking Contest -->
          <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card h-100 border-0 shadow-sm rounded-lg overflow-hidden" data-toggle="modal" data-target="#docModal3" style="cursor: pointer;">
              <img src="festival/IMG_6174.jpg" class="card-img-top" alt="Korean Speaking Contest" style="height: 260px; object-fit: cover; width: 100%;">
              <div class="card-body bg-light text-center p-3">
                <h6 class="card-title font-weight-bold mb-1">3. Korean Speaking</h6>
                <p class="card-text text-muted small mb-0">ການແຂ່ງຂັນເວົ້າພາສາເກົາຫຼີ</p>
              </div>
            </div>
          </div>

          <!-- ຂໍ້ 4: Talent Contest -->
          <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card h-100 border-0 shadow-sm rounded-lg overflow-hidden" data-toggle="modal" data-target="#docModal4" style="cursor: pointer;">
              <img src="festival/IMG_5317.jpg" class="card-img-top" alt="Talent Contest" style="height: 260px; object-fit: cover; width: 100%;">
              <div class="card-body bg-light text-center p-3">
                <h6 class="card-title font-weight-bold mb-1">4. Talent Contest</h6>
                <p class="card-text text-muted small mb-0">ການແຂ່ງຂັນພອນສະຫວັນ</p>
              </div>
            </div>
          </div>

          <!-- ຂໍ້ 5: Booth Contest -->
          <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card h-100 border-0 shadow-sm rounded-lg overflow-hidden" data-toggle="modal" data-target="#docModal5" style="cursor: pointer;">
              <img src="festival/IMG_7822.jpg" class="card-img-top" alt="Booth Contest" style="height: 260px; object-fit: cover; width: 100%;">
              <div class="card-body bg-light text-center p-3">
                <h6 class="card-title font-weight-bold mb-1">5. Booth Contest</h6>
                <p class="card-text text-muted small mb-0">ການແຂ່ງຂັນ Booth</p>
              </div>
            </div>
          </div>

        </div>
      </div>
      
    </div>
  </section>
  <!-- end about section -->

  <!-- info section -->
  <section class="info_section">
    <div class="container">
      <div class="info_top">
        <div class="row">
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="info_detail">
              <a href="index.html">
                <h4>Logos institute</h4>
              </a>
              <div class="social_box">
                <a href="https://www.facebook.com/profile.php?id=100064500650769&locale=th_TH">
                  <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
                <a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <a href=""><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                <a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-4 col-lg-3 mx-auto">
            <h4>Contact us</h4>
            <div class="contact_nav">
              <a href=""><i class="fa fa-map-marker" aria-hidden="true"></i><span>Location: Phonpanao Road Hom 15 Phonphanao, Vientiane, Laos</span></a>
              <a href=""><i class="fa fa-phone" aria-hidden="true"></i><span>Call : +8562092362524</span></a>
              <a href=""><i class="fa fa-envelope" aria-hidden="true"></i><span>Email : logosinstitute.fl.edu@gmail.com</span></a>
            </div>
          </div>
          <div class="col-md-4">
            <div class="info_form">
              <h4>SIGN UP TO OUR NEWSLETTER</h4>
              <form action="">
                <input type="text" placeholder="Enter Your Email" />
                <button type="submit">Subscribe</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end info_section -->

  <!-- footer section -->
  <footer class="footer_section">
    <div class="container">
      <p>&copy; <span id="displayYear"></span> Logos institute</p>
    </div>
  </footer>

  <!-- Modal 1: English Speaking -->
  <div class="modal fade" id="docModal1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">ເອກະສານການແຂ່ງຂັນ English Speaking</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- ປຸ່ມ WhatsApp ແລະ ແຖບ Tab ເລືອກເອກະສານ -->
        <div class="p-2 bg-light border-bottom">
          <ul class="nav nav-pills nav-justified" id="docTab1" role="tablist">
            <li class="nav-item">
              <a class="nav-link active font-weight-bold" data-toggle="tab" href="#rules1" role="tab">1. ກົດລະບຽບ (Contest Rules)</a>
            </li>
            <li class="nav-item">
              <a class="nav-link font-weight-bold" data-toggle="tab" href="#schedule1" role="tab">2. ຕາຕະລາງ (Schedule)</a>
            </li>
          </ul>
          
          <div style="text-align: center; margin-top: 10px;">
            <a href="https://wa.me/8562092362524" target="_blank" class="whatsapp-btn-bounce">
              💬 ສອບຖາມຂໍ້ມູນເພີ່ມເຕີມ (WhatsApp): 020 92362524
            </a>
          </div>
        </div>

        <!-- ສ່ວນສະແດງ PDF -->
        <div class="modal-body p-0" style="height: 75vh;">
          <div class="tab-content h-100" id="docTabContent1">
            <div class="tab-pane fade show active h-100" id="rules1" role="tabpanel">
              <iframe src="festival/Contest Rules 22026.pdf#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="100%" style="border: none;"></iframe>
            </div>
            <div class="tab-pane fade h-100" id="schedule1" role="tabpanel">
              <iframe src="festival/Contest Schedule 2026.pdf#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="100%" style="border: none;"></iframe>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Modal 2: Chinese Speaking -->
  <div class="modal fade" id="docModal2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">ເອກະສານການແຂ່ງຂັນ Chinese Speaking</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="p-2 bg-light border-bottom">
          <ul class="nav nav-pills nav-justified" id="docTab2" role="tablist">
            <li class="nav-item">
              <a class="nav-link active font-weight-bold" data-toggle="tab" href="#rules2" role="tab">1. ກົດລະບຽບ (Contest Rules)</a>
            </li>
            <li class="nav-item">
              <a class="nav-link font-weight-bold" data-toggle="tab" href="#schedule2" role="tab">2. ຕາຕະລາງ (Schedule)</a>
            </li>
          </ul>
          
          <div style="text-align: center; margin-top: 10px;">
            <a href="https://wa.me/8562092362524" target="_blank" class="whatsapp-btn-bounce">
              💬 ສອບຖາມຂໍ້ມູນເພີ່ມເຕີມ (WhatsApp): 020 92362524
            </a>
          </div>
        </div>
        <div class="modal-body p-0" style="height: 75vh;">
          <div class="tab-content h-100" id="docTabContent2">
            <div class="tab-pane fade show active h-100" id="rules2" role="tabpanel">
              <iframe src="festival/Chinese Contest Rules 2026.pdf#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="100%" style="border: none;"></iframe>
            </div>
            <div class="tab-pane fade h-100" id="schedule2" role="tabpanel">
              <iframe src="festival/Chinese Contest Schedule 2026.pdf#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="100%" style="border: none;"></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal 3: Korean Speaking -->
  <div class="modal fade" id="docModal3" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">ເອກະສານການແຂ່ງຂັນ Korean Speaking</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="p-2 bg-light border-bottom">
          <ul class="nav nav-pills nav-justified" id="docTab3" role="tablist">
            <li class="nav-item">
              <a class="nav-link active font-weight-bold" data-toggle="tab" href="#rules3" role="tab">1. ກົດລະບຽບ (Contest Rules)</a>
            </li>
            <li class="nav-item">
              <a class="nav-link font-weight-bold" data-toggle="tab" href="#schedule3" role="tab">2. ຕາຕະລາງ (Schedule)</a>
            </li>
          </ul>

          <div style="text-align: center; margin-top: 10px;">
            <a href="https://wa.me/8562092362524" target="_blank" class="whatsapp-btn-bounce">
              💬 ສອບຖາມຂໍ້ມູນເພີ່ມເຕີມ (WhatsApp): 020 92362524
            </a>
          </div>
        </div>

        <div class="modal-body p-0" style="height: 75vh;">
          <div class="tab-content h-100" id="docTabContent3">
            <div class="tab-pane fade show active h-100" id="rules3" role="tabpanel">
              <iframe src="festival/Korean Contest Rules 2026.pdf#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="100%" style="border: none;"></iframe>
            </div>
            <div class="tab-pane fade h-100" id="schedule3" role="tabpanel">
              <iframe src="festival/Korean Contest Schedule 2026.pdf#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="100%" style="border: none;"></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal 4: Talent Contest -->
  <div class="modal fade" id="docModal4" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">ເອກະສານການແຂ່ງຂັນ Talent Contest</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="p-2 bg-light border-bottom">
          <ul class="nav nav-pills nav-justified" id="docTab4" role="tablist">
            <li class="nav-item">
              <a class="nav-link active font-weight-bold" data-toggle="tab" href="#rules4" role="tab">1. ກົດລະບຽບ (Contest Rules)</a>
            </li>
          </ul>

          <div style="text-align: center; margin-top: 10px;">
            <a href="https://wa.me/8562092362524" target="_blank" class="whatsapp-btn-bounce">
              💬 ສອບຖາມຂໍ້ມູນເພີ່ມເຕີມ (WhatsApp): 020 92362524
            </a>
          </div>
        </div>
        <div class="modal-body p-0" style="height: 75vh;">
          <div class="tab-content h-100" id="docTabContent4">
            <div class="tab-pane fade show active h-100" id="rules4" role="tabpanel">
              <iframe src="festival/Gold Modern Corporate Business Membership Form A4 Document (3).pdf#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="100%" style="border: none;"></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal 5: Booth Contest -->
  <div class="modal fade" id="docModal5" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">ເອກະສານການແຂ່ງຂັນ Booth</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="p-2 bg-light border-bottom">
          <ul class="nav nav-pills nav-justified" id="docTab5" role="tablist">
            <li class="nav-item">
              <a class="nav-link active font-weight-bold" data-toggle="tab" href="#rules5" role="tab">1. ກົດລະບຽບ (Contest Rules)</a>
            </li>
          </ul>

          <div style="text-align: center; margin-top: 10px;">
            <a href="https://wa.me/8562092362524" target="_blank" class="whatsapp-btn-bounce">
              💬 ສອບຖາມຂໍ້ມູນເພີ່ມເຕີມ (WhatsApp): 020 92362524
            </a>
          </div>
        </div>
        <div class="modal-body p-0" style="height: 75vh;">
          <div class="tab-content h-100" id="docTabContent5">
            <div class="tab-pane fade show active h-100" id="rules5" role="tabpanel">
              <iframe src="festival/ເງືອນໄຂໃນການຄັດເລືອກບູ໊ດດີເດັ່ນ (1).pdf#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="100%" style="border: none;"></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="js/custom.js"></script>

  <script>
    
  </script>
  <script>
  $(document).ready(function(){
    $(".about-owl-carousel").owlCarousel({
      items: 1,
      loop: true,
      margin: 10,
      autoplay: true,
      autoplayTimeout: 3000,
      autoplayHoverPause: true,
      nav: false,
      dots: false
    });
  });
  </script>
</body>
</html>