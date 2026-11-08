# Logos Institute Website

## ເລີ່ມໃຊ້ໃນເຄື່ອງໃໝ່ (XAMPP)

1. ຕິດຕັ້ງ Git ແລະ XAMPP (PHP 8.0+ ພ້ອມ `mysqli`).
2. Clone project ໃສ່ `C:\xampp\htdocs\admission\exam_registration`.
3. ເປີດ Apache ແລະ MySQL ໃນ XAMPP Control Panel.
4. ສ້າງ database ຊື່ `exam_registration` ໃນ phpMyAdmin.
5. Copy `config.local.example.php` ເປັນ `config.local.php`, ແລ້ວຕັ້ງຄ່າ database ແລະ admin login ຂອງເຄື່ອງນັ້ນ.
6. Import database schema ເຂົ້າ database. **ຕອນນີ້ repo ຍັງບໍ່ມີ schema SQL**, ດັ່ງນັ້ນຕ້ອງເພີ່ມ/ນຳເຂົ້າ schema ກ່ອນໜ້າທີ່ອ່ານຂໍ້ມູນຈາກ MySQL ຈະໃຊ້ໄດ້.
7. ເປີດ `http://localhost/admission/exam_registration/`.

ຖ້າຕ້ອງການ port 3000, ເປີດ terminal ໃນ folder project ແລະລັນ `php -S 127.0.0.1:3000`, ແລ້ວເຂົ້າ `http://127.0.0.1:3000/index.php`.

ຫ້າມ upload `config.local.php`, ຂໍ້ມູນນັກສະໝັກ, ຫຼື database records ຂຶ້ນ GitHub.

## Requirements

- PHP 8.0 or newer with the `mysqli` extension
- MySQL or MariaDB

## Run locally with XAMPP

1. Clone this repository into `C:\xampp\htdocs\admission\exam_registration`.
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Create a local database named `exam_registration`.
4. Copy `config.local.example.php` to `config.local.php` and set your database and admin credentials.
5. Import the project database schema into `exam_registration`.
6. Open `http://localhost/admission/exam_registration/`.

To use port 3000 with PHP's built-in server, run `php -S 127.0.0.1:3000` from the project directory, then open `http://127.0.0.1:3000/index.php`.

> The database schema is not included yet. The public website pages that read from MySQL will not run until the schema is imported. Do not put database records, applicant data, or `config.local.php` in GitHub.

## Configuration

`config.local.php` is a machine-specific file and is ignored by Git. Environment variables (`DB_HOST`, `DB_USERNAME`, `DB_PASSWORD`, `DB_NAME`, `WEBSITE_DB_HOST`, `WEBSITE_DB_USERNAME`, `WEBSITE_DB_PASSWORD`, `WEBSITE_DB_NAME`, `ADMIN_USERNAME`, and `ADMIN_PASSWORD`) override values in that file.

Admin login remains disabled until both admin credentials are configured.
