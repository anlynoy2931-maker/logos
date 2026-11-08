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

// --- 2. ດຶງຂໍ້ມູນ dynamic ຈາກຕາຕະລາງ website_courses (Curriculum) ---
$sql = "SELECT * FROM website_courses";
$result = $conn->query($sql);

$curriculums = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['title'] = site_localized_value($row, 'course_name', $current_lang);
        $row['description'] = site_localized_value($row, 'description', $current_lang);
        $row['link'] = $row['detail_link'];
        $curriculums[] = $row;
    }
}

// --- 3. ດຶງຂໍ້ມູນ dynamic ຈາກຕາຕະລາງ website_activities (Activities) ---
$sql_act = "SELECT * FROM website_activities ORDER BY id DESC";
$result_act = $conn->query($sql_act);

$activities = [];
if ($result_act && $result_act->num_rows > 0) {
    while ($row_act = $result_act->fetch_assoc()) {
        $row_act['title'] = site_localized_value($row_act, 'title', $current_lang);
        $row_act['description'] = site_localized_value($row_act, 'description', $current_lang);
        $row_act['link'] = $row_act['detail_link'];
        $activities[] = $row_act;
    }
}

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

<!-- Festival Section -->
<section class="about_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="img-box">
                    <a href="#posterModal" onclick="openPosterModal(event)" aria-label="View festival poster">
                        <img src="images/Festival 7-02.png" alt="Festival" class="img-fluid">
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-box">
                    <div class="heading_container">
                        <h2>LOGOS festival 2026</h2>
                    </div>
                    <p>
                        ບຸນມະໂຫລານໂລໂກສແມ່ນຈັດຂຶ້ນເພື່ອເປັນ ພິທີສະເຫຼີມສະຫຼອງວັນຄົບຮອບສະຖານການສຶກສາ ໂລໂກສ
                        ເລີ່ມຈັດຕັ້ງປະຕິບັດຢ່າງເປັນຮູບປະທໍາຕັ້ງແຕ່ ປີ 2016 ເປັນຕົ້ນມາ...
                    </p>
                    <a href="Festival.php">Read More</a>
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
                        Logos Institute was originally established in 2001 as the Logos Academy Center...
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
                ຫຼັກສູດການສຶກສາປະລິນຍາຕີ ຂອງສະຖາບັນ ໂລໂກສ
            </p>

            <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
            <div class="mt-3 text-center">
                <a href="add_course.php" class="btn btn-success"
                    style="border-radius: 20px; padding: 8px 20px; box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);">
                    <i class="fa fa-plus"></i> ເພີ່ມຫຼັກສູດໃໝ່ (Add New Course)
                </a>
            </div>
            <?php endif; ?>
        </div>

        <div class="row">
            <?php if (!empty($curriculums)): ?>
            <?php foreach ($curriculums as $item): ?>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <div class="card-item shadow-lg"
                    style="position: relative; background: rgba(255, 255, 255, 0.95); border-radius: 12px; overflow: hidden; height: 100%; display: flex; flex-direction: column; backdrop-filter: blur(5px);">

                    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                    <div style="position: absolute; top: 10px; right: 10px; z-index: 10;"
                        class="btn-group btn-group-sm">
                        <a href="edit_course.php?id=<?= $item['id']; ?>" class="btn btn-warning" title="ແກ້ໄຂ">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="delete_course.php?id=<?= $item['id']; ?>" class="btn btn-danger"
                            onclick="return confirm('ທ່ານຕ້ອງການລົບຫຼັກສູດນີ້ແທ້ບໍ?');" title="ລົບ">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                    <?php endif; ?>

                    <div class="img-box" style="height: 180px; width: 100%; overflow: hidden;">
                        <img src="<?= htmlspecialchars($item['image']); ?>"
                            alt="<?= htmlspecialchars($item['title']); ?>"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <div class="detail-box p-3 text-center"
                        style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <h4
                                style="font-size: 1.1rem; font-weight: 600; color: #002b49; margin-bottom: 10px; min-height: 2.6rem; display: flex; align-items: center; justify-content: center;">
                                <?= htmlspecialchars($item['title']); ?>
                            </h4>
                            <p
                                style="font-size: 0.88rem; color: #555; height: 3.6rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; margin-bottom: 15px;">
                                <?= htmlspecialchars($item['description']); ?>
                            </p>
                        </div>
                        <div>
                            <a href="<?= htmlspecialchars($item['link']); ?>" class="btn btn-primary btn-sm"
                                style="background-color: #002b49; border: none; border-radius: 20px; padding: 6px 20px;">
                                View Detail
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12 text-center py-4">
                <p class="text-white">ບໍ່ມີຂໍ້ມູນຫຼັກສູດໃນຂະນະນີ້</p>
            </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<!-- Activities section start -->
<section class="course_section layout_padding">
    <div class="container">
        <div class="heading_container text-center mb-4" style="align-items: center; text-align: center;">
            <h2
                style="font-weight: 800; color: #002b49; text-transform: uppercase; font-size: 2.8rem; letter-spacing: 2px; margin: 0 auto; text-align: center;">
                Logos Activities
            </h2>

            <p class="text-muted" style="font-size: 0.95rem; margin-top: 10px; text-align: center;">
                ກິດຈະກຳ ແລະ ສະໂມສອນຕ່າງໆ ຂອງສະຖາບັນ ໂລໂກສ
            </p>

            <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
            <div class="mt-3 text-center">
                <a href="add_activity.php" class="btn btn-success"
                    style="border-radius: 20px; padding: 8px 20px; box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);">
                    <i class="fa fa-plus"></i> ເພີ່ມກິດຈະກຳໃໝ່ (Add Activity)
                </a>
            </div>
            <?php endif; ?>
        </div>

        <div class="course_owl-carousel owl-carousel owl-theme">
            <?php if (!empty($activities)): ?>
            <?php foreach ($activities as $act): ?>
            <div class="item">
                <div class="card-item shadow-sm"
                    style="position: relative; background: #fff; border-radius: 10px; overflow: hidden; margin-bottom: 15px;">

                    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                    <div style="position: absolute; top: 10px; right: 10px; z-index: 10;"
                        class="btn-group btn-group-sm">
                        <a href="edit_activity.php?id=<?= $act['id']; ?>" class="btn btn-warning" title="ແກ້ໄຂ">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="delete_activity.php?id=<?= $act['id']; ?>" class="btn btn-danger"
                            onclick="return confirm('ທ່ານຕ້ອງການລົບກິດຈະກຳນີ້ແທ້ບໍ?');" title="ລົບ">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                    <?php endif; ?>

                    <div class="img-box" style="height: 200px; overflow: hidden;">
                        <img src="<?= htmlspecialchars($act['image']); ?>" alt="<?= htmlspecialchars($act['title']); ?>"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <div class="detail-box p-3 text-center">
                        <h4
                            style="font-size: 1.15rem; font-weight: 600; color: #002b49; margin-bottom: 10px; min-height: 2.5rem; display: flex; align-items: center; justify-content: center;">
                            <?= htmlspecialchars($act['title']); ?>
                        </h4>
                        <p
                            style="font-size: 0.88rem; color: #666; height: 3.6rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; margin-bottom: 15px;">
                            <?= htmlspecialchars($act['description']); ?>
                        </p>
                        <a href="<?= !empty($act['link']) ? htmlspecialchars($act['link']) : 'updating.php'; ?>"
                            class="btn btn-primary btn-sm"
                            style="background-color: #002b49; border: none; border-radius: 20px; padding: 6px 20px;">
                            View Detail
                        </a>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12 text-center py-4">
                <p class="text-muted">ບໍ່ມີຂໍ້ມູນກິດຈະກຳໃນຂະນະນີ້</p>
            </div>
            <?php endif; ?>
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


<!-- Contact Section -->
<section class="contact_section layout_padding" style="background-color: #0b2519; color: #ffffff;">
    <div class="container">
        <div class="heading_container text-center mb-5">
            <h2 style="color: #ffffff;">Maps</h2>
        </div>

        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="map_container"
                    style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3794.780105905844!2d102.63083141024914!3d17.98896468512677!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x312467e8718562d9%3A0x6e84fd1e2e235b0e!2sLogos%20Institute%20of%20Foreign%20Language%20(LIFL)!5e0!3m2!1sth!2sla!4v1773388410171!5m2!1sth!2sla"
                        width="100%" height="320" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

            <div class="col-md-6 pl-lg-5">
                <div class="contact_info">
                    <h3 style="font-weight: 700; font-size: 1.5rem; margin-bottom: 20px; color: #ffffff;">
                        CONTACT US
                    </h3>

                    <div class="d-flex align-items-start mb-3">
                        <i class="fa fa-map-marker" aria-hidden="true"
                            style="font-size: 1.5rem; margin-right: 15px; width: 20px; text-align: center; color: #ffffff;"></i>
                        <div>
                            <strong style="display: block;">Location: Phonpanao Road</strong>
                            <span>Hom 15 Phonphanao, Vientiane, Laos</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-phone" aria-hidden="true"
                            style="font-size: 1.3rem; margin-right: 15px; width: 20px; text-align: center; color: #ffffff;"></i>
                        <div>
                            <span>Call : +8562092362524</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <i class="fa fa-envelope" aria-hidden="true"
                            style="font-size: 1.2rem; margin-right: 15px; width: 20px; text-align: center; color: #ffffff;"></i>
                        <div>
                            <span>Email : logosinstitute.fl.edu@gmail.com</span>
                        </div>
                    </div>

                    <div class="social_box mt-4 pt-3" style="border-top: 1px solid rgba(255,255,255,0.2);">
                        <h5 style="font-weight: 700; font-size: 1.1rem; margin-bottom: 15px; letter-spacing: 1px;">LOGOS
                            INSTITUTE</h5>
                        <div class="d-flex gap-2">
                            <a href="#"
                                style="width: 38px; height: 38px; border: 1.5px solid #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ffffff; text-decoration: none; margin-right: 10px;">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                            <a href="#"
                                style="width: 38px; height: 38px; border: 1.5px solid #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ffffff; text-decoration: none; margin-right: 10px;">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                            <a href="#"
                                style="width: 38px; height: 38px; border: 1.5px solid #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ffffff; text-decoration: none; margin-right: 10px;">
                                <i class="fa fa-linkedin" aria-hidden="true"></i>
                            </a>
                            <a href="#"
                                style="width: 38px; height: 38px; border: 1.5px solid #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ffffff; text-decoration: none;">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
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
            &copy; <?php echo date('Y'); ?> Logos institute
        </p>
    </div>
</footer>

<!-- Poster Modal -->
<div id="posterModal" class="popup-modal">
    <div class="popup-content">
        <button type="button" class="popup-close" onclick="closePosterModal()" aria-label="Close poster">&times;</button>
        <img src="images/Festival 7-02.png" alt="LOGOS FESTIVAL" class="popup-poster-img">
        <div class="popup-actions mt-3">
            <a href="Festival.php" class="btn btn-primary">Read More</a>
        </div>
    </div>
</div>

<!-- CDN Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (window.jQuery && jQuery.fn.owlCarousel) {
        jQuery(".course_owl-carousel").owlCarousel({
            loop: true,
            margin: 20,
            nav: false,
            dots: true,
            autoplay: true,
            autoplayTimeout: 3000,
            responsive: {
                0: { items: 1 },
                600: { items: 2 },
                1000: { items: 3 }
            }
        });
    }

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

function openPosterModal(event) {
    event.preventDefault();
    document.getElementById('posterModal').style.display = 'flex';
}

function closePosterModal() {
    document.getElementById('posterModal').style.display = 'none';
}

window.onclick = function(event) {
    var modal = document.getElementById('posterModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

document.addEventListener("keydown", function(event) {
    if (event.key === "Escape") {
        closePosterModal();
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