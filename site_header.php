<?php
$currentPage = strtolower(basename($_SERVER['PHP_SELF'] ?? ''));
$activePage = 'home';
$publicPages = [
    'index.php', 'about.php',
    'course.php', 'course_detail.php',
    'activities.php', 'news.php', 'festival.php', 'english speaking contest.php',
    'regulations.php', 'documents.php', 'documents .php',
    'updating.php', 'english study.php', 'chinese study.php',
    'korean study.php', 'computer science.php', 'exam1.php'
];
$isPublicPage = in_array($currentPage, $publicPages, true);

if ($currentPage === 'about.php') {
    $activePage = 'about';
} elseif (in_array($currentPage, ['course.php', 'course_detail.php'], true)) {
    $activePage = 'programs';
} elseif ($currentPage === 'activities.php') {
    $activePage = 'activities';
} elseif ($currentPage === 'news.php') {
    $activePage = 'news';
} elseif (in_array($currentPage, ['regulations.php', 'documents.php', 'documents .php'], true)) {
    $activePage = 'documents';
}
?>
<style>
    .site-header {
        position: fixed;
        z-index: 9999;
        top: 0;
        right: 0;
        left: 0;
        color: #17364b;
        background: rgba(255, 255, 255, .98);
        border-bottom: 1px solid rgba(14, 54, 80, .1);
        box-shadow: 0 8px 26px rgba(13, 39, 57, .09);
        font-family: Poppins, "Phetsarath OT", sans-serif;
    }

    .site-header *,
    .site-header *::before,
    .site-header *::after {
        box-sizing: border-box;
    }

    .site-header-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 22px;
        width: min(100% - 48px, 1440px);
        min-height: 82px;
        margin: 0 auto;
    }

    .site-brand {
        display: flex;
        flex: 0 1 270px;
        align-items: center;
        min-width: 185px;
    }

    .site-brand img {
        display: block;
        width: 100%;
        max-width: 270px;
        height: auto;
    }

    .site-header .custom_nav-container {
        display: flex;
        flex: 1 1 auto;
        align-items: center;
        justify-content: center;
        min-width: 0;
    }

    .site-header .navbar-nav {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 2px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .site-header .navbar-nav .nav-link {
        position: relative;
        display: block;
        padding: 12px 11px;
        color: #415665;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.4;
        text-decoration: none;
        white-space: nowrap;
        transition: color .2s ease;
    }

    .site-header .navbar-nav .nav-link::after {
        position: absolute;
        right: 11px;
        bottom: 4px;
        left: 11px;
        height: 2px;
        background: #e4a126;
        border-radius: 2px;
        content: "";
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .2s ease;
    }

    .site-header .navbar-nav .nav-link:hover,
    .site-header .navbar-nav .nav-item.active .nav-link {
        color: #07395a;
    }

    .site-header .navbar-nav .nav-link:hover::after,
    .site-header .navbar-nav .nav-item.active .nav-link::after {
        transform: scaleX(1);
    }

    .site-header-actions {
        display: flex;
        flex: 0 0 auto;
        align-items: center;
        gap: 12px;
    }

    .site-header .site-apply-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 0 17px;
        color: #fff;
        background: #0a3b5d;
        border: 1px solid #0a3b5d;
        border-radius: 24px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        transition: background .2s ease, transform .2s ease;
    }

    .site-header .site-apply-link:hover {
        color: #fff;
        background: #145579;
        transform: translateY(-1px);
    }

    .site-header .site-login-link {
        color: #355267;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
    }

    .site-header .site-login-link:hover {
        color: #0a3b5d;
    }

    .site-header-toggle {
        display: none;
        width: 42px;
        height: 42px;
        padding: 10px;
        color: #0a3b5d;
        background: #f2f6f8;
        border: 1px solid #dce6eb;
        border-radius: 50%;
        cursor: pointer;
    }

    .site-header-toggle span {
        display: block;
        height: 2px;
        margin: 4px 0;
        background: currentColor;
        border-radius: 2px;
    }

    .site-header-spacer {
        height: 82px;
    }

    html[lang="la"] .site-header,
    html[lang="la"] .site-header .nav-link,
    html[lang="la"] .site-header-actions,
    html[lang="la"] .site-language-switcher {
        font-family: "Phetsarath OT", "Phetsarath", sans-serif;
    }

    html[lang="ko"] .site-header,
    html[lang="ko"] .site-header .nav-link,
    html[lang="ko"] .site-header-actions,
    html[lang="ko"] .site-language-switcher {
        font-family: "Malgun Gothic", "Apple SD Gothic Neo", system-ui, sans-serif;
    }

    html[lang="zh"] .site-header,
    html[lang="zh"] .site-header .nav-link,
    html[lang="zh"] .site-header-actions,
    html[lang="zh"] .site-language-switcher {
        font-family: "Microsoft YaHei", "PingFang SC", system-ui, sans-serif;
    }

    body > .hero_area > .header_section,
    body > .header_section,
    body .hero_area header.header_section {
        display: none !important;
    }

    @media (max-width: 1100px) {
        .site-header-inner {
            gap: 12px;
            width: calc(100% - 32px);
        }

        .site-brand {
            flex-basis: 210px;
            min-width: 155px;
        }

        .site-header .navbar-nav .nav-link {
            padding-right: 7px;
            padding-left: 7px;
            font-size: 12px;
        }

        .site-header .navbar-nav .nav-link::after {
            right: 7px;
            left: 7px;
        }

        .site-header .site-apply-link {
            padding: 0 12px;
        }
    }

    @media (max-width: 1250px) {
        .site-header-inner {
            position: relative;
            min-height: 72px;
        }

        .site-brand {
            flex: 0 1 230px;
        }

        .site-header-toggle {
            display: block;
            order: 3;
        }

        .site-header .custom_nav-container {
            position: absolute;
            top: 100%;
            right: -16px;
            left: -16px;
            display: none;
            padding: 10px 20px 16px;
            background: #fff;
            border-top: 1px solid #edf1f3;
            box-shadow: 0 12px 20px rgba(13, 39, 57, .1);
        }

        .site-header .custom_nav-container.is-open {
            display: block;
        }

        .site-header .navbar-nav {
            align-items: stretch;
            flex-direction: column;
        }

        .site-header .navbar-nav .nav-link {
            padding: 11px 8px;
            font-size: 14px;
        }

        .site-header .navbar-nav .nav-link::after {
            right: auto;
            bottom: 4px;
            left: 8px;
            width: 36px;
        }

        .site-header-actions {
            margin-left: auto;
        }

        .site-header-spacer {
            height: 72px;
        }
    }

    @media (max-width: 480px) {
        .site-header-inner {
            width: calc(100% - 24px);
            gap: 8px;
        }

        .site-brand {
            flex-basis: 165px;
            min-width: 120px;
        }

        .site-header-actions {
            gap: 7px;
        }

        .site-header .site-apply-link {
            min-height: 38px;
            padding: 0 10px;
            font-size: 11px;
        }
    }
</style>

<header class="site-header">
    <div class="site-header-inner">
        <a class="site-brand" href="index.php" aria-label="Logos Institute home">
            <img src="images/logo.png" alt="Logos Institute of Foreign Language">
        </a>

        <nav class="custom_nav-container" id="site-main-navigation" aria-label="Main navigation">
            <ul class="navbar-nav">
                <li class="nav-item<?php echo $activePage === 'home' ? ' active' : ''; ?>"><a class="nav-link" href="index.php">HOME</a></li>
                <li class="nav-item<?php echo $activePage === 'about' ? ' active' : ''; ?>"><a class="nav-link" href="about.php">ABOUT IFL</a></li>
                <li class="nav-item<?php echo $activePage === 'programs' ? ' active' : ''; ?>"><a class="nav-link" href="course.php">PROGRAMS</a></li>
                <li class="nav-item<?php echo $activePage === 'activities' ? ' active' : ''; ?>"><a class="nav-link" href="Activities.php">Activities</a></li>
                <li class="nav-item<?php echo $activePage === 'news' ? ' active' : ''; ?>"><a class="nav-link" href="NEWS.php">NEWS</a></li>
                <li class="nav-item<?php echo $activePage === 'documents' ? ' active' : ''; ?>"><a class="nav-link" href="Regulations.php">RESOURCES</a></li>
            </ul>
        </nav>

        <div class="site-header-actions">
            <?php include_once __DIR__ . '/language_switcher.php'; ?>
            <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                <a class="site-login-link" id="site-login-link" href="logout.php" data-label="logout">Logout</a>
            <?php else: ?>
                <a class="site-login-link" id="site-login-link" href="login.php" data-label="login">Staff Login</a>
            <?php endif; ?>
            <a class="site-apply-link" id="site-apply-link" href="index_register.php" data-label="apply">Apply Now</a>
        </div>

        <button class="site-header-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false" aria-controls="site-main-navigation">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>
<div class="site-header-spacer" aria-hidden="true"></div>
<script>
    (function () {
        var toggle = document.querySelector('.site-header-toggle');
        var navigation = document.getElementById('site-main-navigation');
        if (!toggle || !navigation) return;

        toggle.addEventListener('click', function () {
            var isOpen = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', String(!isOpen));
            navigation.classList.toggle('is-open', !isOpen);
        });
    })();
</script>
<?php if ($isPublicPage): ?>
<script>document.body.classList.add('site-content-page');</script>
<?php endif; ?>
