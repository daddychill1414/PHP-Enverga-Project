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

// 2. Setup SQLite database in /tmp
$sqliteSource = __DIR__ . '/../database/database.sqlite';
$sqliteTarget = '/tmp/database.sqlite';

if (!file_exists($sqliteTarget) || filesize($sqliteTarget) === 0) {
    if (file_exists($sqliteSource) && filesize($sqliteSource) > 0) {
        @copy($sqliteSource, $sqliteTarget);
    } else {
        @touch($sqliteTarget);
    }
}

// 3. Set environment overrides for serverless runtime
$envVars = [
    'APP_STORAGE' => '/tmp/storage',
    'VIEW_COMPILED_PATH' => '/tmp/storage/framework/views',
    'LOG_CHANNEL' => 'stderr',
    'SESSION_DRIVER' => 'cookie',
    'CACHE_STORE' => 'array',
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => $sqliteTarget,
];

foreach ($envVars as $key => $val) {
    putenv("{$key}={$val}");
    $_ENV[$key] = $val;
    $_SERVER[$key] = $val;
}

// 4. Custom error catcher so we see exact error instead of generic 500
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// 5. Forward request to Laravel public/index.php
require __DIR__ . '/../public/index.php';
