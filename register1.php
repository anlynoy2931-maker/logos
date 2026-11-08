<?php  

require_once 'db.php';

if (!isset($conn)) {
    die("Database connection not found");
}
?>

<!DOCTYPE html>
<html lang="lo">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="icon" href="images/favicon.png" type="image/gif" />

    <title>ສະໝັກສອບເສັງ</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <style>
    @font-face {
        font-family: 'Phetsarath OT';
        src: url('fonts/PhetsarathOT.ttf') format('truetype');
    }

    body {
        font-family: 'Phetsarath OT', "Times New Roman", serif;
    }
    </style>
</head>

<body class="container mt-4 bg-light p-4 rounded shadow">
<?php include_once __DIR__ . '/site_header.php'; ?>

    <div style="
        background: linear-gradient(90deg, #460da1, #d2199b);
        padding: 25px;
        border-radius: 12px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(157, 27, 27, 0.1);
    ">

        <div class="text-center">

            <img src="images/logos.png" width="120" class="mb-3"
                style="background:white; padding:8px; border-radius:50%;">

            <h4 class="fw-bold mb-1">
                ສະຖາບັນພາສາຕ່າງປະເທດ
            </h4>

            <p class="mb-1">
                LOGOS Institute of Foreign Language
            </p>

            <hr style="width:60%; margin:auto; border:1px solid rgba(223, 220, 220, 0.91);">

            <h3 class="mt-3 fw-semibold">
                ລົງທະບຽນອອນລາຍສອບເສັງ
            </h3>

            <p class="mb-1">
                (Online Exam Registration)
            </p>

        </div>
    </div>

    <!-- Header -->
    <div style="
    background:#0d6efd;
    color:white;
    padding:12px 15px;
    border-radius:8px;
    font-size:20px;
    font-weight:bold;
    margin-bottom:15px;
">
        ຂໍ້ມູນນັກສຶກສາ (Student Information)
    </div>


   <form action="save_student.php" method="POST" enctype="multipart/form-data">

        <label>
            ຊື່ ແລະ ນາມສະກຸນພາສາລາວ
            <br>
            <small>(Name and Family name in Lao)</small>
        </label>
        <br>

        <select name="title_lao" class="form-control" style="width:120px; display:inline-block;">
            <option value="ທ້າວ">ທ້າວ</option>
            <option value="ນາງ">ນາງ</option>
            <option value="ຄູບາ">ຄູບາ</option>
            <option value="ສຳມະເນນ">ສຳມະເນນ</option>
        </select>

        <input type="text" name="name_lao" class="form-control" style="width:300px; display:inline-block;"
            placeholder="ຊື່" required>

        <input type="text" name="surname_lao" class="form-control" style="width:300px; display:inline-block;"
            placeholder="ນາມສະກຸນ" required>
        </div>
        <br><br>


        <div class="mb-2">
            <label>ຊື່ (English)<br>
                <small>(Name and Family name in English)</small>
            </label>
            <br>
            <select name="title_eng" class="form-control" style="width:120px; display:inline-block;">
                <option value="Mr">Mr.</option>
                <option value="Ms">Ms.</option>
                <option value="Monk">Monk</option>
                <option value="Novice">Novice</option>
            </select>

            <input type="text" name="name_eng" class="form-control" style="width:300px; display:inline-block;"
                placeholder="First name" required>

            <input type="text" name="surname_eng" class="form-control" style="width:300px; display:inline-block;"
                placeholder="Last name" required>
        </div>

        <br><br>

        <!-- Gender + DOB -->
        <div style="display:flex; gap:30px; align-items:end; flex-wrap:wrap;">

            <!-- Gender -->
            <div>
                <label>ເພດ <br>
                    <small>(gender)</small>
                </label>
                <br>

                <input type="radio" name="gender" value="female" required>
                (ຍິງ) Female

                <input type="radio" name="gender" value="male" required style="margin-left:15px;">
                (ຊາຍ) Male
            </div>

            <!-- DOB -->
            <div>
                <label>ວັນ ເດືອນ ປີ ເກີດ<br>
                    <small>(Date of Birth dd/mm/yyyy)</small>
                </label>
                <br>
                <input type="text" id="dob" name="dob" class="form-control" placeholder="dd/mm/yyyy" autocomplete="off"
                    required style="width:250px;">
            </div>

            <div>
                <label>ສັນຊາດ <br>
                    <small>(Nationality)</small>
                </label>
                <br>
                <input type="text" name="nationality" class="form-control" required>
            </div>

            <div>
                <label>ສາສະໜາ <br>
                    <small>(Religion)</small>
                </label>
                <br>
                <input type="text" name="religion" class="form-control" required>

            </div>

            <div>
                <label>ທີ່ຢູ່ປັດຈຸບັນບ້ານ <br>
                    <small>(Current address) Ban</small>
                </label>
                <br>
                <input type="text" name="current_address" class="form-control" required>

            </div>

            <div>
                <label>ເມືອງ <br>
                    <small>(Didtrict)</small>
                </label>
                <br>
                <input type="text" name="current_district" class="form-control" required>

            </div>

            <div>
                <label>ແຂວງ <br>
                    <small>(Province)</small>
                </label>
                <br>
                <input type="text" name="current_province" class="form-control" required>

            </div>

            <div>
                <label>ບ້ານເກີດ <br>
                    <small>( Village)</small>
                </label>
                <br>
                <input type="text" name="birth_village" class="form-control" required>

            </div>

            <div>
                <label>ເມືອງເກີດ <br>
                    <small>(District)</small>
                </label>
                <br>
                <input type="text" name="birth_district" class="form-control" required>

            </div>

            <div>
                <label>ແຂວງເກີດ <br>
                    <small>(Province)</small>
                </label>
                <br>
                <input type="text" name="birth_province" class="form-control" required>

            </div>

            <div>
                <label>ຮຽນຈົບຈາກໂຮງຮຽນມັດທະຍົມ<br>
                    <small>( High School)</small>
                </label>
                <br>
                <input type="text" name="highschool" class="form-control" required>

            </div>

            <div>
                <label>ເບີໂທ ແລະ ເບີວັອດແອັບ<br>
                    <small>(Phone number and Whatsapp number )</small>
                </label>
                <input type="text" name="tel" class="form-control" required>

            </div>

            <div>
                <label>ຊື່ຜູ້ປົກຄອງ<br>
                    <small>(Guardian's name )</small>
                </label>
                <input type="text" name="parent_name" class="form-control required" required>

            </div>

            <div>
                <label>ເບີໂທຜູ້ປົກຄອງ<br>
                    <small>(Guardian's phone number)</small>
                </label>
                <input type="text" name="parent_tel" class="form-control" required>

            </div>

        </div>

        <br>

        <!-- Header -->
        <div style="
    background:#0d6efd;
    color:white;
    padding:12px 15px;
    border-radius:8px;
    font-size:20px;
    font-weight:bold;
    margin-bottom:15px;
">
            ຫຼັກສູດ(Program of studying) ເລືອກຫຼັກສູດຫຼັກ ແລະ ຫຼັກສູດສຳຮອງ
        </div>

        <!-- Program -->
        <label>ເລືອກຫຼັກສູດ Frist choice majorourse</label>

        <select id="program_id" name="program_id" class="form-select" required>
            <option value="">-- ເລືອກ Choose--</option>

            <?php
    $sql = "
SELECT p.program_id, m.major_name, c.course_name, t.time_name
FROM program_options p
LEFT JOIN majors m ON p.major_id = m.major_id
LEFT JOIN courses c ON p.course_id = c.course_id
LEFT JOIN study_time t ON p.time_id = t.time_id
WHERE p.program_id IN (1, 9, 6)
ORDER BY FIELD(p.program_id, 1, 9, 6)
";

    $data = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($data)) {
        $text = $row['major_name'] . ' - ' . $row['course_name'] . ' - ' . $row['time_name'];
    ?>
            <option value="<?= $row['program_id']; ?>">
                <?= $text; ?>
            </option>
            <?php } ?>
        </select>

        <br>

        <!-- Backup Program -->
        <label>ຫຼັກສູດສຳຮອງ Second choice majorse</label>

        <select id="backup_program_id" name="backup_program_id" class="form-select" required>

            <option value="">-- ເລືອກ Choose--</option>

            <?php
    $sql = "
SELECT p.program_id, m.major_name, c.course_name, t.time_name
FROM program_options p
LEFT JOIN majors m ON p.major_id = m.major_id
LEFT JOIN courses c ON p.course_id = c.course_id
LEFT JOIN study_time t ON p.time_id = t.time_id
WHERE p.program_id IN (1, 9, 6)
ORDER BY FIELD(p.program_id, 1, 9, 6)
";

    $data = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($data)) {

        $text = $row['major_name'] . ' - ' .
                $row['course_name'] . ' - ' .
                $row['time_name'];
    ?>

            <option value="<?= $row['program_id']; ?>">
                <?= $text; ?>
            </option>

            <?php } ?>

        </select>

        <br>

        <label>ຮູບຕິດໃບ 3x4 <br>
            <small>(3X4 Photo)</small>
        </label>
        <input type="file" name="photo" class="form-control" required>


        <label>ບັດປະຈຳຕົວ ຫຼື ສຳມະໂນຄົວ<br>
            <small>(National ID Card or Household Registration Book)</small>
        </label>

      <input type="file" name="id_card" class="form-control" accept="image/*">

        <div>
            <label>ໃບປະກາດຈົບມໍປາຍ ຫຼື ບັດເຂົ້າຫ້ອງສອບເສັງຈົບມໍປາຍ<br>
                <small>(
                    High School Diploma or Exam Admission Card)</small>
            </label>
            <input type="file" name="highschool_certificate" class="form-control" accept="image/*,.pdf" required>
            <br>




            <div>
                <small style="color:red;">
                    ກະລຸນາເລືອກອັບໂຫຼດຢ່າງໃດຢ່າງໜຶ່ງ
                    (ໃບປະກາດຈົບ ຫຼື ບັດເຂົ້າຫ້ອງສອບ)
                </small>
            </div>
            <br>

            <button class="btn btn-primary w-100">ຕໍ່ໄປ Next</button>


    </form>

    <script>
    document.querySelector("form").addEventListener("submit", function(e) {

        let form = this;

        // ตรวจ input required
        let requiredFields = form.querySelectorAll("input[required], select[required]");

        for (let field of requiredFields) {

            // ข้าม radio
            if (field.type === "radio") {
                continue;
            }

            // ตรวจ file
            if (field.type === "file") {

                if (field.files.length === 0) {
                    alert("ກະລຸນາອັບໂຫຼດໄຟລ໌");
                    field.focus();
                    e.preventDefault();
                    return;
                }

                continue;
            }

            // ตรวจค่าว่าง
            if (!field.value || field.value.trim() === "") {

                alert("ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບ");

                field.focus();

                e.preventDefault();

                return;
            }
        }

        // ตรวจ gender
        let gender = form.querySelector('input[name="gender"]:checked');

        if (!gender) {

            alert("ກະລຸນາເລືອກເພດ");

            e.preventDefault();

            return;
        }




    });


    // =========================
    // DATE PICKER
    // =========================

    $(function() {

        $("#dob").datepicker({

            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "1950:2026"

        });

    });
    </script>
</body>

</html>