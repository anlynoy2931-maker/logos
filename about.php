<?php
session_start();
$current_lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';
$current_lang = $current_lang === 'la' ? 'la' : 'en';
$aboutText = [
  'en' => [
    'hero_title' => 'About Our Institute',
    'hero_description' => 'Connecting people, cultures, and possibilities through the power of language and education.',
    'eyebrow' => 'Who We Are',
    'institute_name' => 'Logos Institute of Foreign Language',
    'history_one' => 'Logos Institute was originally established in 2001 as the Logos Academy Center. Initially, it offered continuing education and short-term training programs in English, Korean, and Computer Science.',
    'history_two' => 'In 2014, Logos Academy Center was officially upgraded to Logos College. Subsequently, in 2021, it was elevated to the Logos Institute of Foreign Languages. By 2023, the institution achieved full accreditation as a comprehensive institute, recognized by the Ministry of Education and Sports.',
    'vision_title' => 'Our Vision',
    'vision_text' => 'To develop Logos into a premier institution for foreign languages, while modernizing its educational standards to achieve regional and international excellence.',
    'mission_title' => 'Our Mission',
    'missions' => [
      'To develop students in alignment with the 3 Characteristics and 5 Pillars of Education.',
      'To elevate educational standards and provide exceptional academic services to society.',
      'To produce highly skilled personnel with proficiency in foreign languages to meet labor market demands.',
      'To preserve and promote the national arts and culture, while selectively integrating the progressive and finest global cultures of the modern era.'
    ],
    'map_title' => 'Maps & Contact',
    'contact_title' => 'CONTACT US',
    'location' => 'Location: Phonpanao Road',
    'address' => 'Hom 15 Phonphanao, Vientiane, Laos',
    'phone' => 'Call : +8562092362524',
    'email' => 'Email : logosinstitute.fl.edu@gmail.com',
    'copyright' => 'Logos institute'
  ],
  'la' => [
    'hero_title' => 'ກ່ຽວກັບສະຖາບັນຂອງພວກເຮົາ',
    'hero_description' => 'ເຊື່ອມໂຍງຜູ້ຄົນ, ວັດທະນະທຳ ແລະ ໂອກາດ ຜ່ານພະລັງຂອງພາສາ ແລະ ການສຶກສາ.',
    'eyebrow' => 'ພວກເຮົາແມ່ນໃຜ',
    'institute_name' => 'ສະຖາບັນໂລໂກສ ພາສາຕ່າງປະເທດ',
    'history_one' => 'ສະຖາບັນໂລໂກສໄດ້ຖືກສ້າງຕັ້ງຂຶ້ນໃນເບື້ອງຕົ້ນໃນປີ 2001 ໃນນາມສູນໂລໂກສອາຄາເດມີ. ໃນເບື້ອງຕົ້ນ, ມັນໄດ້ສະເໜີການສຶກສາຕໍ່ເນື່ອງ ແລະ ໂຄງການຝຶກອົບຮົມໄລຍະສັ້ນໃນພາສາອັງກິດ, ພາສາເກົາຫຼີ ແລະ ວິທະຍາສາດຄອມພິວເຕີ.',
    'history_two' => 'ໃນປີ 2014 ສູນໂລໂກສອາຄາເດມີໄດ້ຖືກຍົກລະດັບຢ່າງເປັນທາງການເປັນວິທະຍາໄລໂລໂກສ. ຕໍ່ມາໃນປີ 2021 ໄດ້ຖືກຍົກລະດັບເປັນສະຖາບັນພາສາຕ່າງປະເທດໂລໂກສ. ໃນປີ 2023 ສະຖາບັນໄດ້ຮັບການຮັບຮອງຢ່າງເຕັມທີ່ຈາກກະຊວງສຶກສາທິການ ແລະ ກິລາ.',
    'vision_title' => 'ວິໄສທັດ',
    'vision_text' => 'ເພື່ອພັດທະນາໂລໂກສໃຫ້ກາຍເປັນສະຖາບັນຊັ້ນນຳດ້ານພາສາຕ່າງປະເທດ ແລະ ປັບປຸງມາດຕະຖານການສຶກສາໃຫ້ທັນສະໄໝ ເພື່ອບັນລຸຄວາມເປັນເລີດໃນພາກພື້ນ ແລະ ສາກົນ.',
    'mission_title' => 'ພາລະກິດ',
    'missions' => [
      'ເພື່ອພັດທະນານັກສຶກສາໃຫ້ສອດຄ່ອງກັບ 3 ລັກສະນະ ແລະ 5 ເສົາຄ້ຳຂອງການສຶກສາ.',
      'ເພື່ອຍົກລະດັບມາດຕະຖານການສຶກສາ ແລະ ໃຫ້ບໍລິການດ້ານວິຊາການທີ່ໂດດເດັ່ນແກ່ສັງຄົມ.',
      'ເພື່ອຜະລິດບຸກຄະລາກອນທີ່ມີທັກສະສູງ ແລະ ມີຄວາມສາມາດດ້ານພາສາຕ່າງປະເທດ ເພື່ອຕອບສະໜອງຕະຫຼາດແຮງງານ.',
      'ເພື່ອອະນຸລັກ ແລະ ສົ່ງເສີມສິລະປະ ແລະ ວັດທະນະທຳຂອງຊາດ ພ້ອມທັງເລືອກຮັບເອົາວັດທະນະທຳໂລກທີ່ກ້າວໜ້າໃນຍຸກສະໄໝໃໝ່.'
    ],
    'map_title' => 'ແຜນທີ່ ແລະ ຕິດຕໍ່',
    'contact_title' => 'ຕິດຕໍ່ພວກເຮົາ',
    'location' => 'ສະຖານທີ່: ຖະໜົນໂພນພະເນົາ',
    'address' => 'ໂຮມ 15 ໂພນພະເນົາ, ນະຄອນຫຼວງວຽງຈັນ, ລາວ',
    'phone' => 'ໂທ: +8562092362524',
    'email' => 'ອີເມວ: logosinstitute.fl.edu@gmail.com',
    'copyright' => 'ສະຖາບັນໂລໂກສ'
  ]
];
$about = $aboutText[$current_lang];

// ເຊື່ອມຕໍ່ Header ກາງທີ່ເຮົາສ້າງໄວ້
include 'header.php';
?>

  <!-- Hero Banner ສໍາລັບໜ້າ About -->
  <section class="about_hero_section" style="background: linear-gradient(rgba(11, 37, 25, 0.85), rgba(11, 37, 25, 0.85)), url('images/logosss.jpg'); background-size: cover; background-position: center; padding: 140px 0 60px 0; color: #ffffff; text-align: center;">
    <div class="container">
      <h1 style="font-weight: 700; font-size: 2.8rem; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px;"><?php echo htmlspecialchars($about['hero_title'], ENT_QUOTES, 'UTF-8'); ?></h1>
      <p style="font-size: 1.1rem; color: #d0d0d0; max-width: 700px; margin: 0 auto;">
        <?php echo htmlspecialchars($about['hero_description'], ENT_QUOTES, 'UTF-8'); ?>
      </p>
    </div>
  </section>

  <!-- Main About Content Section -->
  <section class="about_content_section layout_padding" style="padding: 80px 0; background-color: #f9f9f9;">
    <div class="container">
      
      <!-- Who We Are Row -->
      <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <div class="img-box shadow-sm" style="border-radius: 12px; overflow: hidden; height: 350px;">
            <img src="images/About 1.jpg" alt="About Logos Institute" style="width: 100%; height: 100%; object-fit: cover;">
          </div>
        </div>
        <div class="col-lg-6 pl-lg-5">
          <div class="detail-box">
            <span style="color: #f39c12; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 8px;"><?php echo htmlspecialchars($about['eyebrow'], ENT_QUOTES, 'UTF-8'); ?></span>
            <h2 style="font-weight: 700; color: #002b49; font-size: 2.2rem; margin-bottom: 20px;"><?php echo htmlspecialchars($about['institute_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <p style="color: #555; line-height: 1.8; margin-bottom: 15px; font-size: 0.95rem;">
              <?php echo htmlspecialchars($about['history_one'], ENT_QUOTES, 'UTF-8'); ?>
            </p>
            <p style="color: #555; line-height: 1.8; font-size: 0.95rem;">
              <?php echo htmlspecialchars($about['history_two'], ENT_QUOTES, 'UTF-8'); ?>
            </p>
          </div>
        </div>
      </div>

      <!-- Vision & Mission Card Layout -->
      <div class="row mt-5">
        <!-- Vision -->
        <div class="col-md-6 mb-4">
          <div style="background: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); height: 100%; border-top: 4px solid #f39c12;">
            <div style="width: 50px; height: 50px; background: rgba(243, 156, 18, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; color: #f39c12; font-size: 1.3rem;">
              <i class="fa fa-eye" aria-hidden="true"></i>
            </div>
            <h3 style="font-weight: 700; color: #002b49; font-size: 1.5rem; margin-bottom: 15px;"><?php echo htmlspecialchars($about['vision_title'], ENT_QUOTES, 'UTF-8'); ?></h3>
            <p style="color: #666; line-height: 1.7; font-size: 0.98rem; margin: 0;">
              <?php echo htmlspecialchars($about['vision_text'], ENT_QUOTES, 'UTF-8'); ?>
            </p>
          </div>
        </div>

        <!-- Mission -->
        <div class="col-md-6 mb-4">
          <div style="background: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); height: 100%; border-top: 4px solid #002b49;">
            <div style="width: 50px; height: 50px; background: rgba(0, 43, 73, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; color: #002b49; font-size: 1.3rem;">
              <i class="fa fa-bullseye" aria-hidden="true"></i>
            </div>
            <h3 style="font-weight: 700; color: #002b49; font-size: 1.5rem; margin-bottom: 15px;"><?php echo htmlspecialchars($about['mission_title'], ENT_QUOTES, 'UTF-8'); ?></h3>
            <ul style="color: #666; padding-left: 18px; line-height: 1.7; font-size: 0.95rem; margin: 0;">
              <?php foreach ($about['missions'] as $mission): ?>
                <li style="margin-bottom: 8px;"><?php echo htmlspecialchars($mission, ENT_QUOTES, 'UTF-8'); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- Contact Section (ຄົງຮູບແບບດຽວກັນກັບໜ້າ Index) -->
  <section class="contact_section layout_padding" style="background-color: #0b2519; color: #ffffff; padding: 70px 0;">
    <div class="container">
      <div class="heading_container text-center mb-5">
        <h2 style="color: #ffffff; font-weight: 700;"><?php echo htmlspecialchars($about['map_title'], ENT_QUOTES, 'UTF-8'); ?></h2>
      </div>

      <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
          <div class="map_container" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3794.780105905844!2d102.63083141024914!3d17.98896468512677!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x312467e8718562d9%3A0x6e84fd1e2e235b0e!2sLogos%20Institute%20of%20Foreign%20Language%20(LIFL)!5e0!3m2!1sth!2sla!4v1773388410171!5m2!1sth!2sla" width="100%" height="320" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>
        </div>

        <div class="col-md-6 pl-lg-5">
          <div class="contact_info">
            <h3 style="font-weight: 700; font-size: 1.5rem; margin-bottom: 20px; color: #ffffff;">
              <?php echo htmlspecialchars($about['contact_title'], ENT_QUOTES, 'UTF-8'); ?>
            </h3>

            <div class="d-flex align-items-start mb-3">
              <i class="fa fa-map-marker" aria-hidden="true" style="font-size: 1.5rem; margin-right: 15px; width: 20px; text-align: center; color: #ffffff;"></i>
              <div>
                <strong style="display: block;"><?php echo htmlspecialchars($about['location'], ENT_QUOTES, 'UTF-8'); ?></strong>
                <span><?php echo htmlspecialchars($about['address'], ENT_QUOTES, 'UTF-8'); ?></span>
              </div>
            </div>

            <div class="d-flex align-items-center mb-3">
              <i class="fa fa-phone" aria-hidden="true" style="font-size: 1.3rem; margin-right: 15px; width: 20px; text-align: center; color: #ffffff;"></i>
              <div>
                <span><?php echo htmlspecialchars($about['phone'], ENT_QUOTES, 'UTF-8'); ?></span>
              </div>
            </div>

            <div class="d-flex align-items-center mb-4">
              <i class="fa fa-envelope" aria-hidden="true" style="font-size: 1.2rem; margin-right: 15px; width: 20px; text-align: center; color: #ffffff;"></i>
              <div>
                <span><?php echo htmlspecialchars($about['email'], ENT_QUOTES, 'UTF-8'); ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer Section -->
  <footer class="footer_section" style="background-color: #ffffff; color: #333333; padding: 15px 0;">
    <div class="container text-center">
      <p style="margin: 0; font-size: 0.9rem; color: #555555;">
        &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($about['copyright'], ENT_QUOTES, 'UTF-8'); ?>
      </p>
    </div>
  </footer>

  <!-- CDN Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

  <script>
    /* 📌 JavaScript ຈັດການ Active Menu ໃຫ້ຂຶ້ນເສັ້ນໃຕ້ຖືກຕ້ອງຕາມໜ້າ */
    document.addEventListener("DOMContentLoaded", function() {
      let currentPath = window.location.pathname.split("/").pop();
      if (currentPath === "" || currentPath === "/") {
        currentPath = "index.php";
      }

      const navItems = document.querySelectorAll(".custom_nav-container .navbar-nav .nav-item");

      navItems.forEach(item => {
        const page = item.getAttribute("data-page");
        item.classList.remove("active");

        if (page === currentPath) {
          item.classList.add("active");
        }
      });
    });
  </script>

</body>
</html>