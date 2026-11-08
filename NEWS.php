<?php
session_start();
$current_lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// --- ຂໍ້ມູນຕົວຢ່າງຂອງຂ່າວສານ (ສາມາດດึงมาจาก MySQL Database ໄດ້) ---
$news_list = [
    [
        'title' => 'ພິທີເປີດສົກຮຽນໃໝ່ ປະຈຳປີ 2026-2027',
        'date' => '02 ພະຈິກ 2026',
        'category' => 'Announcement',
        'description' => 'ສະຖາບັນພາສາຕ່າງປະເທດ ໂລໂກສ ໄດ້ຈັດພິທີເປີດສົກຮຽນໃໝ່ຢ່າງເປັນທາງການ ໂດຍມີຄູ-ອາຈານ ແລະ ນ້ອງໆນັກສຶກສາເຂົ້າຮ່ວມຢ່າງຄັບຄາໜາ.',
        'image' => 'images/about201.jpg',
        'featured' => true
    ],
    [
        'title' => 'ກິດຈະກຳທັດສະນະສຶກສາຂອງນັກສຶກສາສາຂາພາສາຈີນ',
        'date' => '28 ຕຸລາ 2026',
        'category' => 'Activities',
        'description' => 'ນຳພານັກສຶກສາໄປທັດສະນະສຶກສາ ແລະ ຮຽນຮູ້ປະສົບການນອກຫ້ອງຮຽນ ເພື່ອເສີມສ້າງທັກສະດ້ານພາສາ.',
        'image' => 'images/chinese1.jpg',
        'featured' => false
    ],
    [
        'title' => 'ປະກາດຜົນການສອບເສັງຊິງທຶນການສຶກສາ ປະຈຳປີ',
        'date' => '15 ຕຸລາ 2026',
        'category' => 'Scholarship',
        'description' => 'ປະກາດລາຍຊື່ຜູ້ທີ່ມີສິດໄດ້ຮັບທຶນການສຶກສາ ຂອງສະຖາບັນ ໂລໂກສ ສົກຮຽນນີ້.',
        'image' => 'images/logoess.jpg',
        'featured' => false
    ],
    [
        'title' => 'ງານສະຫຼອງວັນຄູແຫ່ງຊາດ 7 ຕຸລາ',
        'date' => '07 ຕຸລາ 2026',
        'category' => 'Event',
        'description' => 'ນັກສຶກສາທຸກສາຂາຮ່ວມສະແດງຄວາມເຄົາລົບຕໍ່ຄູ ແລະ ມອບກະຕ່າຂອງຂວັນໃຫ້ແກ່ຄູ-ອາຈານ.',
        'image' => 'images/english1.jpg',
        'featured' => false
    ]
];

// ເອີ້ນໃຊ້ Header ກາງ
include 'header.php';
?>

<!-- Custom CSS ສຳລັບໜ້າ News -->
<style>
  .news_section {
    padding: 100px 0 80px 0;
    background-color: #f8fafc;
  }
  .news_header {
    margin-bottom: 50px;
    text-align: center;
  }
  .news_header h2 {
    font-weight: 700;
    color: #002b49;
    font-size: 2.5rem;
    margin-bottom: 15px;
  }
  .news_header p {
    color: #64748b;
    font-size: 1.05rem;
    max-width: 700px;
    margin: 0 auto;
  }

  /* News Card Design */
  .news_card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 43, 73, 0.08);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    border: 1px solid #e2e8f0;
  }
  .news_card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 43, 73, 0.15);
  }
  .news_img_wrapper {
    position: relative;
    height: 220px;
    overflow: hidden;
  }
  .news_img_wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  .news_card:hover .news_img_wrapper img {
    transform: scale(1.08);
  }
 
  .news_content {
    padding: 25px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
  }
  .news_date {
    font-size: 0.85rem;
    color: #f39c12;
    font-weight: 600;
    margin-bottom: 8px;
  }
  .news_content h4 {
    font-size: 1.15rem;
    font-weight: 700;
    color: #002b49;
    margin-bottom: 12px;
    line-height: 1.4;
  }
  .news_content p {
    font-size: 0.9rem;
    color: #64748b;
    margin-bottom: 20px;
    line-height: 1.5;
    flex-grow: 1;
  }
  .btn-read-more {
    background-color: #002b49;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.85rem;
    padding: 8px 20px;
    border-radius: 20px;
    border: none;
    text-decoration: none;
    text-align: center;
    transition: background-color 0.3s;
    width: fit-content;
  }
  .btn-read-more:hover {
    background-color: #004070;
    color: #fff;
  }
</style>

<!-- News Section -->
<section class="news_section">
  <div class="container">
    
    <!-- Title -->
    <div class="news_header">
      <h2>Latest News & Announcements</h2>
      <p>ຕິດຕາມຂ່າວສານຄວາມເຄື່ອນໄຫວ, ກິດຈະກຳ ແລະ 公告 ຫຼ້າສຸດຈາກສະຖາບັນພາສາຕ່າງປະເທດ ໂລໂກສ.</p>
    </div>

    <!-- News Grid -->
    <div class="row g-4">
      <?php foreach ($news_list as $news): ?>
        <div class="col-lg-4 col-md-6">
          <div class="news_card">
            
            <!-- Image & Category Badge -->
            <div class="news_img_wrapper">
              <span class="news_badge"><?= htmlspecialchars($news['category']); ?></span>
              <img src="<?= htmlspecialchars($news['image']); ?>" alt="<?= htmlspecialchars($news['title']); ?>">
            </div>

            <!-- Content -->
            <div class="news_content">
              <span class="news_date"><i class="fa fa-calendar" aria-hidden="true"></i> <?= htmlspecialchars($news['date']); ?></span>
              <h4><?= htmlspecialchars($news['title']); ?></h4>
              <p><?= htmlspecialchars($news['description']); ?></p>
              
              <a href="#" class="btn-read-more">Read More &rarr;</a>
            </div>

          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <nav class="mt-5">
      <ul class="pagination justify-content-center">
        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item active"><a class="page-link" href="#" style="background-color: #002b49; border-color: #002b49;">1</a></li>
        <li class="page-item"><a class="page-link" href="#" style="color: #002b49;">2</a></li>
        <li class="page-item"><a class="page-link" href="#" style="color: #002b49;">3</a></li>
        <li class="page-item"><a class="page-link" href="#" style="color: #002b49;">Next</a></li>
      </ul>
    </nav>

  </div>
</section>
<section class="course_section layout_padding">
<div class="top-divider-container" style="position: relative; text-align: center; margin-top: 80px; margin-bottom: 25px;">
    <div style="height: 8px; background: linear-gradient(to right, #002b49, #6c757d, #dc3545); width: 100%;"></div>
    <a href="#" onclick="scrollToTop(event)" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #002b49; color: #ffffff; width: 65px; height: 65px; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 4px 12px rgba(0,0,0,0.3); border: 2.5px solid #ffffff; font-size: 0.85rem; font-weight: bold; letter-spacing: 1px; transition: all 0.3s ease;">
      <i class="fa fa-angle-up" aria-hidden="true" style="font-size: 1.1rem; margin-bottom: -2px;"></i>
      <span>TOP</span>
    </a>
  </div>
  </section>

<?php 
// ເອີ້ນໃຊ້ Footer ກາງ
include 'footer.php'; 
?>