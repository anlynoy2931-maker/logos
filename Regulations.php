<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <link rel="icon" href="images/favicon.png" type="image/gif" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Logos institute</title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet" />

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <!-- owl carousel -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha256-UhQQ4fxEeABh4JrcmAJ1+16id/1dnlOEVCFOxDef9Lw=" crossorigin="anonymous" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

  <!-- CSS ສໍາລັບ Box 4 ຫຼ່ຽມຍາວ -->
  <style>
    .doc-link-box {
      display: block;
      background: #ffffff;
      border: 1px solid #e0e0e0;
      border-left: 5px solid #007bff;
      border-radius: 8px;
      padding: 18px 25px;
      margin-bottom: 15px;
      text-decoration: none !important;
      color: #333333;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    .doc-link-box:hover {
      transform: translateX(6px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);
      border-color: #007bff;
      background-color: #f8f9fa;
    }

    .doc-title-text {
      font-size: 16px;
      font-weight: 600;
      color: #2c3e50;
      margin: 0;
    }

    /* ==========================================
       CSS ສຳລັບ PDF Modal Popup (ປັບບໍ່ໃຫ້ຕຳທຸງຊາດ)
    ========================================== */
    .pdf-modal-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.75);
      z-index: 99999;
      justify-content: center;
      align-items: center;
      padding: 15px;
    }

    .pdf-modal-container {
      background: #ffffff;
      width: 90%;
      max-width: 1000px;
      height: 82vh; /* ປັບຄວາມສູງໃຫ້ຢູ່ເຄິ່ງກາງ ບໍ່ໃຫ້ຕຳຂອບເທິງ-ລຸ່ມ */
      margin-top: 25px; /* ເວັ້ນໄລຍະຫ່າງຈາກ Header/ທຸງຊາດ */
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
      display: flex;
      flex-direction: column;
      overflow: hidden;
      animation: fadeInModal 0.3s ease-out;
    }

    @keyframes fadeInModal {
      from { transform: scale(0.95); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }

    .pdf-modal-header {
      padding: 12px 20px;
      background: #004085;
      color: #ffffff;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .pdf-modal-header h4 {
      margin: 0;
      font-size: 17px;
      font-weight: 600;
      color: #ffffff;
    }

    .pdf-modal-close {
      background: none;
      border: none;
      color: #ffffff;
      font-size: 26px;
      cursor: pointer;
      line-height: 1;
      padding: 0 5px;
      transition: color 0.2s;
    }

    .pdf-modal-close:hover {
      color: #ff4d4d;
    }

    .pdf-modal-body {
      flex: 1;
      width: 100%;
      background: #f4f4f4;
    }

    .pdf-modal-body iframe {
      width: 100%;
      height: 100%;
      border: none;
    }
  </style>

</head>

<body class="sub_page">
<?php include_once __DIR__ . '/site_header.php'; ?>

  <!-- ==========================================
       PDF Modal Popup Structure
  ========================================== -->
  <div id="calendarModal" class="pdf-modal-overlay">
    <div class="pdf-modal-container">
      <div class="pdf-modal-header">
        <h4><i class="fa fa-calendar mr-2"></i> Academic Year Calendar 2026-2027</h4>
        <button type="button" class="pdf-modal-close" id="closeModalBtn">&times;</button>
      </div>
      <div class="pdf-modal-body">
        <!-- 
          toolbar=1 : ເປີດປຸ່ມ Download / Print ໃຫ້ດາວໂຫຼດໄດ້
          navpanes=0 : ຊ່ອນແຖບຮູບນ້ອຍ (Thumbnail/Sidebar) ດ້ານຊ້າຍ
          view=FitH  : ຂະຫຍາຍເນື້ອຫາປະຕິທຶນໃຫ້ເຕັມຄວາມກວ້າງ
        -->
        <iframe src="Documents and Regulations/2026-2027 Calendar Overview PDF.pdf#toolbar=1&navpanes=0&view=FitH" type="application/pdf"></iframe>
      </div>
    </div>
  </div>

  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section ">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
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
                <li class="nav-item">
                  <a class="nav-link" href="about.html"> About </a>
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
                <li class="nav-item active">
                  <a class="nav-link" href="Regulations.html">Documents and Regulations <span class="sr-only">(current)</span></a>
                </li>

                </ul>
            </div>
            <div class="quote_btn-container">
              <a href="">
                <span>
                  Login
                </span>
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

      <div class="heading_container mb-4">
        <h2>Documents and Regulations</h2>
      </div>

      <!-- ສ່ວນສະແດງ Box 4 ຫຼ່ຽມຍາວ (ກົດທີ່ Box ເພື່ອເປີດ PDF) -->
      <div class="row">
        <div class="col-12">

          <!-- Box ທີ 1 -->
          <a href="Documents and Regulations/066 Notice Moral Conduct Scoring 2026.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text">Notice Moral Conduct Scoring 2026.</h5>
          </a>

          <!-- Box ທີ 2 -->
           <a href="Documents and Regulations/066 ແຈ້ງການ ການໃຫ້ຄະແນນດ້ານຄຸນສົມບັດສຶກສາ 2026.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text">ແຈ້ງການ ການໃຫ້ຄະແນນດ້ານຄຸນສົມບັດສຶກສາ 2026</h5>
          </a>
          
           <!-- Box ທີ3 -->
          <a href="Documents and Regulations/067 Logos Institute Student Regulations 2026.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text">Logos Institute Student Regulations 2026</h5>
          </a>
          
           <!-- Box ທີ4 -->
          <a href="Documents and Regulations/067 ກົດລະບຽບນັກສຶກສາ ສພລ ປັບປຸງ 2026.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text">ກົດລະບຽບນັກສຶກສາ ສພລ ປັບປຸງ 2026</h5>
          </a>
           <!-- Box ທີ5 -->
          <a href="Documents and Regulations/446 Regualation on credits Transfer 2026.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text">Regualation on credits Transfer 2026</h5>
          </a>
           <!-- Box ທີ6 -->
          <a href="Documents and Regulations/446 ຂໍ້ກຳນົດວ່າດ້ວຍການໂອນຫນ່ວຍກິດ ປັບປຸງ 2026.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text">ຂໍ້ກຳນົດວ່າດ້ວຍການໂອນຫນ່ວຍກິດ ປັບປຸງ 2026</h5>
          </a>
           <!-- Box ທີ7 -->
          <a href="Documents and Regulations/455 Regulations on the Roles and Rights of Class Advisor 2026.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text">Regulations on the Roles and Rights of Class Advisor 2026</h5>
          </a>
           <!-- Box ທີ8 -->
          <a href="Documents and Regulations/455 ຂໍ້ກຳນົດວ່າດ້ວຍພາລະບົດບາດ ແລະ ຂອບເຂດສິດຄູປະຈຳຫ້ອງ 2026.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text">ຂໍ້ກຳນົດວ່າດ້ວຍພາລະບົດບາດ ແລະ ຂອບເຂດສິດຄູປະຈຳຫ້ອງ 2026</h5>
          </a>
           <!-- Box ທີ9 -->
          <a href="Documents and Regulations/456 Standard and Condition for Class Advisor selection 2026.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text">Standard and Condition for Class Advisor selection 2026</h5>
          </a>
           <!-- Box ທີ10 -->
          <a href="Documents and Regulations/456 ແຈ້ງການເງື່ອນໄຂຄູປະຈຳຫ້ອງ 2026.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text">ແຈ້ງການເງື່ອນໄຂຄູປະຈຳຫ້ອງ</h5>
          </a>
           <!-- Box ທີ11 -->
          <a href="Documents and Regulations/480 Regulation on Graduations 2026.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text">Regulation on Graduations 2026</h5>
          </a>
           <!-- Box ທີ12 -->
          <a href="Documents and Regulations/480 ຂໍ້ກຳນົດວ່າດ້ວຍການສຳເລັດການສຶກສາ ແລະ ການໃຫ້ປະກາສະນີຍະບັດ ປັບປຸງ 2026.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text">ຂໍ້ກຳນົດວ່າດ້ວຍການສຳເລັດການສຶກສາ ແລະ ການໃຫ້ປະກາສະນີຍະບັດ ປັບປຸງ 2026</h5>
          </a>
           <!-- Box ທີ13 -->
          <a href="Documents and Regulations/689 DECISION on Organization and Operation of LIFL 2022.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text">DECISION on Organization and Operation of LIFL 2022</h5>
          </a>
           <!-- Box ທີ14 -->
          <a href="Documents and Regulations/689 ຂໍ້ຕົກລົງວ່າດ້ວຍການຈັດຕັ້ງ ແລະ ເຄື່ອໄຫວ ຂອງ ສພລ 2022.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text">ຂໍ້ຕົກລົງວ່າດ້ວຍການຈັດຕັ້ງ ແລະ ເຄື່ອໄຫວ ຂອງ ສພລ 2022</h5>
          </a>
           <!-- Box ທີ15 -->
          <a href="Documents and Regulations/919 Logos Institute Decision Council Appointment 2023.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text">Logos Institute Decision Council Appointment 2023</h5>
          </a>
           <!-- Box ທີ16 -->
          <a href="Documents and Regulations/919 ຂໍ້ຕົກລົງວ່າດ້ວຍການແຕ່ງຕັ້ງຄະນະກຳມະການສະພາ ສລພ 2023.pdf" target="_blank" class="doc-link-box">
            <h5 class="doc-title-text"> ຂໍ້ຕົກລົງວ່າດ້ວຍການແຕ່ງຕັ້ງຄະນະກຳມະການສະພາ ສລພ 2023</h5>
          </a>

        </div>
      </div>

    </div>
  </section>
  <!-- end about section -->

  <!-- info section -->
  <section class="info_section ">
    <div class="container">
      <div class="info_top ">
        <div class="row ">
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="info_detail">
              <a href="index.html">
                <h4>
                  Logos institute
                </h4>
              </a>
              <p></p>
              <div class="social_box">
                <a href="https://www.facebook.com/profile.php?id=100064500650769&locale=th_TH">
                  <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
                <a href="">
                  <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
                <a href="">
                  <i class="fa fa-linkedin" aria-hidden="true"></i>
                </a>
                <a href="">
                  <i class="fa fa-instagram" aria-hidden="true"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-4 col-lg-3 mx-auto">
            <h4>
              Contact us
            </h4>

            <div class="contact_nav">
              <a href="">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>
                  Location: Phonpanao Road Hom 15 Phonphanao, Vientiane, Laos
                </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>
                  Call : +8562092362524
                </span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>
                  Email : logosinstitute.fl.edu@gmail.com
                </span>
              </a>
            </div>
          </div>
          <div class="col-md-4">
            <div class="info_form">
              <h4>
                SIGN UP TO OUR NEWSLETTER
              </h4>
              <form action="">
                <input type="text" placeholder="Enter Your Email" />
                <button type="submit">
                  Subscribe
                </button>
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
      <p>
        &copy; <span id="displayYear"></span> Logos institute
      </p>
    </div>
  </footer>
  <!-- footer section -->

  <!-- jQuery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- owl carousel -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>

  <script>
    

    // Script ສຳລັບຄວບຄຸມ Popup Modal ປະຕິທຶນ PDF
    $(document).ready(function () {
      // ສະແດງ Popup ເມື່ອເປີດໜ້າເວັບ
      $('#calendarModal').css('display', 'flex');

      // ປິດ Popup ເມື່ອກົດປຸ່ມ X ດ້ານເທິງ
      $('#closeModalBtn').click(function () {
        $('#calendarModal').fadeOut(200);
      });

      // ປິດ Popup ເມື່ອກົດໃສ່ພື້ນຫຼັງສີດຳທາງນອກ Modal
      $('#calendarModal').click(function (e) {
        if ($(e.target).is('#calendarModal')) {
          $('#calendarModal').fadeOut(200);
        }
      });
    });
  </script>

</body>

</html>