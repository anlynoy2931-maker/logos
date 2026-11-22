<?php

function site_supported_language($language)
{
    return in_array($language, ['en', 'la', 'ko', 'zh'], true) ? $language : 'en';
}

function site_localized_value(array $record, $field, $language)
{
    $language = site_supported_language($language);
    $translatedField = $field . '_' . $language;

    if ($language !== 'en' && !empty($record[$translatedField])) {
        return $record[$translatedField];
    }

    return $record[$field] ?? '';
}

function site_ensure_multilingual_content_schema(mysqli $connection)
{
    $tables = [
        'website_courses' => [
            'course_name' => 'VARCHAR(255) NOT NULL',
            'description' => 'TEXT NOT NULL',
            'image' => 'VARCHAR(500) NOT NULL',
            'detail_link' => 'VARCHAR(500) NOT NULL',
            'full_content' => 'LONGTEXT NULL'
        ],
        'website_activities' => [
            'title' => 'VARCHAR(255) NOT NULL',
            'description' => 'TEXT NOT NULL',
            'image' => 'VARCHAR(500) NOT NULL',
            'detail_link' => 'VARCHAR(500) NOT NULL',
            'full_content' => 'LONGTEXT NULL'
        ]
    ];

    foreach ($tables as $table => $baseColumns) {
        $columns = ['id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY'] + $baseColumns;
        foreach (['la', 'ko', 'zh'] as $language) {
            $columns[$table === 'website_courses' ? 'course_name_' . $language : 'title_' . $language] = 'VARCHAR(255) NULL';
            $columns['description_' . $language] = 'TEXT NULL';
            $columns['full_content_' . $language] = 'LONGTEXT NULL';
        }

        $definitions = [];
        foreach ($columns as $column => $definition) {
            $definitions[] = '`' . $column . '` ' . $definition;
        }
        $connection->query(
            'CREATE TABLE IF NOT EXISTS `' . $table . '` (' . implode(', ', $definitions) . ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
        );

        $check = $connection->prepare(
            'SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?'
        );
        $check->bind_param('s', $table);
        $check->execute();
        $check->bind_result($existingColumn);
        $existingColumns = [];
        while ($check->fetch()) {
            $existingColumns[$existingColumn] = true;
        }
        $check->close();

        foreach ($columns as $column => $definition) {
            if (!isset($existingColumns[$column])) {
                $connection->query('ALTER TABLE `' . $table . '` ADD COLUMN `' . $column . '` ' . $definition);
            }
        }
    }
}

function site_ensure_holiday_notice_schema(mysqli $connection)
{
    $connection->query("
        CREATE TABLE IF NOT EXISTS `website_holiday_notice` (
            `id` TINYINT UNSIGNED NOT NULL PRIMARY KEY,
            `title_en` VARCHAR(255) NOT NULL,
            `body_en` TEXT NOT NULL,
            `title_la` VARCHAR(255) NOT NULL,
            `body_la` TEXT NOT NULL,
            `title_ko` VARCHAR(255) NOT NULL,
            `body_ko` TEXT NOT NULL,
            `title_zh` VARCHAR(255) NOT NULL,
            `body_zh` TEXT NOT NULL,
            `image_one` VARCHAR(500) NOT NULL DEFAULT '',
            `image_two` VARCHAR(500) NOT NULL DEFAULT '',
            `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");

    $defaults = [
        'Holiday Announcement',
        'Please check the attached announcement images for holiday dates and details.',
        'ປະກາດວັນພັກ',
        'ກະລຸນາເບິ່ງຮູບປະກາດສຳລັບວັນພັກ ແລະ ລາຍລະອຽດ.',
        '휴일 안내',
        '휴일 날짜와 자세한 내용은 첨부된 공지 이미지를 확인해 주세요.',
        '假期通知',
        '请查看公告图片，了解假期日期和详细信息。'
    ];
    $stmt = $connection->prepare("
        INSERT IGNORE INTO `website_holiday_notice` (
            `id`, `title_en`, `body_en`, `title_la`, `body_la`,
            `title_ko`, `body_ko`, `title_zh`, `body_zh`
        ) VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        'ssssssss',
        $defaults[0],
        $defaults[1],
        $defaults[2],
        $defaults[3],
        $defaults[4],
        $defaults[5],
        $defaults[6],
        $defaults[7]
    );
    $stmt->execute();
    $stmt->close();
}

function site_ensure_course_gallery_schema(mysqli $connection)
{
    $connection->query("
        CREATE TABLE IF NOT EXISTS `website_course_gallery` (
            `id` TINYINT UNSIGNED NOT NULL PRIMARY KEY,
            `image_path` VARCHAR(500) NOT NULL,
            `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");

    $defaults = [
        1 => 'images/IMG_5213.jpg',
        2 => 'images/IMG_5217.jpg',
        3 => 'images/IMG_6656.jpg',
    ];
    $stmt = $connection->prepare("
        INSERT IGNORE INTO `website_course_gallery` (`id`, `image_path`) VALUES (?, ?)
    ");
    foreach ($defaults as $id => $imagePath) {
        $stmt->bind_param('is', $id, $imagePath);
        $stmt->execute();
    }
    $stmt->close();
}
