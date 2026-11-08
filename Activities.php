<?php
session_start();
$current_lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// --- ຈັດເກັບຂໍ້ມູນກິດຈະກຳ (Activities) ຕາມລຳດັບ 3 ແຖວທີ່ທ່ານຕ້ອງການ ---
$activities_list = [
    // --- ແຖວທີ 1 (4 ຢ່າງ) ---
    [
        'title' => 'K-Pop Club',
        'description' => 'ກິດຈະກຳຊົມລົມ K-Pop ເພື່ອສະແດງອອກທາງດ້ານການເຕັ້ນ ແລະ ຄວາມຄິດສ້າງສັນ.',
        'image' => 'images/korean1.jpg',
        'badge' => 'Club',
        'link' => '#'
    ],
    [
        'title' => 'Sing and Music',
        'description' => 'ຊົມລົມດົນຕີ ແລະ ການຮ້ອງເພງ ພັດທະນາສຽງດົນຕີ ແລະ ການສະແດງອອກ.',
        'image' => 'images/about201.jpg',
        'badge' => 'Club',
        'link' => '#'
    ],
    [
        'title' => 'Lao Dance',
        'description' => 'ຮຽນຮູ້ ແລະ ອານຸລັກສິລະປະວັດທະນະທຳການຟ້ອນພື້ນເມືອງລາວ.',
        'image' => 'images/Activities201.jpg',
        'badge' => 'Culture',
        'link' => '#'
    ],
    [
        'title' => 'Football Club',
        'description' => 'ກິດຈະກຳກິລາບານເຕະ ສ້າງສຸຂະພາບຮ່າງກາຍທີ່ແຂງແຮງ ແລະ ຄວາມສາມັກຄີ.',
        'image' => 'images/cs1.jpg',
        'badge' => 'Sports',
        'link' => '#'
    ],

    // --- ແຖວທີ 2 (2 ຢ່າງ) ---
    [
        'title' => 'Festival',
        'description' => 'ງານບຸນປະເພນີ ແລະ ກິດຈະກຳສະຫຼອງວັນສຳຄັນຕ່າງໆຂອງສະຖາບັນ.',
        'image' => 'images/chinese1.jpg',
        'badge' => 'Major Event',
        'featured' => true,
        'link' => '#'
    ],
    [
        'title' => '25th Anniversary Celebration',
        'description' => 'ສະຫຼອງຄົບຮອບ 25 ປີ ຂອງສະຖາບັນພາສາຕ່າງປະເທດ ໂລໂກສ (Logos Institute).',
        'image' => 'images/logoess.jpg',
        'badge' => 'Highlight',
        'featured' => true,
        'link' => '#'
    ],

    // --- ແຖວທີ 3 (4 ຢ່າງ) ---
    [
        'title' => 'Volunteer Week',
        'description' => 'ສັບປາຄົມອາສາສະໝັກ ເພື່ອສັງຄົມ ແລະ ຊ່ວຍເຫຼືອຊຸມຊົນ.',
        'image' => 'images/english1.jpg',
        'badge' => 'Community',
        'link' => '#'
    ],
    [
        'title' => 'Study Tour',
        'description' => 'ທັດສະນະສຶກສາ ຫາປະສົບການນອກຫ້ອງຮຽນ ແລະ ເປີດໂລກທັດສະນະ.',
        'image' => 'images/korean1.jpg',
        'badge' => 'Trip',
        'link' => '#'
    ],
    [
        'title' => 'ພິທີປະຖົມນິເທດ ແລະ ມອບຮັບທຶນການສຶກສາ',
        'description' => 'ຕ້ອນຮັບນັກສຶກສາໃໝ່ ແລະ ມອບທຶນການສຶກສາປະຈຳປີ.',
        'image' => 'images/about201.jpg',
        'badge' => 'Academic',
        'link' => '#'
    ],
    [
        'title' => 'ກິດຈະກຳການສະແດງລະຄອນເວທີ',
        'description' => 'ການສະແດງລະຄອນເວທີສື່ພາສາ ແລະ ຄວາມຄິດສ້າງສັນຂອງນັກສຶກສາ.',
        'image' => 'images/chinese1.jpg',
        'badge' => 'Performance',
        'link' => '#'
    ]
];

// --- ເອີ້ນໃຊ້ Header ກາງ ---
include 'header.php';
?>

  <!-- Custom CSS ສຳລັບ Clean White Cards -->
  <style>
    .activities_section {
      padding: 100px 0 80px 0;
      background-color: #f8fafc;
    }
    .activities_header {
      margin-bottom: 50px;
    }
    .activities_header h2 {
      font-weight: 700;
      color: #002b49;
      font-size: 2.5rem;
      margin-bottom: 15px;
    }
    .activities_header p {
      color: #555;
      font-size: 1.05rem;
      max-width: 800px;
      margin: 0 auto;
    }

    /* ດີໄຊນ໌ Card ສີຂາວສະອາດຕາ */
    .activity_card_white {
      background: #ffffff;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 43, 73, 0.08);
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      height: 100%;
      position: relative;
      border: 1px solid #e2e8f0;
    }

    .activity_card_white:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0, 43, 73, 0.15);
    }

    /* ຖ້າເປັນງານໃຫຍ່ (Featured) ໃຫ້ໃສ່ຂອບສີທອງເພີ່ມຄວາມເດັ່ນ */
    .activity_card_white.featured-card {
      border: 2px solid #f39c12;
      box-shadow: 0 10px 30px rgba(243, 156, 18, 0.2);
    }

    /* ພາກສ່ວນຮູບພາບ */
    .card_img_wrapper {
      width: 100%;
      height: 200px;
      overflow: hidden;
      position: relative;
    }

    .card_img_wrapper img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .activity_card_white:hover .card_img_wrapper img {
      transform: scale(1.08);
    }

    /* ປ້າຍ Badge ມຸມຂວາເທິງຂອງຮູບ */
    .card_badge {
      position: absolute;
      top: 12px;
      right: 12px;
      background: rgba(0, 43, 73, 0.85);
      color: #ffffff;
      font-size: 0.75rem;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: 20px;
      backdrop-filter: blur(4px);
    }

    .activity_card_white.featured-card .card_badge {
      background: linear-gradient(135deg, #f39c12, #d35400);
    }

    /* ພາກສ່ວນເນື້ອຫາດ້ານລຸ່ມ */
    .card_body_content {
      padding: 25px 20px;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
      text-align: center;
    }

    .card_body_content h4 {
      font-size: 1.15rem;
      font-weight: 700;
      color: #002b49;
      margin-bottom: 12px;
      line-height: 1.4;
    }

    .card_body_content p {
      font-size: 0.85rem;
      color: #64748b;
      margin-bottom: 20px;
      line-height: 1.5;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
      flex-grow: 1;
    }

    /* ປຸ່ມ View Detail ມຸມມົນສີເຂັ້ມ */
    .btn-view-detail {
      background-color: #002b49;
      color: #ffffff;
      font-weight: 600;
      font-size: 0.85rem;
      padding: 8px 25px;
      border-radius: 20px;
      border: none;
      text-decoration: none;
      display: inline-block;
      transition: background-color 0.3s, transform 0.2s;
      margin: 0 auto;
      cursor: pointer;
    }

    .btn-view-detail:hover {
      background-color: #004070;
      color: #ffffff;
      transform: scale(1.05);
    }

    /* Custom Modal Popup Styling */
    .custom-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 9999;
      justify-content: center;
      align-items: center;
      backdrop-filter: blur(5px);
      animation: fadeIn 0.3s ease;
    }
    .custom-modal.active {
      display: flex;
    }
    .custom-modal-content {
      background: #ffffff;
      width: 90%;
      max-width: 600px;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 25px 50px rgba(0,0,0,0.25);
      position: relative;
      animation: slideUp 0.3s ease;
    }
    .custom-modal-img {
      width: 100%;
      height: 250px;
      object-fit: cover;
    }
    .custom-modal-body {
      padding: 30px;
      color: #333;
      text-align: left;
    }
    .custom-modal-body h3 {
      color: #002b49;
      font-weight: 700;
      margin-bottom: 15px;
    }
    .custom-modal-body p {
      color: #555;
      line-height: 1.6;
      margin-bottom: 25px;
    }
    .close-modal-btn {
      position: absolute;
      top: 15px;
      right: 15px;
      background: rgba(0,0,0,0.5);
      color: #fff;
      border: none;
      width: 35px;
      height: 35px;
      border-radius: 50%;
      font-size: 1.2rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.2s;
      z-index: 10;
    }
    .close-modal-btn:hover {
      background: rgba(0,0,0,0.8);
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @keyframes slideUp {
      from { transform: translateY(30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
  </style>

  <!-- Activities Section -->
  <section class="activities_section">
    <div class="container">
      
      <!-- Header Title -->
      <div class="activities_header text-center">
        <h2>Institute Activities</h2>
        <p>Explore the vibrant campus life and exciting student activities at Logos Institute of Foreign Language.</p>
      </div>

      <!-- ແຖວທີ 1 (4 ຢ່າງ: K-Pop Club, Sing and Music, Lao Dance, Football Club) -->
      <div class="row mb-4">
        <?php for ($i = 0; $i < 4; $i++): 
          $activity = $activities_list[$i];
        ?>
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="activity_card_white">
              <div class="card_img_wrapper">
                <span class="card_badge"><?= htmlspecialchars($activity['badge']); ?></span>
                <img src="<?= htmlspecialchars($activity['image']); ?>" alt="<?= htmlspecialchars($activity['title']); ?>">
              </div>
              <div class="card_body_content">
                <h4><?= htmlspecialchars($activity['title']); ?></h4>
                <p><?= htmlspecialchars($activity['description']); ?></p>
                <button type="button" class="btn-view-detail btn-detail-trigger" 
                        data-title="<?= htmlspecialchars($activity['title']); ?>" 
                        data-desc="<?= htmlspecialchars($activity['description']); ?>" 
                        data-img="<?= htmlspecialchars($activity['image']); ?>">
                  View Detail
                </button>
              </div>
            </div>
          </div>
        <?php endfor; ?>
      </div>

      <!-- ແຖວທີ 2 (2 ຢ່າງ: Festival, 25th Anniversary Celebration) -->
      <div class="row mb-4 justify-content-center">
        <?php for ($i = 4; $i < 6; $i++): 
          $activity = $activities_list[$i];
          $isFeatured = !empty($activity['featured']);
        ?>
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="activity_card_white <?= $isFeatured ? 'featured-card' : ''; ?>">
              <div class="card_img_wrapper">
                <span class="card_badge"><?= htmlspecialchars($activity['badge']); ?></span>
                <img src="<?= htmlspecialchars($activity['image']); ?>" alt="<?= htmlspecialchars($activity['title']); ?>">
              </div>
              <div class="card_body_content">
                <h4><?php if($isFeatured): ?><span style="color: #f1c40f;">&#9733;</span><?php endif; ?><?= htmlspecialchars($activity['title']); ?></h4>
                <p><?= htmlspecialchars($activity['description']); ?></p>
                <button type="button" class="btn-view-detail btn-detail-trigger" 
                        data-title="<?= htmlspecialchars($activity['title']); ?>" 
                        data-desc="<?= htmlspecialchars($activity['description']); ?>" 
                        data-img="<?= htmlspecialchars($activity['image']); ?>">
                  View Detail
                </button>
              </div>
            </div>
          </div>
        <?php endfor; ?>
      </div>

      <!-- ແຖວທີ 3 (5 ຢ່າງທີ່ເຫຼືອ) -->
      <div class="row">
        <?php for ($i = 6; $i < count($activities_list); $i++): 
          $activity = $activities_list[$i];
        ?>
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="activity_card_white">
              <div class="card_img_wrapper">
                <span class="card_badge"><?= htmlspecialchars($activity['badge']); ?></span>
                <img src="<?= htmlspecialchars($activity['image']); ?>" alt="<?= htmlspecialchars($activity['title']); ?>">
              </div>
              <div class="card_body_content">
                <h4><?= htmlspecialchars($activity['title']); ?></h4>
                <p><?= htmlspecialchars($activity['description']); ?></p>
                <button type="button" class="btn-view-detail btn-detail-trigger" 
                        data-title="<?= htmlspecialchars($activity['title']); ?>" 
                        data-desc="<?= htmlspecialchars($activity['description']); ?>" 
                        data-img="<?= htmlspecialchars($activity['image']); ?>">
                  View Detail
                </button>
              </div>
            </div>
          </div>
        <?php endfor; ?>
      </div>

    </div>
  </section>
  <!-- Detail Modal Popup -->
  <div class="custom-modal" id="activityModal">
    <div class="custom-modal-content">
      <button type="button" class="close-modal-btn" id="closeModal">&times;</button>
      <img src="" alt="" class="custom-modal-img" id="modalImg">
      <div class="custom-modal-body">
        <h3 id="modalTitle">Title</h3>
        <p id="modalDesc">Description goes here...</p>
        <button type="button" class="btn btn-primary" style="background-color: #002b49; border: none; border-radius: 20px; padding: 8px 25px;" id="closeModalBtn">ປິດໜ້າຕ່າງນີ້</button>
      </div>
    </div>
  </div>

  <!-- Info Section -->
  <section class="info_section" style="background-color: #0b2519; color: #ffffff; padding: 60px 0 30px 0;">
    <div class="container">
      <div class="info_top">
        <div class="row">
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="info_detail">
              <a href="index.php">
                <h4 style="color: #ffffff; font-weight: 700;">Logos institute</h4>
              </a>
             
              <div class="social_box mt-3">
  <a href="https://www.facebook.com/profile.php?id=100064500650769&locale=th_TH" style="color: #ffffff; margin-right: 10px;"><i class="fa fa-facebook" aria-hidden="true"></i></a>
  <a href="#" style="color: #ffffff; margin-right: 10px;"><i class="fa fa-twitter" aria-hidden="true"></i></a>
  <a href="#" style="color: #ffffff; margin-right: 10px;"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
  <a href="#" style="color: #ffffff; margin-right: 10px;"><i class="fa fa-instagram" aria-hidden="true"></i></a>
  
  <a href="#" target="_blank" style="color: #ffffff; display: inline-flex; justify-content: center; align-items: center; width: 40px; height: 40px; border: 1px solid #ffffff; border-radius: 50%; vertical-align: middle;">
    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" fill="currentColor" viewBox="0 0 448 512">
      <path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55 162.55 0 1 1 185 188.31V258.2a90.08 90.08 0 1 0 57.6 84.45V0h70.36a141.52 141.52 0 0 0 3.73 31.7 140.7 140.7 0 0 0 31.54 57.8 140.06 140.06 0 0 0 53.79 33.6A140.67 140.67 0 0 0 448 128v81.91z"/>
    </svg>
  </a>
</div>
            </div>
          </div>
          <div class="col-sm-6 col-md-4 col-lg-3 mx-auto">
            <h4 style="color: #ffffff; font-weight: 700; font-size: 1.2rem;">Contact us</h4>
            <div class="contact_nav mt-3">
              <p style="margin-bottom: 8px;"><i class="fa fa-map-marker" aria-hidden="true"></i> Location: Phonpanao Road, Vientiane, Laos</p>
              <p style="margin-bottom: 8px;"><i class="fa fa-phone" aria-hidden="true"></i> Call : +8562092362524</p>
              <p><i class="fa fa-envelope" aria-hidden="true"></i> Email : logosinstitute.fl.edu@gmail.com</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="info_form">
              <h4 style="color: #ffffff; font-weight: 700; font-size: 1.2rem;">SIGN UP TO OUR NEWSLETTER</h4>
              <form action="" class="mt-3">
                <input type="text" placeholder="Enter Your Email" class="form-control mb-2" style="border-radius: 20px;" />
                <button type="submit" class="btn btn-danger" style="border-radius: 20px; padding: 6px 20px;">Subscribe</button>
              </form>
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
        &copy; <?php echo date('Y'); ?> Logos institute
      </p>
    </div>
  </footer>

  <!-- CDN Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

  <!-- Script ສຳລັບຄວບຄຸມ Modal Popup -->
  <script>
    $(document).ready(function() {
      $('.btn-detail-trigger').on('click', function() {
        let title = $(this).data('title');
        let desc = $(this).data('desc');
        let img = $(this).data('img');

        $('#modalTitle').text(title);
        $('#modalDesc').text(desc);
        $('#modalImg').attr('src', img);

        $('#activityModal').addClass('active');
        $('body').css('overflow', 'hidden');
      });

      $('#closeModal, #closeModalBtn, #activityModal').on('click', function(e) {
        if (e.target !== this && this.id === 'activityModal') return;
        $('#activityModal').removeClass('active');
        $('body').css('overflow', 'auto');
      });
    });
  </script>

</body>
</html>