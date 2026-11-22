<?php
session_start();
require_once __DIR__ . '/app_config.php';
require_once __DIR__ . '/site_content_localization.php';
$current_lang = site_supported_language($_GET['lang'] ?? 'en');

// --- 1. ເຊື່ອມຕໍ່ Database ---
$databaseConfig = site_config();
$conn = new mysqli(
    $databaseConfig['website_db_host'],
    $databaseConfig['website_db_username'],
    $databaseConfig['website_db_password'],
    $databaseConfig['website_db_name']
);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

site_ensure_multilingual_content_schema($conn);
site_ensure_holiday_notice_schema($conn);
$holidayNoticeResult = $conn->query("SELECT * FROM website_holiday_notice WHERE id = 1");
$holidayNotice = $holidayNoticeResult->fetch_assoc();
$holidayNoticeTitle = $holidayNotice['title_' . $current_lang] ?: $holidayNotice['title_en'];
$holidayNoticeBody = $holidayNotice['body_' . $current_lang] ?: $holidayNotice['body_en'];
$holidayNoticeImages = array_values(array_filter([
    $holidayNotice['image_one'],
    $holidayNotice['image_two'],
]));

$curriculums = [
    [
        'title' => 'Bachelor’s degrees',
        'description' => 'Bachelor programs in English, Korean, Chinese, and AI Computer Science.',
        'image' => 'images/englishS (1).jpg',
        'link' => 'course.php#bachelor-programs',
    ],
    [
        'title' => 'Special supplementary courses',
        'description' => 'Practical, goal-focused learning for communication and language-test preparation.',
        'image' => 'images/KoreanS1.jpg',
        'link' => 'course.php#special-programs',
    ],
    [
        'title' => 'Lao for international learners',
        'description' => 'Learn useful Lao step by step, practise real-life conversations, and discover the culture behind the language. A welcoming course for international residents, visitors, and anyone curious about Laos.',
        'image' => 'images/IMG_5213.jpg',
        'link' => 'course.php#lao-language',
    ],
];

// --- 3. ດຶງຂໍ້ມູນ dynamic ຈາກຕາຕະລາງ website_activities (Activities) ---
$sql_act = "SELECT * FROM website_activities ORDER BY id DESC";
$result_act = $conn->query($sql_act);

$activities = [];
if ($result_act && $result_act->num_rows > 0) {
    while ($row_act = $result_act->fetch_assoc()) {
        $row_act['title'] = site_localized_value($row_act, 'title', $current_lang);
        $row_act['description'] = site_localized_value($row_act, 'description', $current_lang);
        $activities[] = $row_act;
    }
}

$activity_highlights = [
    [
        'title' => 'Students performing on stage',
        'image' => 'images/Activities 1 (1).jpg',
    ],
    [
        'title' => 'Students performing at a Logos festival',
        'image' => 'images/activities 2.jpg',
    ],
    [
        'title' => 'Students in a stage performance',
        'image' => 'images/activities 3.jpg',
    ],
    [
        'title' => 'Logos football team',
        'image' => 'images/activities 4.jpg',
    ],
    [
        'title' => 'Lao cultural event',
        'image' => 'images/IMG_5213.jpg',
    ],
    [
        'title' => 'Students performing Lao culture',
        'image' => 'images/IMG_5217.jpg',
    ],
    [
        'title' => 'Traditional Lao dance',
        'image' => 'images/IMG_6656.jpg',
    ],
];

$activity_cards = !empty($activities) ? $activities : $activity_highlights;

// --- 📌 ເອີ້ນໃຊ້ Header ກາງທີ່ເຮົາສ້າງຂຶ້ນ ---
include 'header.php';
?>

<section class="slider_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10">
                <div class="detail-box">
                    <span
                        style="color: #f39c12; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 10px;">
                        LEARN. CONNECT. GROW.
                    </span>
                    <h1>WELCOME TO <br> LOGOS INSTITUTE OF FOREIGN LANGUAGE</h1>
                    <p>
                        Learn a language. Open your world.<br>
                        Connecting people, cultures, and possibilities through the power of language. Your next chapter
                        starts here.
                    </p>
                    <div class="btn-box">
                        <a href="course.php" class="btn1">Explore programs &rarr;</a>
                        <a href="about.php" class="btn2">Discover IFL</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<!-- Holiday Announcement Section -->
<section class="about_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="img-box">
                    <button type="button" class="holiday-notice-preview" onclick="openHolidayNoticeModal()"
                        aria-label="View holiday announcement">
                        <?php if (!empty($holidayNoticeImages)): ?>
                            <?php foreach ($holidayNoticeImages as $image): ?>
                            <img src="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8'); ?>"
                                alt="<?= htmlspecialchars($holidayNoticeTitle, ENT_QUOTES, 'UTF-8'); ?>"
                                class="img-fluid">
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="holiday-notice-placeholder" aria-hidden="true">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                            </span>
                        <?php endif; ?>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-box">
                    <div class="heading_container">
                        <h2><?= htmlspecialchars($holidayNoticeTitle, ENT_QUOTES, 'UTF-8'); ?></h2>
                    </div>
                    <p><?= nl2br(htmlspecialchars($holidayNoticeBody, ENT_QUOTES, 'UTF-8')); ?></p>
                    <button type="button" class="btn btn-primary" onclick="openHolidayNoticeModal()">
                        <?= $current_lang === 'la' ? 'ເບິ່ງປະກາດ' : ($current_lang === 'ko' ? '공지 보기' : ($current_lang === 'zh' ? '查看通知' : 'View announcement')); ?>
                    </button>
                    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                    <a class="btn btn-outline-primary ml-2"
                        href="manage_holiday_notice.php?lang=<?= urlencode($current_lang); ?>">
                        <?= $current_lang === 'la' ? 'ແກ້ໄຂປະກາດ' : ($current_lang === 'ko' ? '공지 수정' : ($current_lang === 'zh' ? '编辑通知' : 'Edit announcement')); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container my-5 text-center">
    <div class="d-flex align-items-center justify-content-center">
        <div style="flex: 1; height: 2px; background-color: #002b49;"></div>
        <span class="px-3" style="color: #002b49; font-size: 1.3rem;">
            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
        </span>
        <div style="flex: 1; height: 2px; background-color: #002b49;"></div>
    </div>
</div>

<!-- About Section -->
<section class="about_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="img-box">
                    <img src="images/About 1.jpg" alt="About Logos Institute" class="img-fluid">
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-box">
                    <div class="heading_container">
                        <h2>Who We Are</h2>
                    </div>
                    <p>
                        Logos Institute was originally established in 2001 as the Logos Academy Center. Initially, it
                        offered continuing education and short-term training programs in English, Korean, and Computer
                        Science.
                    </p>
                    <p>
                        In 2014, Logos Academy Center was officially upgraded to Logos College. Subsequently, in 2021,
                        it was elevated to the Logos Institute of Foreign Languages. By 2023, the institution achieved
                        full accreditation as a comprehensive institute, recognized by the Ministry of Education and
                        Sports.
                    </p>
                    <a href="about.php">Read More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Curriculum Section -->
<section class="course_section layout_padding"
    style="position: relative; background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 43, 73, 0.85)), url('images/logosss.jpg'); background-size: cover; background-position: center; background-attachment: fixed; padding: 80px 0;">
    <div class="container">

        <div class="heading_container text-center mb-5" style="align-items: center; text-align: center;">
            <h2
                style="font-weight: 800; color: #ffffff; text-transform: uppercase; font-size: 2.8rem; letter-spacing: 2px; margin: 0 auto; text-align: center; text-shadow: 3px 3px 10px rgba(0,0,0,0.5);">
                Curriculum
            </h2>
            <p style="font-size: 1rem; margin-top: 10px; color: #e0e0e0; text-align: center;">
                ພວກເຮົາມີຫຼັກສູດຫຼັກ 3 ປະເພດ: ຫຼັກສູດປະລິນຍາຕີ, ຫຼັກສູດພາສາພິເສດ ຫຼື ຫຼັກສູດບຳລຸງ, ແລະ ຫຼັກສູດພາສາລາວສຳລັບຜູ້ຮຽນຕ່າງປະເທດ.
            </p>

        </div>

        <div class="activities-grid">
            <?php if (!empty($curriculums)): ?>
            <?php foreach ($curriculums as $item): ?>
            <article class="activity-feature-card">
                <div class="activity-feature-image">
                    <img src="<?= htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>"
                        alt="<?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
                </div>
            </article>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="activities-more-action">
            <a class="activities-more-link" href="course.php?lang=<?= urlencode($current_lang); ?>">
                Read More <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>

    </div>
</section>

<style>
.logos-activities-section {
    position: relative;
    overflow: hidden;
    padding: 88px 0 72px;
    background: linear-gradient(135deg, #061d31 0%, #0b4261 58%, #0d5d78 100%);
}

.logos-activities-section::before,
.logos-activities-section::after {
    position: absolute;
    width: 340px;
    height: 340px;
    border: 1px solid rgba(255, 255, 255, .1);
    border-radius: 50%;
    content: "";
    pointer-events: none;
}

.logos-activities-section::before {
    top: -190px;
    left: -100px;
    box-shadow: 0 0 0 35px rgba(255, 255, 255, .025), 0 0 0 70px rgba(255, 255, 255, .02);
}

.logos-activities-section::after {
    right: -170px;
    bottom: -240px;
    box-shadow: 0 0 0 35px rgba(255, 255, 255, .025), 0 0 0 70px rgba(255, 255, 255, .02);
}

.logos-activities-section .container {
    position: relative;
    z-index: 1;
}

.activities-heading {
    max-width: 760px;
    margin: 0 auto 42px;
    text-align: center;
}

.activities-eyebrow {
    display: inline-block;
    margin-bottom: 12px;
    color: #ffd27a;
    font-size: .78rem;
    font-weight: 800;
    letter-spacing: .16em;
    text-transform: uppercase;
}

.activities-heading h2 {
    margin: 0 0 14px;
    color: #fff !important;
    font-size: clamp(2.5rem, 5vw, 3.8rem);
    font-weight: 900;
    letter-spacing: .02em;
    line-height: 1.2;
    text-shadow: 0 3px 14px rgba(0, 0, 0, .65);
}

.activities-heading h2::after {
    display: block;
    width: 76px;
    height: 4px;
    margin: 16px auto 0;
    border-radius: 4px;
    background: #ffd27a;
    content: "";
}

.activities-heading p {
    margin: 0;
    color: #f4f9fc !important;
    font-size: 1.08rem;
    font-weight: 500;
    line-height: 1.75;
    text-shadow: 0 1px 5px rgba(0, 0, 0, .45);
}

.activities-admin-action {
    margin-top: 22px;
}

.activities-admin-action a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border: 1px solid rgba(255, 255, 255, .55);
    border-radius: 24px;
    color: #fff;
    font-weight: 700;
    text-decoration: none;
    transition: background .2s ease, color .2s ease;
}

.activities-admin-action a:hover {
    color: #082d49;
    background: #ffd27a;
    border-color: #ffd27a;
}

.activities-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 24px;
}

.activities-more-action {
    margin-top: 32px;
    text-align: center;
}

.activities-more-link {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 11px 22px;
    border: 1px solid #ffd27a;
    border-radius: 24px;
    color: #082d49;
    background: #ffd27a;
    font-weight: 800;
    text-decoration: none;
    transition: color .2s ease, background .2s ease, transform .2s ease;
}

.activities-more-link:hover {
    color: #fff;
    background: #0c5077;
    text-decoration: none;
    transform: translateY(-2px);
}

.activity-feature-card {
    position: relative;
    height: 270px;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, .16);
    border-radius: 18px;
    background: #092a43;
    box-shadow: 0 18px 42px rgba(0, 0, 0, .2);
    transition: transform .25s ease, box-shadow .25s ease;
}

.activity-feature-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 24px 48px rgba(0, 0, 0, .3);
}

.activity-feature-image {
    position: absolute;
    inset: 0;
    overflow: hidden;
    background: #dce7ee;
}

.activity-feature-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .45s ease;
}

.activity-feature-card:hover .activity-feature-image img {
    transform: scale(1.05);
}

.activity-admin-controls {
    position: absolute;
    z-index: 2;
    top: 12px;
    right: 12px;
}

@media (max-width: 767.98px) {
    .logos-activities-section {
        padding: 64px 0 48px;
    }

    .activities-heading {
        margin-bottom: 30px;
    }

    .activity-feature-card {
        height: 250px;
    }
}

@media (max-width: 991.98px) {
    .activities-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 575.98px) {
    .activities-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- Activities section start -->
<section class="logos-activities-section" aria-labelledby="logos-activities-title">
    <div class="container">
        <div class="activities-heading">
            <span class="activities-eyebrow">Campus life</span>
            <h2 id="logos-activities-title">Logos Activities</h2>
            <p>Explore the vibrant campus life and exciting student activities at Logos Institute of Foreign Language.</p>
            <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
            <div class="activities-admin-action">
                <a href="add_activity.php"><i class="fa fa-plus" aria-hidden="true"></i> ເພີ່ມກິດຈະກຳໃໝ່ (Add Activity)</a>
            </div>
            <?php endif; ?>
        </div>

        <div class="activities-grid">
            <?php foreach ($activity_cards as $act): ?>
            <article class="activity-feature-card">
                <?php if (isset($act['id'], $_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                <div class="activity-admin-controls btn-group btn-group-sm">
                    <a href="edit_activity.php?id=<?= htmlspecialchars((string) $act['id'], ENT_QUOTES, 'UTF-8'); ?>"
                        class="btn btn-warning" title="ແກ້ໄຂ">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                    <a href="delete_activity.php?id=<?= htmlspecialchars((string) $act['id'], ENT_QUOTES, 'UTF-8'); ?>"
                        class="btn btn-danger"
                        onclick="return confirm('ທ່ານຕ້ອງການລົບກິດຈະກຳນີ້ແທ້ບໍ?');" title="ລົບ">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </div>
                <?php endif; ?>
                <div class="activity-feature-image">
                    <img src="<?= htmlspecialchars($act['image'], ENT_QUOTES, 'UTF-8'); ?>"
                        alt="<?= htmlspecialchars($act['title'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <div class="activities-more-action">
            <a class="activities-more-link" href="Activities.php">
                Read More <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>
<!-- Activities section ends -->


<!-- ========================================== -->
<!-- 📌 TOP BUTTON & GRADIENT DIVIDER SECTION -->
<!-- ========================================== -->

<section class="course_section layout_padding">
    <div class="top-divider-container"
        style="position: relative; text-align: center; margin-top: 80px; margin-bottom: 25px;">
        <div style="height: 8px; background: linear-gradient(to right, #002b49, #6c757d, #dc3545); width: 100%;"></div>
        <a href="#" onclick="scrollToTop(event)"
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #002b49; color: #ffffff; width: 65px; height: 65px; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 4px 12px rgba(0,0,0,0.3); border: 2.5px solid #ffffff; font-size: 0.85rem; font-weight: bold; letter-spacing: 1px; transition: all 0.3s ease;">
            <i class="fa fa-angle-up" aria-hidden="true" style="font-size: 1.1rem; margin-bottom: -2px;"></i>
            <span>TOP</span>
        </a>
    </div>
</section>


<!-- Footer Section -->
<?php include __DIR__ . "/footer.php"; ?>

<!-- Holiday Announcement Modal -->
<div id="holidayNoticeModal" class="popup-modal" role="dialog" aria-modal="true"
    aria-labelledby="holidayNoticeModalTitle">
    <div class="popup-content">
        <button type="button" class="popup-close" onclick="closeHolidayNoticeModal()"
            aria-label="Close announcement">&times;</button>
        <h2 id="holidayNoticeModalTitle"><?= htmlspecialchars($holidayNoticeTitle, ENT_QUOTES, 'UTF-8'); ?></h2>
        <p><?= nl2br(htmlspecialchars($holidayNoticeBody, ENT_QUOTES, 'UTF-8')); ?></p>
        <?php if (!empty($holidayNoticeImages)): ?>
        <div class="holiday-notice-modal-images">
            <?php foreach ($holidayNoticeImages as $image): ?>
            <img src="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8'); ?>"
                alt="<?= htmlspecialchars($holidayNoticeTitle, ENT_QUOTES, 'UTF-8'); ?>" class="popup-poster-img">
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- CDN Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const navToggle = document.querySelector(".navbar-toggler");
    const navMenu = document.getElementById("navbarSupportedContent");
    if (navToggle && navMenu) {
        navToggle.addEventListener("click", function() {
            const expanded = navToggle.getAttribute("aria-expanded") === "true";
            navToggle.setAttribute("aria-expanded", String(!expanded));
            navMenu.classList.toggle("show", !expanded);
        });
    }

    document.querySelectorAll(".quote_btn-container .dropdown-toggle").forEach(function(toggle) {
        toggle.addEventListener("click", function(event) {
            event.preventDefault();
            const menu = toggle.nextElementSibling;
            if (menu) {
                menu.classList.toggle("show");
            }
        });
    });
});

function openHolidayNoticeModal() {
    document.getElementById('holidayNoticeModal').style.display = 'flex';
}

function closeHolidayNoticeModal() {
    document.getElementById('holidayNoticeModal').style.display = 'none';
}

window.onclick = function(event) {
    var modal = document.getElementById('holidayNoticeModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

document.addEventListener("keydown", function(event) {
    if (event.key === "Escape") {
        closeHolidayNoticeModal();
    }
});

// ฟังก์ชันเลື່ອນหน้าจอขึ้นด้านบนสุดอย่างนุ่มนวล
function scrollToTop(event) {
    event.preventDefault();
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

/* 📌 JavaScript ຈັດການ Active Menu ແລະ Underline ໃຫ້ຖືກຕ້ອງອັດຕະໂນມັດທຸກໜ້າ */
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