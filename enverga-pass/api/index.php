<?php

// 1. Prepare writable directories in /tmp for Vercel's read-only serverless environment
$dirs = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// 2. Override environment variables for serverless compatibility
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
$_ENV['APP_STORAGE'] = '/tmp/storage';
$_ENV['LOG_CHANNEL'] = 'stderr'; // Write logs directly to Vercel console, avoiding read-only file write
$_ENV['SESSION_DRIVER'] = 'cookie'; // Avoid database/file session table requirement on serverless
$_ENV['CACHE_STORE'] = 'array';

putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
putenv('APP_STORAGE=/tmp/storage');
putenv('LOG_CHANNEL=stderr');
putenv('SESSION_DRIVER=cookie');
putenv('CACHE_STORE=array');

// 3. Setup SQLite database in /tmp
$sqliteSource = __DIR__ . '/../database/database.sqlite';
$sqliteTarget = '/tmp/database.sqlite';

if (!file_exists($sqliteTarget)) {
    if (file_exists($sqliteSource)) {
        @copy($sqliteSource, $sqliteTarget);
    } else {
        @touch($sqliteTarget);
    }
}

$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = $sqliteTarget;
putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=' . $sqliteTarget);

// 4. Forward request to Laravel public/index.php
require __DIR__ . '/../public/index.php';
