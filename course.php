<?php
session_start();
$current_lang = isset($_GET['lang']) && $_GET['lang'] === 'la' ? 'la' : 'en';
$page_text = [
    'en' => [
        'hero_title' => 'Find the program that moves you forward.',
        'hero_description' => 'Explore degree programs, focused language courses, and Lao language learning for international students.',
        'explore_programs' => 'Explore programs',
        'lao_for_international' => 'Lao for international learners',
        'eyebrow' => 'Learn. Connect. Grow.',
        'intro_title' => 'Programs for your next chapter',
        'intro_description' => 'Choose a bachelor’s degree, build a specific language skill, or learn Lao for everyday life and communication in Laos.',
        'bachelor_link' => 'Bachelor’s degrees',
        'special_link' => 'Special language courses',
        'lao_link' => 'Lao Language',
        'undergraduate' => 'Undergraduate programs',
        'bachelor_title' => 'Bachelor’s degrees',
        'bachelor_description' => 'Build a strong foundation in language, communication, or computer science.',
        'bachelor_label' => 'Bachelor’s degree',
        'topics_label' => 'What you can explore',
        'special_eyebrow' => 'Focused learning',
        'special_title' => 'Special language courses',
        'special_description' => 'Practical, goal-focused learning for communication and language-test preparation.',
        'course_focus' => 'Course focus',
        'learn_more' => 'Learn more',
        'international_eyebrow' => 'For international learners',
        'lao_title' => 'LAO Language',
        'lao_subtitle' => 'Lao for everyday life in Laos',
        'lao_description' => 'Learn useful Lao step by step, practise real-life conversations, and discover the culture behind the language. The course can be discussed around your current level and learning goals.',
        'learn_in_course' => 'What you can learn',
        'who_for' => 'Who it is for',
        'ask_course' => 'Ask about the course',
        'call_us' => 'Call us',
        'lao_gallery' => 'Lao culture and student activities',
        'gallery_captions' => ['Discover Lao culture and traditions', 'Learn through cultural experiences', 'Connect language with local life'],
        'institute' => 'Logos Institute of Foreign Language',
        'tagline' => 'Learn a language. Open your world.',
        'contact_admissions' => 'Contact admissions',
        'address' => 'Phonpanao Road, Hom 15 Phonphanao, Vientiane, Laos',
        'open_maps' => 'Open directions in Google Maps',
        'directions_title' => 'Map showing Logos Institute of Foreign Language in Vientiane',
        'copyright' => 'Logos Institute of Foreign Language'
    ],
    'la' => [
        'hero_title' => 'ເລືອກຫຼັກສູດທີ່ພາທ່ານກ້າວໄປຂ້າງໜ້າ',
        'hero_description' => 'ຄົ້ນຫາຫຼັກສູດປະລິນຍາຕີ, ຫຼັກສູດພາສາສະເພາະດ້ານ ແລະ ຫຼັກສູດພາສາລາວສຳລັບຊາວຕ່າງປະເທດ',
        'explore_programs' => 'ເບິ່ງຫຼັກສູດ',
        'lao_for_international' => 'ພາສາລາວສຳລັບຊາວຕ່າງປະເທດ',
        'eyebrow' => 'ຮຽນຮູ້. ເຊື່ອມສານ. ເຕີບໂຕ.',
        'intro_title' => 'ຫຼັກສູດສຳລັບກ້າວຕໍ່ໄປຂອງທ່ານ',
        'intro_description' => 'ເລືອກຮຽນປະລິນຍາຕີ, ພັດທະນາທັກສະພາສາ ຫຼື ຮຽນພາສາລາວເພື່ອການສື່ສານໃນຊີວິດປະຈຳວັນ',
        'bachelor_link' => 'ຫຼັກສູດປະລິນຍາຕີ',
        'special_link' => 'ຫຼັກສູດພາສາພິເສດ',
        'lao_link' => 'ພາສາລາວ',
        'undergraduate' => 'ຫຼັກສູດລະດັບປະລິນຍາຕີ',
        'bachelor_title' => 'ຫຼັກສູດປະລິນຍາຕີ',
        'bachelor_description' => 'ສ້າງພື້ນຖານດ້ານພາສາ, ການສື່ສານ ຫຼື ວິທະຍາສາດຄອມພິວເຕີ',
        'bachelor_label' => 'ລະດັບປະລິນຍາຕີ',
        'topics_label' => 'ສິ່ງທີ່ຈະໄດ້ຮຽນ',
        'special_eyebrow' => 'ການຮຽນຮູ້ສະເພາະດ້ານ',
        'special_title' => 'ຫຼັກສູດພາສາພິເສດ',
        'special_description' => 'ຝຶກທັກສະເພື່ອການສື່ສານ ແລະ ກຽມຄວາມພ້ອມສຳລັບການສອບເສັງພາສາ',
        'course_focus' => 'ເນື້ອໃນຫຼັກສູດ',
        'learn_more' => 'ລາຍລະອຽດເພີ່ມເຕີມ',
        'international_eyebrow' => 'ສຳລັບຜູ້ຮຽນຊາວຕ່າງປະເທດ',
        'lao_title' => 'ຫຼັກສູດພາສາລາວ',
        'lao_subtitle' => 'ພາສາລາວເພື່ອຊີວິດປະຈຳວັນໃນປະເທດລາວ',
        'lao_description' => 'ຮຽນພາສາລາວທີລະຂັ້ນ, ຝຶກສົນທະນາຈາກສະຖານະການຈິງ ແລະ ຮຽນຮູ້ວັດທະນະທຳລາວ. ເນື້ອໃນສາມາດປັບໃຫ້ເໝາະກັບລະດັບ ແລະ ເປົ້າໝາຍຂອງຜູ້ຮຽນ',
        'learn_in_course' => 'ສິ່ງທີ່ຈະໄດ້ຮຽນ',
        'who_for' => 'ເໝາະສຳລັບໃຜ',
        'ask_course' => 'ສອບຖາມຫຼັກສູດ',
        'call_us' => 'ໂທຫາພວກເຮົາ',
        'lao_gallery' => 'ວັດທະນະທຳລາວ ແລະ ກິດຈະກຳນັກສຶກສາ',
        'gallery_captions' => ['ຄົ້ນພົບວັດທະນະທຳ ແລະ ປະເພນີລາວ', 'ຮຽນຮູ້ຜ່ານປະສົບການທາງວັດທະນະທຳ', 'ເຊື່ອມໂຍງພາສາກັບຊີວິດປະຈຳວັນ'],
        'institute' => 'ສະຖາບັນໂລໂກສ ພາສາຕ່າງປະເທດ',
        'tagline' => 'ຮຽນຮູ້ພາສາ. ເປີດໂລກຂອງທ່ານ.',
        'contact_admissions' => 'ຕິດຕໍ່ຝ່າຍຮັບສະໝັກ',
        'address' => 'ຖະໜົນໂພນພະເນົາ, ບ້ານໂພນພະເນົາ ໜ່ວຍ 15, ນະຄອນຫຼວງວຽງຈັນ',
        'open_maps' => 'ເປີດເບິ່ງເສັ້ນທາງໃນ Google Maps',
        'directions_title' => 'ແຜນທີ່ສະຖາບັນໂລໂກສ ພາສາຕ່າງປະເທດ ໃນນະຄອນຫຼວງວຽງຈັນ',
        'copyright' => 'ສະຖາບັນໂລໂກສ ພາສາຕ່າງປະເທດ'
    ]
];
$text = $page_text[$current_lang];

$bachelor_programs = [
    [
        'title' => 'Bachelor of Arts in English Studies',
        'image' => 'images/englishS (1).jpg',
        'alt' => 'English Studies graduates',
        'description' => 'Build confident English communication and a strong foundation for study, work, and international opportunities.',
        'description_la' => 'ພັດທະນາທັກສະພາສາອັງກິດຮອບດ້ານ ເພື່ອການສື່ສານ, ການສຶກສາ ແລະ ໂອກາດການເຮັດວຽກ',
        'topics' => ['Speaking, listening, reading, and writing', 'Academic English and communication', 'Language, literature, and culture'],
        'topics_la' => ['ການເວົ້າ, ການຟັງ, ການອ່ານ ແລະ ການຂຽນ', 'ພາສາອັງກິດວິຊາການ ແລະ ການສື່ສານ', 'ພາສາ, ວັນນະຄະດີ ແລະ ວັດທະນະທຳ'],
        'link' => 'english%20study.php',
        'link_label' => 'Explore English Studies',
        'icon' => 'fa-comments'
    ],
    [
        'title' => 'Bachelor of Arts in Korean Studies',
        'image' => 'images/KoreanS1.jpg',
        'alt' => 'Korean Studies program',
        'description' => 'Learn Korean language and explore the culture and communication skills used in real-life settings.',
        'description_la' => 'ຮຽນພາສາເກົາຫຼີ ພ້ອມສຳຜັດວັດທະນະທຳ ແລະ ຝຶກທັກສະການສື່ສານໃນສະຖານະການຈິງ',
        'topics' => ['Korean speaking, listening, reading, and writing', 'Korean grammar and practical conversation', 'Korean society and culture'],
        'topics_la' => ['ການເວົ້າ, ການຟັງ, ການອ່ານ ແລະ ການຂຽນພາສາເກົາຫຼີ', 'ໄວຍາກອນ ແລະ ການສົນທະນາພາກປະຕິບັດ', 'ສັງຄົມ ແລະ ວັດທະນະທຳເກົາຫຼີ'],
        'link' => 'Korean%20study.php',
        'link_label' => 'Explore Korean Studies',
        'icon' => 'fa-language'
    ],
    [
        'title' => 'Bachelor of Arts in Chinese Studies',
        'image' => 'images/Chinese1.jpg',
        'alt' => 'Chinese Studies program',
        'description' => 'Develop Chinese language skills and cultural understanding for communication, further study, and work.',
        'description_la' => 'ພັດທະນາທັກສະພາສາຈີນ ແລະ ຄວາມເຂົ້າໃຈດ້ານວັດທະນະທຳ ເພື່ອການສື່ສານ, ການຮຽນຕໍ່ ແລະ ການເຮັດວຽກ',
        'topics' => ['Mandarin pronunciation and tones', 'Speaking, listening, reading, and writing', 'Chinese communication and culture'],
        'topics_la' => ['ການອອກສຽງພາສາຈີນກາງ ແລະ ວັນນະຍຸດ', 'ການເວົ້າ, ການຟັງ, ການອ່ານ ແລະ ການຂຽນ', 'ການສື່ສານ ແລະ ວັດທະນະທຳຈີນ'],
        'link' => 'Chinese%20study.php',
        'link_label' => 'Explore Chinese Studies',
        'icon' => 'fa-language'
    ],
    [
        'title' => 'AI Computer Science',
        'image' => 'images/Language and computer science fusion.png',
        'alt' => 'Computer science and technology',
        'description' => 'Explore computing and artificial intelligence through problem-solving, digital skills, and practical projects.',
        'description_la' => 'ຮຽນຮູ້ດ້ານຄອມພິວເຕີ ແລະ ປັນຍາປະດິດ ຜ່ານການແກ້ໄຂບັນຫາ, ທັກສະດິຈິຕອນ ແລະ ໂຄງການພາກປະຕິບັດ',
        'topics' => ['Programming and computational thinking', 'Computer systems and software fundamentals', 'Introduction to AI and data-driven applications'],
        'topics_la' => ['ການຂຽນໂປຣແກຣມ ແລະ ການຄິດເຊິງຄຳນວນ', 'ພື້ນຖານລະບົບຄອມພິວເຕີ ແລະ ຊອບແວ', 'ຄວາມຮູ້ເບື້ອງຕົ້ນດ້ານ AI ແລະ ການນຳໃຊ້ຂໍ້ມູນ'],
        'link' => 'computer%20science.php',
        'link_label' => 'Explore Computer Science',
        'icon' => 'fa-laptop'
    ]
];

$special_programs = [
    [
        'title' => 'Special English',
        'eyebrow' => 'English for communication',
        'eyebrow_la' => 'ພາສາອັງກິດເພື່ອການສື່ສານ',
        'image' => 'images/englishS (1).jpg',
        'alt' => 'English language learning',
        'description' => 'Practical English practice for learners who want to communicate more confidently in everyday and work situations.',
        'description_la' => 'ຝຶກພາສາອັງກິດພາກປະຕິບັດ ເພື່ອເພີ່ມຄວາມໝັ້ນໃຈໃນການສື່ສານທັງຊີວິດປະຈຳວັນ ແລະ ການເຮັດວຽກ',
        'topics' => ['Speaking and listening practice', 'Useful vocabulary and pronunciation', 'Everyday and workplace communication'],
        'topics_la' => ['ຝຶກການເວົ້າ ແລະ ການຟັງ', 'ຄຳສັບທີ່ໃຊ້ຈິງ ແລະ ການອອກສຽງ', 'ການສື່ສານໃນຊີວິດປະຈຳວັນ ແລະ ບ່ອນເຮັດວຽກ'],
        'link' => 'english%20study.php',
        'icon' => 'fa-comments'
    ],
    [
        'title' => 'Chinese (HSK)',
        'eyebrow' => 'Chinese proficiency preparation',
        'eyebrow_la' => 'ກຽມຄວາມພ້ອມສອບວັດລະດັບພາສາຈີນ',
        'image' => 'images/Chinese1 (1).JPG',
        'alt' => 'Chinese language study',
        'description' => 'Chinese language study with vocabulary, listening, reading, and practice activities aligned with the learner’s HSK goal.',
        'description_la' => 'ຮຽນພາສາຈີນຜ່ານຄຳສັບ, ການຟັງ, ການອ່ານ ແລະ ແບບຝຶກຫັດ ໃຫ້ສອດຄ່ອງກັບເປົ້າໝາຍ HSK ຂອງຜູ້ຮຽນ',
        'topics' => ['Chinese vocabulary and characters', 'Listening and reading practice', 'HSK-style exercises for the selected level'],
        'topics_la' => ['ຄຳສັບ ແລະ ຕົວອັກສອນພາສາຈີນ', 'ຝຶກທັກສະການຟັງ ແລະ ການອ່ານ', 'ແບບຝຶກຫັດແນວ HSK ຕາມລະດັບທີ່ເລືອກ'],
        'link' => 'Chinese%20study.php',
        'icon' => 'fa-language'
    ],
    [
        'title' => 'Korean (EPS-TOPIK)',
        'eyebrow' => 'Korean test preparation',
        'eyebrow_la' => 'ກຽມຄວາມພ້ອມສອບພາສາເກົາຫຼີ',
        'image' => 'images/KoreanS1.jpg',
        'alt' => 'Korean language study',
        'description' => 'Build Korean foundations and practise language skills commonly used in EPS-TOPIK preparation.',
        'description_la' => 'ສ້າງພື້ນຖານພາສາເກົາຫຼີ ແລະ ຝຶກທັກສະພາສາທີ່ໃຊ້ໃນການກຽມສອບ EPS-TOPIK',
        'topics' => ['Hangul, vocabulary, and grammar foundations', 'Listening and reading practice', 'EPS-TOPIK-style exercises'],
        'topics_la' => ['ພື້ນຖານອັກສອນ Hangul, ຄຳສັບ ແລະ ໄວຍາກອນ', 'ຝຶກທັກສະການຟັງ ແລະ ການອ່ານ', 'ແບບຝຶກຫັດແນວ EPS-TOPIK'],
        'link' => 'Korean%20study.php',
        'icon' => 'fa-language'
    ]
];

$lao_gallery = [
    ['image' => 'images/IMG_5213.jpg', 'alt' => 'Students presenting Lao cultural traditions', 'alt_la' => 'ນັກສຶກສານຳສະເໜີປະເພນີວັດທະນະທຳລາວ'],
    ['image' => 'images/IMG_5217.jpg', 'alt' => 'Students performing at a cultural event', 'alt_la' => 'ນັກສຶກສາສະແດງໃນງານວັດທະນະທຳ'],
    ['image' => 'images/IMG_6656.jpg', 'alt' => 'Lao traditional dance performance', 'alt_la' => 'ການສະແດງຟ້ອນລຳປະເພນີລາວ']
];

include __DIR__ . '/header.php';
?>

<style>
    @font-face {
        font-family: "Phetsarath OT";
        src: url("fonts/Phetsarath-Regular.ttf") format("truetype");
        font-style: normal;
        font-weight: 400;
        font-display: swap;
    }

    @font-face {
        font-family: "Phetsarath OT";
        src: url("fonts/Phetsarath-Bold.ttf") format("truetype");
        font-style: normal;
        font-weight: 700 900;
        font-display: swap;
    }

    body.course-page,
    body.course-page button,
    body.course-page input,
    body.course-page select,
    body.course-page textarea {
        font-family: "Phetsarath OT", "Phetsarath", sans-serif;
    }

    .programs-page {
        --program-navy: #082d49;
        --program-blue: #164e73;
        --program-gold: #f0ad3d;
        --program-muted: #637486;
        padding-bottom: 0;
        background: #f5f8fb;
    }

    .programs-hero {
        position: relative;
        overflow: hidden;
        padding: 165px 0 90px;
        color: #fff;
        background:
            linear-gradient(110deg, rgba(5, 35, 57, .96), rgba(8, 45, 73, .86) 55%, rgba(8, 45, 73, .48)),
            url("images/logosss.jpg") center 45% / cover no-repeat;
    }

    .programs-hero::after {
        position: absolute;
        right: -110px;
        bottom: -240px;
        width: 460px;
        height: 460px;
        border: 1px solid rgba(255, 255, 255, .17);
        border-radius: 50%;
        content: "";
    }

    .programs-hero .container {
        position: relative;
        z-index: 1;
    }

    .programs-kicker {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 18px;
        color: #ffd17d;
        font-size: .9rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .programs-hero h1 {
        max-width: 800px;
        margin: 0 0 18px;
        color: #fff;
        font-size: clamp(2.4rem, 5vw, 4.2rem);
        font-weight: 800;
        line-height: 1.12;
    }

    .programs-hero p {
        max-width: 690px;
        margin-bottom: 28px;
        color: rgba(255, 255, 255, .85);
        font-size: 1.08rem;
    }

    .programs-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .programs-hero-actions a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 46px;
        padding: 10px 20px;
        border: 1px solid rgba(255, 255, 255, .55);
        border-radius: 25px;
        color: #fff;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .programs-hero-actions a:first-child {
        border-color: var(--program-gold);
        color: #182b3a;
        background: var(--program-gold);
    }

    .programs-hero-actions a:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }

    .programs-main {
        padding-top: 68px;
    }

    .programs-intro {
        max-width: 760px;
        margin: 0 auto 34px;
        text-align: center;
    }

    .programs-intro .eyebrow,
    .section-eyebrow {
        color: #b47815;
        font-size: .78rem;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .programs-intro h2,
    .section-heading h2 {
        margin: 8px 0 12px;
        color: var(--program-navy);
        font-size: clamp(1.8rem, 3vw, 2.45rem);
        font-weight: 800;
    }

    .programs-intro p,
    .section-heading p {
        margin: 0;
        color: var(--program-muted);
    }

    .program-jump-links {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        margin: 0 auto 55px;
    }

    .program-jump-links a {
        padding: 9px 16px;
        border: 1px solid #d5e0e9;
        border-radius: 22px;
        color: var(--program-navy);
        background: #fff;
        font-size: .92rem;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .program-jump-links a:hover {
        border-color: var(--program-navy);
        color: #fff;
        background: var(--program-navy);
    }

    .program-group {
        padding: 0 0 72px;
        scroll-margin-top: 95px;
    }

    .section-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 26px;
    }

    .section-heading p {
        max-width: 520px;
    }

    .program-card {
        height: 100%;
        overflow: hidden;
        border: 1px solid #e4ebf1;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 9px 28px rgba(8, 45, 73, .07);
        transition: transform .22s ease, box-shadow .22s ease;
    }

    .program-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 34px rgba(8, 45, 73, .14);
    }

    .program-card-image {
        position: relative;
        height: 205px;
        overflow: hidden;
        background: #dce8f0;
    }

    .program-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .35s ease;
    }

    .program-card:hover .program-card-image img {
        transform: scale(1.04);
    }

    .program-card-icon {
        position: absolute;
        right: 16px;
        bottom: -19px;
        display: grid;
        width: 48px;
        height: 48px;
        place-items: center;
        border: 4px solid #fff;
        border-radius: 50%;
        color: var(--program-navy);
        background: #ffd17d;
        font-size: 1.05rem;
    }

    .program-card-body {
        display: flex;
        flex-direction: column;
        min-height: 295px;
        padding: 24px 22px 22px;
    }

    .program-card-label {
        margin-bottom: 8px;
        color: #b47815;
        font-size: .73rem;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .program-card h3 {
        margin: 0 0 9px;
        color: var(--program-navy);
        font-size: 1.17rem;
        font-weight: 800;
        line-height: 1.4;
    }

    .program-card p {
        margin-bottom: 14px;
        color: var(--program-muted);
        font-size: .92rem;
    }

    .program-card details {
        margin: auto 0 14px;
        color: var(--program-blue);
    }

    .program-card summary {
        width: fit-content;
        color: var(--program-blue);
        font-size: .9rem;
        font-weight: 700;
        cursor: pointer;
    }

    .program-card ul,
    .lao-info-list {
        margin: 12px 0 0;
        padding-left: 20px;
        color: #526476;
        font-size: .88rem;
    }

    .program-card li,
    .lao-info-list li {
        margin-bottom: 6px;
    }

    .program-card-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        width: fit-content;
        color: var(--program-navy);
        font-size: .91rem;
        font-weight: 800;
        text-decoration: none;
    }

    .program-card-link:hover {
        color: #b47815;
        text-decoration: none;
    }

    .special-section {
        padding: 68px 0 72px;
        background: #eaf1f6;
    }

    .special-section .program-card-body {
        min-height: 315px;
    }

    .lao-section {
        padding: 72px 0 76px;
        scroll-margin-top: 90px;
        background: #fff;
    }

    .lao-feature {
        overflow: hidden;
        border: 1px solid #e5ebef;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 12px 38px rgba(8, 45, 73, .08);
    }

    .lao-feature-top {
        padding: clamp(24px, 4vw, 44px);
        background: linear-gradient(135deg, #f8f2e7, #fff 68%);
    }

    .lao-feature-top h3 {
        margin: 8px 0 12px;
        color: var(--program-navy);
        font-size: clamp(1.7rem, 3vw, 2.35rem);
        font-weight: 800;
        line-height: 1.25;
    }

    .lao-feature-top > p {
        max-width: 780px;
        color: #55687a;
    }

    .lao-content-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.1fr) minmax(280px, .9fr);
        gap: 28px;
        margin-top: 28px;
    }

    .lao-info-panel {
        padding: 22px;
        border: 1px solid #e6edf2;
        border-radius: 15px;
        background: rgba(255, 255, 255, .82);
    }

    .lao-info-panel h4 {
        margin: 0;
        color: var(--program-navy);
        font-size: 1.08rem;
        font-weight: 800;
    }

    .lao-info-list {
        padding-left: 22px;
        font-size: .94rem;
    }

    .lao-cta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
        margin-top: 21px;
    }

    .lao-cta a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        padding: 9px 17px;
        border: 1px solid var(--program-navy);
        border-radius: 24px;
        color: var(--program-navy);
        font-weight: 800;
        text-decoration: none;
    }

    .lao-cta a:first-child {
        color: #fff;
        background: var(--program-navy);
    }

    .lao-gallery {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        padding: 0 24px 26px;
    }

    .lao-gallery figure {
        overflow: hidden;
        margin: 0;
        border-radius: 13px;
        background: #edf2f5;
    }

    .lao-gallery img {
        display: block;
        width: 100%;
        height: 190px;
        object-fit: cover;
        transition: transform .3s ease;
    }

    .lao-gallery figure:hover img {
        transform: scale(1.04);
    }

    .lao-gallery figcaption {
        padding: 10px 12px;
        color: #526476;
        font-size: .82rem;
    }

    .programs-footer {
        padding: 48px 0 18px;
        color: #fff;
        background: #092d47;
    }

    .programs-footer h2 {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 800;
    }

    .programs-footer p {
        color: rgba(255, 255, 255, .78);
    }

    .programs-footer a {
        color: #ffd17d;
    }

    .programs-footer-map {
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, .2);
        border-radius: 14px;
        background: rgba(255, 255, 255, .08);
    }

    .programs-footer-map iframe {
        display: block;
        width: 100%;
        height: 300px;
        border: 0;
    }

    .programs-footer-bottom {
        margin-top: 28px;
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, .18);
        color: rgba(255, 255, 255, .7);
        font-size: .88rem;
        text-align: center;
    }

    @media (max-width: 767.98px) {
        .programs-hero {
            padding: 140px 0 65px;
        }

        .programs-main {
            padding-top: 48px;
        }

        .section-heading {
            display: block;
        }

        .lao-content-grid {
            grid-template-columns: 1fr;
        }

        .lao-gallery {
            grid-template-columns: 1fr;
        }

        .lao-gallery img {
            height: 230px;
        }

        .programs-footer-map iframe {
            height: 260px;
        }
    }
</style>

<main class="programs-page">
    <section class="programs-hero">
        <div class="container">
            <span class="programs-kicker"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <?= $text['institute']; ?></span>
            <h1><?= $text['hero_title']; ?></h1>
            <p><?= $text['hero_description']; ?></p>
            <div class="programs-hero-actions">
                <a href="#bachelor-programs"><?= $text['explore_programs']; ?> <i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                <a href="#lao-language"><?= $text['lao_for_international']; ?></a>
            </div>
        </div>
    </section>
    <div class="programs-main">
        <div class="container">
            <header class="programs-intro">
                <span class="eyebrow"><?= $text['eyebrow']; ?></span>
                <h2><?= $text['intro_title']; ?></h2>
                <p><?= $text['intro_description']; ?></p>
            </header>

            <nav class="program-jump-links" aria-label="Course categories">
                <a href="#bachelor-programs"><?= $text['bachelor_link']; ?></a>
                <a href="#special-programs"><?= $text['special_link']; ?></a>
                <a href="#lao-language"><?= $text['lao_link']; ?></a>
            </nav>

            <section id="bachelor-programs" class="program-group">
                <div class="section-heading">
                    <div>
                        <span class="section-eyebrow"><?= $text['undergraduate']; ?></span>
                        <h2><?= $text['bachelor_title']; ?></h2>
                        <p><?= $text['bachelor_description']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($bachelor_programs as $program): ?>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <article class="program-card">
                                <div class="program-card-image">
                                    <img src="<?= htmlspecialchars($program['image'], ENT_QUOTES, 'UTF-8'); ?>"
                                         alt="<?= htmlspecialchars($program['alt'], ENT_QUOTES, 'UTF-8'); ?>"
                                         loading="lazy">
                                    <span class="program-card-icon"><i class="fa <?= htmlspecialchars($program['icon'], ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i></span>
                                </div>
                                <div class="program-card-body">
                                    <span class="program-card-label"><?= $text['bachelor_label']; ?></span>
                                    <h3><?= htmlspecialchars($program['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <p><?= htmlspecialchars($current_lang === 'la' ? $program['description_la'] : $program['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <details>
                                        <summary><?= $text['topics_label']; ?></summary>
                                        <ul>
                                            <?php foreach ($current_lang === 'la' ? $program['topics_la'] : $program['topics'] as $topic): ?>
                                                <li><?= htmlspecialchars($topic, ENT_QUOTES, 'UTF-8'); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </details>
                                    <a class="program-card-link" href="<?= htmlspecialchars($program['link'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <?= $current_lang === 'la' ? 'ເບິ່ງສາຂາຮຽນ' : htmlspecialchars($program['link_label'], ENT_QUOTES, 'UTF-8'); ?>
                                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>

        <section id="special-programs" class="special-section program-group">
            <div class="container">
                <div class="section-heading">
                    <div>
                        <span class="section-eyebrow"><?= $text['special_eyebrow']; ?></span>
                        <h2><?= $text['special_title']; ?></h2>
                        <p><?= $text['special_description']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($special_programs as $program): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <article class="program-card">
                                <div class="program-card-image">
                                    <img src="<?= htmlspecialchars($program['image'], ENT_QUOTES, 'UTF-8'); ?>"
                                         alt="<?= htmlspecialchars($program['alt'], ENT_QUOTES, 'UTF-8'); ?>"
                                         loading="lazy">
                                    <span class="program-card-icon"><i class="fa <?= htmlspecialchars($program['icon'], ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i></span>
                                </div>
                                <div class="program-card-body">
                                    <span class="program-card-label"><?= htmlspecialchars($current_lang === 'la' ? $program['eyebrow_la'] : $program['eyebrow'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    <h3><?= htmlspecialchars($program['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <p><?= htmlspecialchars($current_lang === 'la' ? $program['description_la'] : $program['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <details>
                                        <summary><?= $text['course_focus']; ?></summary>
                                        <ul>
                                            <?php foreach ($current_lang === 'la' ? $program['topics_la'] : $program['topics'] as $topic): ?>
                                                <li><?= htmlspecialchars($topic, ENT_QUOTES, 'UTF-8'); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </details>
                                    <a class="program-card-link" href="<?= htmlspecialchars($program['link'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <?= $text['learn_more']; ?> <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="lao-language" class="lao-section">
            <div class="container">
                <div class="lao-feature">
                    <div class="lao-feature-top">
                        <span class="section-eyebrow"><?= $text['international_eyebrow']; ?></span>
                        <h3><?= $text['lao_title']; ?><br><?= $text['lao_subtitle']; ?></h3>
                        <p><?= $text['lao_description']; ?></p>

                        <div class="lao-content-grid">
                            <section class="lao-info-panel">
                                <h4><?= $text['learn_in_course']; ?></h4>
                                <ul class="lao-info-list">
                                    <?php if ($current_lang === 'la'): ?>
                                        <li>ສຽງ, ວັນນະຍຸດ, ການອອກສຽງ ແລະ ສຳນວນພາສາລາວທີ່ໃຊ້ປະຈຳ</li>
                                        <li>ຄຳທັກທາຍ, ການແນະນຳຕົວ ແລະ ການສົນທະນາຢ່າງສຸພາບ</li>
                                        <li>ພາສາທີ່ໃຊ້ໃນການຊື້ເຄື່ອງ, ສັ່ງອາຫານ, ຖາມທາງ ແລະ ການເດີນທາງ</li>
                                        <li>ສຳນວນສຳລັບສັງຄົມ ແລະ ການສື່ສານໃນບ່ອນເຮັດວຽກ</li>
                                        <li>ຄວາມຮູ້ກ່ຽວກັບຂະນົບທຳນຽມ, ວັດທະນະທຳ ແລະ ວິທີການສື່ສານຂອງຄົນລາວ</li>
                                    <?php else: ?>
                                        <li>Lao sounds, tones, pronunciation, and useful expressions.</li>
                                        <li>Greetings, introductions, and polite everyday conversation.</li>
                                        <li>Practical language for shopping, food, directions, transport, and daily activities.</li>
                                        <li>Common phrases for social situations and communicating at work.</li>
                                        <li>Insights into Lao customs, culture, and local ways of communicating.</li>
                                    <?php endif; ?>
                                </ul>
                            </section>
                            <section class="lao-info-panel">
                                <h4><?= $text['who_for']; ?></h4>
                                <ul class="lao-info-list">
                                    <?php if ($current_lang === 'la'): ?>
                                        <li>ຊາວຕ່າງປະເທດທີ່ອາໄສ ຫຼື ມາຢ້ຽມຢາມປະເທດລາວ</li>
                                        <li>ຜູ້ທີ່ຕ້ອງການສື່ສານກັບໝູ່ເພື່ອນ, ເພື່ອນຮ່ວມງານ ຫຼື ຊຸມຊົນທີ່ໃຊ້ພາສາລາວ</li>
                                        <li>ຜູ້ເລີ່ມຮຽນ ແລະ ຜູ້ທີ່ຕ້ອງການຝຶກຝົນເພີ່ມເຕີມ</li>
                                    <?php else: ?>
                                        <li>International residents and visitors in Laos.</li>
                                        <li>People who want to communicate with Lao-speaking friends, colleagues, or communities.</li>
                                        <li>Beginners as well as learners who want to practise and improve.</li>
                                    <?php endif; ?>
                                </ul>
                                <div class="lao-cta">
                                    <a href="mailto:logosinstitute.fl.edu@gmail.com?subject=Lao%20Language%20Course">
                                        <i class="fa fa-envelope" aria-hidden="true"></i> <?= $text['ask_course']; ?>
                                    </a>
                                    <a href="tel:+8562092362524"><i class="fa fa-phone" aria-hidden="true"></i> <?= $text['call_us']; ?></a>
                                </div>
                            </section>
                        </div>
                    </div>

                    <div class="lao-gallery" aria-label="<?= $text['lao_gallery']; ?>">
                        <?php foreach ($lao_gallery as $index => $photo): ?>
                            <figure>
                                <img src="<?= htmlspecialchars($photo['image'], ENT_QUOTES, 'UTF-8'); ?>"
                                     alt="<?= htmlspecialchars($current_lang === 'la' ? $photo['alt_la'] : $photo['alt'], ENT_QUOTES, 'UTF-8'); ?>"
                                     loading="lazy">
                                <figcaption><?= htmlspecialchars($text['gallery_captions'][$index], ENT_QUOTES, 'UTF-8'); ?></figcaption>
                            </figure>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<footer class="programs-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mb-4">
                <h2><?= $text['institute']; ?></h2>
                <p><?= $text['tagline']; ?></p>
                <div class="programs-footer-map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3794.780105905844!2d102.63083141024914!3d17.98896468512677!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x312467e8718562d9%3A0x6e84fd1e2e235b0e!2sLogos%20Institute%20of%20Foreign%20Language%20(LIFL)!5e0!3m2!1sth!2sla!4v1773388410171!5m2!1sth!2sla"
                        title="<?= htmlspecialchars($text['directions_title'], ENT_QUOTES, 'UTF-8'); ?>"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen>
                    </iframe>
                </div>
                <p class="mt-3 mb-0">
                    <a href="https://www.google.com/maps/search/?api=1&amp;query=Logos+Institute+of+Foreign+Language+Vientiane+Laos"
                       target="_blank" rel="noopener noreferrer">
                        <?= $text['open_maps']; ?> <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </p>
            </div>
            <div class="col-lg-5 mb-4">
                <h2><?= $text['contact_admissions']; ?></h2>
                <p><i class="fa fa-map-marker" aria-hidden="true"></i> <?= $text['address']; ?></p>
                <p><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:+8562092362524">+856 20 9236 2524</a></p>
                <p><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:logosinstitute.fl.edu@gmail.com">logosinstitute.fl.edu@gmail.com</a></p>
            </div>
        </div>
        <div class="programs-footer-bottom">&copy; <?= date('Y'); ?> <?= $text['copyright']; ?></div>
    </div>
</footer>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const currentPath = window.location.pathname.split("/").pop() || "index.php";
    document.querySelectorAll(".custom_nav-container .navbar-nav .nav-item").forEach(function(item) {
        const isCurrentPage = item.getAttribute("data-page") === currentPath;
        item.classList.toggle("active", isCurrentPage);
    });
});
</script>
</body>
</html>
