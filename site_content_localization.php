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
