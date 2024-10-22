<?php

$files = [
    'index.php' => '<?php
session_start();
require_once \'core/config.php\';
require_once \'core/functions.php\';
require_once \'core/Router.php\';

$router = new Router();
$router->route();
?>',
    '.htaccess' => 'RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]',
    'core/config.php' => '<?php
define(\'DB_FILE\', __DIR__ . \'/../database.sqlite\');
define(\'SITE_URL\', \'http://localhost:8080\'); // Измените на ваш URL
define(\'ADMIN_EMAIL\', \'admin@example.com\');

// Настройки для PDO SQLite
$pdo = new PDO(\'sqlite:\' . DB_FILE);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Создание таблиц, если они не существуют
$pdo->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT UNIQUE,
    password TEXT,
    is_admin INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS pages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT,
    slug TEXT UNIQUE,
    content TEXT,
    template TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS custom_fields (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    page_id INTEGER,
    name TEXT,
    value TEXT,
    FOREIGN KEY (page_id) REFERENCES pages(id)
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    page_id INTEGER,
    user_id INTEGER,
    content TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (page_id) REFERENCES pages(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
)");
?>',
    // ... добавьте остальные файлы здесь
];

foreach ($files as $path => $content) {
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    file_put_contents($path, $content);
    echo "Created file: $path\n";
}

echo "All files have been generated successfully.\n";
?>