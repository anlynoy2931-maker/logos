<?php
session_start();
include "db.php";

$student_id = intval($_GET['id'] ?? 0);

$agreeKey = 'agree_rule_'.$student_id;

if (!isset($_SESSION[$agreeKey])) {
    $_SESSION[$agreeKey] = false;
}
/* ===================== */

$sql = "SELECT students.*, 
        majors.major_name, 
        courses.course_name, 
        exam_rounds.round_name,

      exam_rounds.exam_date_main AS bachelor_date,
exam_rounds.exam_time_main AS bachelor_time,

exam_rounds.exam_date_diploma AS diploma_date,
exam_rounds.exam_time_diploma AS diploma_time

FROM students

LEFT JOIN majors 
ON students.major_id = majors.major_id

LEFT JOIN courses 
ON students.course_id = courses.course_id

LEFT JOIN exam_rounds 
ON students.exam_round_id = exam_rounds.id

WHERE students.id = $student_id";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}

$student = mysqli_fetch_assoc($result);

if (!$student) {
    die("❌ Student not found");
}

if ($student['status'] != 'approved') {
    die("❌ ຍັງບໍ່ທັນຈ່າຍເງິນ");
}

/* =========================
   FIX EXAM DATE / TIME
========================= */

$final_exam_date = null;
$final_exam_time = null;

/*
course_id
1 = Bachelor
2 = Diploma
*/

if ($student['time_id'] == 1 || $student['time_id'] == 2) {

    // ພາກເຊົ້າ และ ພາກບ່າຍ
    $final_exam_date = $student['bachelor_date'];
    $final_exam_time = $student['bachelor_time'];

} elseif ($student['time_id'] == 3) {

    // ພາກຄໍ່າ
    $final_exam_date = $student['diploma_date'];
    $final_exam_time = $student['diploma_time'];

}


/* กันค่าว่าง */
if (
    empty($final_exam_date) ||
    $final_exam_date == '0000-00-00'
) {
    $final_exam_date = null;
}

if (
    empty($final_exam_time) ||
    $final_exam_time == '00:00:00'
) {
    $final_exam_time = null;
}


$time = [
    1 => "ພາກເຊົ້າ",
    2 => "ພາກສວຍ",
    3 => "ພາກຄໍ່າ"
];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="images/favicon.png" type="image/gif" />
    <title>ENTRANCE EXAM ID SLIP</title>

    <style>
    @media print {
        .exam-card {
            box-shadow: none;
            page-break-inside: avoid;
        }

        /* ซ่อนกล่อง Checkbox ตอนสั่งพิมพ์บัตรรวมถึงพื้นที่เว้นวรรค */
        .interactive-checkbox {
            display: none !important;
        }
    }

    @page {
        size: A4;
        margin: 0;
    }

    body {
        margin: 0;
        font-family: 'Noto Sans Lao', sans-serif;
        background: #f3f4f6;
    }

    /* ===== A4 PAGE ===== */
    .print-page {
        width: 210mm;
        min-height: 297mm;
        margin: auto;
        background: white;
        padding: 10mm;
        box-sizing: border-box;
    }


    .two-card-layout {
        display: flex;
        gap: 25px;
        align-items: flex-start;
    }

    .left-card {
        width: 255%;
    }

    .right-card {
        width: 55%;
    }

    /* ===== CARD STYLE ===== */
    .exam-card,
    .rules,
    .receipt {
        background: #fff;
        border-radius: 10px;
        padding: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    }

    /* ===== PRINT MODE ===== */
    @media print {

        body {
            background: white;
        }

        .no-print {
            display: none !important;
        }

        .print-page {
            width: 210mm;
            min-height: 297mm;
            padding: 12mm;
        }

        .two-card-layout {
            display: block;
        }

        .left-card,
        .right-card {
            width: 100% !important;
        }

        .exam-card,
        .rules,
        .receipt {
            box-shadow: none !important;
            page-break-inside: avoid;
        }
    }

    .lao {
        font-family: "Phetsarath OT", serif;
    }

    .eng {
        font-family: "Times New Roman", serif;
    }

    .exam-card {
        width: 210mm;
        min-height: 148mm;
        margin: auto;
        background: white;
        padding: 15mm;
        box-shadow: 0 15px 15px rgba(0, 0, 0, 0.8);
    }

    .rules {
        font-family: 'Noto Sans Lao', sans-serif;
        background: #fff;
        padding: 30px 35px;
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        max-width: 900px;
        margin: 10px auto;
        line-height: 1.9;
        color: #111111;
        /* เปลี่ยนจาก #333 เป็นสีดำเข้มขึ้น */
    }

    .rules h3 {
        text-align: center;
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #000000;
        /* ดำสนิท */
    }

    .rules h3 p {
        font-size: 16px;
        font-weight: 700;
        /* ปรับให้หนาขึ้น */
        margin: 5px 0 0;
        color: #111111;
    }

    .rules p {
        font-size: 16px;
        margin: 8px 0;
    }

    .rules b {
        color: #000000;
        /* ดำสนิท */
        font-weight: 700;
    }

    /* สไตล์คลาสใหม่สำหรับตัวหนังสือที่ต้องการเน้นดำเข้มเป็นพิเศษ */
    .text-black-bold {
        color: #000000 !important;
        font-weight: 700 !important;
    }

    .rules .section-title {
        margin-top: 18px;
        font-weight: 700;
        font-size: 18px;
        color: #000000;
        /* เปลี่ยนหัวข้อข้อ 1, 2, 3 เป็นสีดำเข้มตามโจทย์ */
        border-left: 4px solid #000000;
        padding-left: 10px;
    }

    .rules {
        margin-top: 20px;
        font-size: 14px;
        line-height: 1.6;
    }

    .title {
        text-align: center;
        font-weight: bold;
        font-size: 28px;
        margin-bottom: 20px;
    }

    .exam-no {
        text-align: center;
        font-size: 20px;
        margin-bottom: 25px;
    }

    .content {
        display: flex;
        gap: 40px;
    }

    .photo {
        width: 140px;
        height: 170px;
        border: 2px solid black;
    }

    .photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .info {
        flex: 1;
        font-size: 18px;
        line-height: 32px;
    }

    .footer {
        margin-top: 40px;
        font-size: 18px;
        text-align: center;
        color: purple;
    }

    .logo {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo img {
        width: 120px;
        margin-right: 20px;
    }

    .logo-text h1 {
        margin: 0;
        font-size: 30px;
    }

    .logo-text p {
        margin: 3px 0;
    }

    @media print {
        .no-print {
            display: none;
        }
    }
    </style>
</head>

<body>
<?php include_once __DIR__ . '/site_header.php'; ?>

    <div class="two-card-layout">

        <div class="left-card">

            <div class="exam-card">

                <div class="title">ENTRANCE EXAM ID SLIP</div>

                <div class="exam-no">
                    Entrance Examination No: <?= $student['reg_number'] ?>
                </div>

                <div class="content">

                    <div class="photo">
                        <img src="uploads/<?= $student['photo'] ?>">
                    </div>

                    <div class="info">

                        <div>
                            Name (Lao) :
                            <span class="lao"><?= $student['name_lao'] ?> <?= $student['surname_lao'] ?></span>
                        </div>

                        <div>
                            Name (English) :
                            <span class="eng"><?= $student['name_eng'] ?> <?= $student['surname_eng'] ?></span>
                        </div>

                        <div>
                            Birth of Date :
                            <?= date('d/m/Y', strtotime($student['dob'])) ?>
                        </div>

                        <div>
                            Major :
                            <span class="lao"><?= $student['course_name'] ?> , <?= $student['major_name'] ?></span>,
                            <span class="lao">
                                <?= isset($time[$student['time_id']]) ? $time[$student['time_id']] : '-' ?>
                            </span>
                        </div>

                        <div>
                            High School :
                            <?= $student['highschool'] ?>
                        </div>

                        <div>
                            Telephone No :
                            <?= $student['tel'] ?>
                        </div>


                        <div>
                            Exam Date:
                            <?= (!empty($final_exam_date)) 
    ? date("d/m/Y", strtotime($final_exam_date)) 
    : '-' ?>
                            ,
                            Time :
                            <span><?= (!empty($final_exam_time)) 
    ? date("h:i A", strtotime($final_exam_time)) 
    : '-' ?></span>
                        </div>

                    </div>
                </div>

                <div class="footer">
                    <b>* Test on time. * Bring your exam ID slip on the exam day</b>
                </div>

                <div style="text-align:right; margin-top:40px;">
                    Vientiane Capital , Date :
                    <?= !empty($student['created_at']) ? date("d/m/Y", strtotime($student['created_at'])) : '-' ?>
                    <br>
                    Applicant's :
                </div>

                <div class="logo">
                    <img src="images/logos.png">

                    <div class="logo-text">
                        <h1>LOGOS INSTITUTE</h1>
                        <p>021 418120 - 020 92362524</p>
                        <p>FB: Logos Institute of Foreign Language</p>
                    </div>

                </div>

                <style>
                @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@300;400;600;700&display=swap');

                .rules {
                    font-family: 'Noto Sans Lao', sans-serif;
                    background: #fff;
                    padding: 25px 30px;
                    border-radius: 12px;
                    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
                    max-width: 900px;
                    margin: 20px auto;
                    line-height: 1.8;
                    color: #111111;
                }

                .rules h3 {
                    font-size: 22px;
                    font-weight: 700;
                    text-align: center;
                    margin-bottom: 5px;
                    color: #000000;
                }

                .rules h3 p {
                    font-size: 16px;
                    font-weight: 700;
                    margin: 5px 0 15px;
                    color: #111111;
                }

                .rules b {
                    color: #000000;
                    font-weight: 700;
                }

                .rules p {
                    font-size: 16px;
                    margin: 8px 0;
                }

                .rules .section-title {
                    margin-top: 18px;
                    font-weight: 700;
                    font-size: 18px;
                    color: #000000;
                }
                </style>

                <div class="rules lao">

                    <h3>
                        ກົດລະບຽບການສອບເສັງຄັດເລືອກເຂົ້າຮຽນ
                        <p>ປະຈຳສົກສຶກສາ 2026-2027</p>
                    </h3>

                    <div class="section-title"> 1. ກ່ອນເຂົ້າຫ້ອງສອບເສັງ</div>
                    <p>1. ນັກສອບເສັງຕ້ອງນຳບັດອະນຸຍາດເຂົ້າຫ້ອງເສັງສະເໜີນຳຄະນະກຳມະການຍາມຫ້ອງສອບເສັງ ກ່ອນເວລາສອບເສັງແທ้ 10
                        ນາທີ.</p>
                    <p>2. ຫ້າມເອົາຄົນອື່ນມາສອບເສັງແທນຕົນເອງຢ່າງເດັດຂາດ.</p>
                    <p>3. ຕ້ອງນຸ່ງເຄື່ອງແບບຊຸດນັກຮຽນ ແລະ ຊົງຜົມຂອງນັກສອບເສັງ ຍິງ-ຊາຍ ຕ້ອງສຸພາບ. </p>
                    <p>4. ຕ້ອງກະກຽມອຸປະກອນ ຮັບໃຊ້ໃນການສອບເສັງຢ່າງພຽງພໍເຊັ່ນ: ບິກສີຟ້າ ຫຼື ບິກສີດຳ ແລະ ນ້ຳລຶບບິກ.</p>
                    <p>5. ຫ້າມນຳເອກະສານ, ໂທລະສັບ, smartwatches, ອາຫານ, ເຄື່ອງດື່ມ, ອຸປະກອນສື່ສານ ຫຼື ອຸປະກອນຕ່າງໆ
                        ເຂົ້າຫ້ອງສອບເສັງເດັດຂາດ.</p>

                    <div class="section-title"> 2. ໃນເວລາສອບເສັງ</div>
                    <p>1. ຫ້າມບົນແຊວ ຫຼື ສົ່ງສຽງດັງ, ຫ້າມຍືມອຸປະກອນຕ่างໆ ຈາກຄົນອື່ນ, ຫ້າມກ່າຍເຈ້ຍນ້ອຍ,
                        ຫ້າມກ່າຍຂໍ້ສອບຄົນອື່ນ ແລະ ຫ້າມໃຫ້ຄົນອື່นກ່າຍຂໍ້ສອບຂອງຕົນເອງຢ່າງເດັດຂາດ.</p>
                    <p>2. ຖ້ານັກສອບເສັງຄົນໃດຫາກລະເມີດຂໍ้ຫ້າມທີ່ລະບຸໃນຂໍ້ທີ 01, ທາງຄະນະກຳມະການຈະຕັກເຕືອນ 02
                        ຄັ້ງເທົ່ານັ້ນ, ຄັ້ງທີ່ 03 ຈະໄດ້ຖືກເຊີນອອກຈາກຫ້ອງສອບເສັງ ແລະ ຈະໝົດສິດໃນການສອບເສັງທັນທີ.</p>
                    <p>3. ຖ້ານັກສອບເສັງຄົນໃດຫາກມີບັນຫາ ຫຼື ບໍ່ເຂົ້າໃຈໃນການສອບເສັງ ແມ່ນໃຫ້ຍົກມືຂື້ນ
                        ຂໍອະນຸຍາດສອບຖາມຄະນະກຳມະການ ເພື່ອແກ້ໄຂຂໍ້ຂ້ອງໃຈ ພາຍໃນ 15 ນາທີທຳອິດຂອງການສอบເສັງ.</p>
                    <p>4. ນັກສອບເສັງທີ່ມີຄວາມຈຳເປັນອອກໄປຂ້າງນອກ (ຖ່າຍໜັກ ຫຼື ຖ່າຍເບົາ)
                        ຕ້ອງໄດ້ຂໍອະນຸຍາດນຳຄະນະກຳມະການຍາມຫ້ອງສອບເສັງກ່ອນ ແລະ ອະນຸຍາດໃຫ້ໄປໄດ້ເທື່ອລະຄົນເທົ່ານັ້ນ.</p>

                    <div class="section-title">3. ເວາລາສອບເສັງສຳເລັດ</div>
                    <p>1. ພາຍຫຼັງສຳເລັດໃນການເຮັດຂໍ້ສອບແລ້ວ ນັກສອບເສັງຕ້ອງກວດບົດສອບເສັງຂອງຕົນໃຫ້ລະອຽດແລ້ວຈຶ່ງສົ່ງ,
                        ເມື່ອສົ່ງບົດເສັງແລ້ວແມ່ນສາມາດອອກຈາກຫ້ອງສອບເສังໄດ້, ແຕ່ຫ້າມບົນແຊວຢູ່ບໍລິເວນໃກ້ຫ້ອງສອບເສັງ
                        ເພາະຈະເປັນການລົບກວນນັກສອບເສັງຄົນອື່ນ.</p>
                    <p>2. ນັກສອບເສັງທຸກຄົນຕ້ອງປະຕິບັດຕາມກົດລະບຽບທີ່ກ່າວມາຂ້າງເທິ່ງຢ່າງເຂັ້ມງວດ,
                        ຖ້າຫາກຜູ້ໃດຝ່າຝືນຈະຖືກປະຕິບັດວິໄນ ໂດຍບໍ່ມີການຕໍ່ວ່າໃດໆ.</p>



                    <div class="interactive-checkbox">
                        <p style="font-size:15px; cursor: pointer;" class="text-black-bold">
                            <label><input type="checkbox" name="main_agree_lao"> ຂ້າພະເຈົ້າໄດ້ອ່ານ ແລະ
                                ເຂົ້າໃຈກ່ຽວກັບກົດລະບຽບການສອບເສັງຄັດເລືອກ ທີ່ທາງສະຖາບັນໄດ້ວາງອອກ ແລະ
                                ຈະປະຕິບັດຢ່າງເຂັ້ມງວດ</label>
                        </p>

                        <p style="font-size:15px; cursor: pointer;" class="text-black-bold">
                            <label><input type="checkbox" name="main_submit_lao"> ສົ່ງແບບຟອມສະໝັກ</label>
                        </p>
                    </div>

                    <br>

                    <div style="text-align:center;" class="text-black-bold">
                        Entrance Examination Regulations<br>
                        Academic Year 2026–2027
                    </div>

                    <br>

                    <p class="text-black-bold">1. Before the Exam</p>
                    <p><b class="text-black-bold">Be on time:</b> Show your entrance card to security <b
                            class="text-black-bold">10 minutes before</b> the exam starts.</p>
                    <p><b class="text-black-bold">Dress code:</b> No one can take the test for you. You must wear your
                        proper school uniform and look neat.</p>
                    <p><b class="text-black-bold">What to bring:</b> Only bring blue or black pens and erasers. No
                        borrowing allowed.</p>
                    <p><b class="text-black-bold">What NOT to bring:</b> No notes, phones, smartwatches, electronics,
                        food, or drinks.</p>

                    <p class="text-black-bold">2. During the Exam</p>
                    <p><b class="text-black-bold">Stay quiet:</b> No talking, no copying, no sharing answers, and no
                        using cheat sheets.</p>
                    <p><b class="text-black-bold">3-Strike Rule:</b> You get 2 warnings for breaking rules. On the 3rd
                        time, you will be removed and fail immediately.</p>
                    <p><b class="text-black-bold">Questions:</b> If you have a question, raise your hand during the
                        first 15 minutes only.</p>
                    <p><b class="text-black-bold">Bathroom:</b> Ask permission first. Only one person can go at a time.
                    </p>

                    <p class="text-black-bold">3. Ending the Exam</p>
                    <p><b class="text-black-bold">Leaving:</b> Check your answers, hand in your test, and leave the
                        classroom immediately. Do not hang around outside the room.</p>
                    <p><b class="text-black-bold">Follow the rules:</b> If you break any of these rules, you will be
                        punished immediately without another warning.</p>

                    <div class="interactive-checkbox">
                        <p class="text-black-bold">*Declaration of Consent</p>
                        <p class="text-black-bold" style="cursor: pointer;">
                            <label><input type="checkbox" name="main_agree_eng"> I have read, understood, and agree to
                                abide by the LIFL examination regulations.</label>
                        </p>
                        <p class="text-black-bold" style="cursor: pointer;">
                            <label><input type="checkbox" name="main_submit_eng"> Submit Application</label>
                        </p>
                    </div>

                </div>
            </div>

        </div>

        <div class="right-card">
            <?php include 'receipt.php'; ?>
        </div>

    </div>

    <div class="no-print" style="text-align:center; margin-top:20px;">
        <button onclick="window.location='index.php'"
            style="background:#28a745; color:#fff; border:none; padding:10px 25px; border-radius:8px;">
            ⬅ ກັບໄປໜ້າຫຼັກ
        </button>

        <button onclick="window.print()"
            style="background:#007bff; color:#fff; border:none; padding:10px 25px; border-radius:8px;">
            🖨 Print
        </button>

        <button onclick="downloadPDF()"
            style="background:#dc3545; color:#fff; border:none; padding:10px 25px; border-radius:8px;">
            📄 Save PDF
        </button>
    </div>

    <script>
    function downloadPDF() {
        window.print();
    }
    </script>



    <?php if($_SESSION[$agreeKey] === false): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    Swal.fire({
        title: '<span style="color:#000; font-weight:700;">ກົດລະບຽບການສອບເສັງຄັດເລືອກເຂົ້າຮຽນ<br>ປະຈຳສົກສຶກສາ 2026-2027</span>',
        width: '1000px',
        html: `
        <div style="text-align:left;font-size:14px;max-height:900px;overflow:auto;line-height:1.6; color:#111;">

                    <div style="margin-top: 18px; font-weight: 700; font-size: 18px; color: #000; border-left: 4px solid #000; padding-left: 10px;"> 1. ກ່ອນເຂົ້າຫ້ອງສອບເສັງ</div>
                    <p>1. ນັກສອບເສັງຕ້ອງນຳບັດອະນຸຍາດເຂົ້າຫ້ອງເສັງສະເໜີນຳຄະນະກຳມະການຍາມຫ້ອງສອບເສັງ ກ່ອນເວລາສອບເສັງແທ້ 10 ນາທີ.</p>
                    <p>2. ຫ້າມເອົາຄົນອື່ນມາສອບເສັງແທນຕົນເອງຢ່າງເດັດຂາດ.</p>
                    <p>3. ຕ້ອງນຸ່ງເຄື່ອງແບບຊຸດນັກຮຽນ ແລະ ຊົງຜົມຂອງນັກສອບເສັງ ຍິງ-ชາຍ ຕ້ອງສຸພາບ. </p>
                    <p>4. ຕ້ອງກະກຽມອຸປະກອນ ຮັບໃຊ້ໃນการສອບເສັງຢ່າງພຽງພໍເຊັ່ນ: ບິກສີຟ້າ ຫຼື ບິກສີດຳ ແລະ ນ້ຳລຶບບິກ.</p>
                    <p>5. ຫ້າມນຳເອກະສານ, ໂທລະສັບ, smartwatches, ອາຫານ, ເຄື່ອງດື່ມ, ອຸປະກອນສື່ສານ ຫຼື ອຸປະກອນຕ່າງໆ ເຂົ້າຫ້ອງສອບເສັງເດັດຂາດ.</p>

                    <div style="margin-top: 18px; font-weight: 700; font-size: 18px; color: #000; border-left: 4px solid #000; padding-left: 10px;"> 2. ໃນເວລາສອບເສັງ</div>
                    <p>1. ຫ້າມບົນແຊວ ຫຼື ສົ່ງສຽງດັງ, ຫ້າມຍືມອຸປະກອນຕ່າງໆ ຈາກຄົນອື່ນ, ຫ້າມກ່າຍເຈ້ຍນ້ອຍ, ຫ້າມກ່າຍຂໍ້ສອບຄົນອື່ນ ແລະ ຫ້າມໃຫ້ຄົນອື່ນກ່າຍຂໍ້ສອບຂອງຕົນເອງຢ່າງເດັດຂາດ.</p>
                    <p>2. ຖ້ານັກສອບເສັງຄົນໃດຫากລະເມີດຂໍ້ຫ້າມທີ່ລະບຸໃນຂໍ້ທີ 01, ທາງຄະນະກຳມະການຈະຕັກເຕືອນ 02 ຄັ້ງເທົ່ານັ້ນ, ຄັ້ງທີ່ 03 ຈະໄດ້ຖືກເຊີນອອກຈາກຫ້ອງສອບເສັງ ແລະ ຈະໝົດສິດໃນການສອບເສັງທันທີ.</p>
                    <p>3. ຖ້ານັກສອບເສັງຄົນໃດຫາກມີບັນຫາ ຫຼື ບໍ່ເຂົ້າໃຈໃນການສອບເສັງ ແມ່ນໃຫ້ຍົກມືຂື້ນ ຂໍອະນຸຍາດສອບຖາມຄະນະກຳມະການ ເພື່ອແກ້ໄຂຂໍ້ຂ້ອງໃຈ ພາຍໃນ 15 ນາທີທຳອິດຂອງການສອບເສັງ.</p>
                    <p>4. ນັກສອບເສັງທີ່ມີຄວາມຈຳເປັນອອກໄປຂ້າງນອກ (ຖ່າຍໜັກ ຫຼື ຖ่ายເບົາ) ຕ້ອງໄດ້ຂໍອະນຸຍາດນຳຄະນະກຳມະການຍາມຫ້ອງສອບເສັງກ່ອນ ແລະ ອະນຸຍาดໃຫ້ໄປໄດ້ເທື່ອລະຄົນເທົ່ານັ້ນ.</p>

                    <div style="margin-top: 18px; font-weight: 700; font-size: 18px; color: #000; border-left: 4px solid #000; padding-left: 10px;">3. ເວາລາສອບເສັງສຳເລັດ</div>
                    <p>1. ພາຍຫຼັງສຳເລັດໃນການເຮັດຂໍ້ສອບແລ້ວ ນັກສอบເສັງຕ້ອງກວດບົດສອບເສັງຂອງຕົນໃຫ້ລະອຽດແລ້ວຈຶ່ງສົ່ງ, ເມື່ອສົ່ງບົດເສັງແລ້ວແມ່ນສາມາດອອກຈາກຫ້ອງສອບເສັງໄດ້, ແຕ່ຫ້າມບົນແຊວຢູ່ບໍລິເວນໃກ້ຫ້ອງສອບເສັງ ເພາະຈະເປັນການລົບກວນນັກສອບເສັງຄົນອື່ນ.</p>
                    <p>2. ນັກສອບເສັງທຸກຄົນຕ້ອງປະຕິບັດຕາມກົດລະບຽບທີ່ກ່າວມາຂ້າງເທິ່ງຢ່າງເຂັ້ມງວດ, ຖ້າຫາກຜູ້ໃດຝ່າຝືນຈະຖືກປະຕິບັດວິໄນ ໂດຍບໍ່ມີການຕໍ່ວ່າໃດໆ.</p>
                                            
                    

                    <p style="font-size:15px; color:#000; font-weight:700; cursor: pointer;">
                        <label><input type="checkbox" id="popup_agree_lao"> ຂ້າພະເຈົ້າໄດ້ອ່ານ ແລະ ເຂົ້າໃຈກ່ຽວກັບກົດລະບຽບການສອບເສັງຄັດເລືອກ ທີ່ທາງສະຖາບັນໄດ້ວາງອອກ ແລະ ຈະປະຕິບັດຢ່າງເຂັ້ມງວດ</label>
                    </p>

                    <p style="font-size:15px; color:#000; font-weight:700; cursor: pointer;">
                        <label><input type="checkbox" id="popup_submit_lao"> ສົ່ງແບບຟອມສະໝັກ</label>
                    </p>

                    <br>

                    <div style="text-align:center; color:#000; font-weight:700;">
                    Entrance Examination Regulations<br>
                    Academic Year 2026–2027
                    </div>

                    <br>

                    <p style="color:#000; font-weight:700;">1. Before the Exam</p>
                    <p><b style="color:#000; font-weight:700;">Be on time:</b> Show your entrance card to security <b style="color:#000; font-weight:700;">10 minutes before</b> the exam starts.</p>
                    <p><b style="color:#000; font-weight:700;">Dress code:</b> No one can take the test for you. You must wear your proper school uniform and look neat.</p>
                    <p><b style="color:#000; font-weight:700;">What to bring:</b> Only bring blue or black pens and erasers. No borrowing allowed.</p>
                    <p><b style="color:#000; font-weight:700;">What NOT to bring:</b> No notes, phones, smartwatches, electronics, food, or drinks.</p>

                    <p style="color:#000; font-weight:700;">2. During the Exam</p>
                    <p><b style="color:#000; font-weight:700;">Stay quiet:</b> No talking, no copying, no sharing answers, and no using cheat sheets.</p>
                    <p><b style="color:#000; font-weight:700;">3-Strike Rule:</b> You get 2 warnings for breaking rules. On the 3rd time, you will be removed and fail immediately.</p>
                    <p><b style="color:#000; font-weight:700;">Questions:</b> If you have a question, raise your hand during the first 15 minutes only.</p>
                    <p><b style="color:#000; font-weight:700;">Bathroom:</b> Ask permission first. Only one person can go at a time.</p>

                    <p style="color:#000; font-weight:700;">3. Ending the Exam</p>
                    <p><b style="color:#000; font-weight:700;">Leaving:</b> Check your answers, hand in your test, and leave the classroom immediately. Do not hang around outside the room.</p>
                    <p><b style="color:#000; font-weight:700;">Follow the rules:</b> If you break any of these rules, you will be punished immediately without another warning.</p>

                    <p style="color:#000; font-weight:700;">*Declaration of Consent</p>
                    <p style="color:#000; font-weight:700; cursor: pointer;">
                        <label><input type="checkbox" id="popup_agree_eng"> I have read, understood, and agree to abide by the LIFL examination regulations.</label>
                    </p>
                    <p style="color:#000; font-weight:700; cursor: pointer;">
                        <label><input type="checkbox" id="popup_submit_eng"> Submit Application</label>
                    </p>

                </div>

            <div style="margin-top: 15px; text-align: center;">
                <input type="checkbox" id="agree">
                <label for="agree" style="color:#000; font-weight:700; cursor: pointer;">ຂ້າພະເຈົ້າຍອມຮັບກົດລະບຽບ (I accept the regulations)</label>
            </div>
        </div>
    `,
        confirmButtonText: 'OK',
        allowOutsideClick: false,
        preConfirm: () => {
            if (!document.getElementById('agree').checked) {
                Swal.showValidationMessage('ກະລຸນາກົດຍອມຮັບກົດລະບຽບ / Please accept the regulations');
                return false;
            }
            return true;
        }
    }).then(() => {
        fetch('agree_rule.php?id=<?= $student_id ?>')
            .then(() => location.reload());
    });
    </script>
    <?php endif; ?>
</body>

</html>