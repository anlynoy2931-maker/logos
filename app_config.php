<?php

function site_config(): array
{
    static $config;
    if (isset($config)) {
        return $config;
    }

    $config = [
        'db_host' => 'localhost',
        'db_username' => 'root',
        'db_password' => '',
        'db_name' => 'exam_registration',
        'website_db_host' => 'localhost',
        'website_db_username' => 'root',
        'website_db_password' => '',
        'website_db_name' => 'exam_registration',
        'admin_username' => '',
        'admin_password' => '',
    ];

    $localConfigFile = __DIR__ . '/config.local.php';
    if (is_file($localConfigFile)) {
        $localConfig = require $localConfigFile;
        if (!is_array($localConfig)) {
            throw new RuntimeException('config.local.php must return an array.');
        }
        $config = array_merge($config, $localConfig);
    }

    $environmentVariables = [
        'db_host' => 'DB_HOST',
        'db_username' => 'DB_USERNAME',
        'db_password' => 'DB_PASSWORD',
        'db_name' => 'DB_NAME',
        'website_db_host' => 'WEBSITE_DB_HOST',
        'website_db_username' => 'WEBSITE_DB_USERNAME',
        'website_db_password' => 'WEBSITE_DB_PASSWORD',
        'website_db_name' => 'WEBSITE_DB_NAME',
        'admin_username' => 'ADMIN_USERNAME',
        'admin_password' => 'ADMIN_PASSWORD',
    ];

    foreach ($environmentVariables as $key => $environmentVariable) {
        $value = getenv($environmentVariable);
        if ($value !== false) {
            $config[$key] = $value;
        }
    }

    return $config;
}

function site_admin_is_configured(): bool
{
    $config = site_config();
    return $config['admin_username'] !== '' && $config['admin_password'] !== '';
}

function site_admin_authenticate(string $username, string $password): bool
{
    if (!site_admin_is_configured()) {
        return false;
    }

    $config = site_config();
    return hash_equals($config['admin_username'], $username)
        && hash_equals($config['admin_password'], $password);
}
