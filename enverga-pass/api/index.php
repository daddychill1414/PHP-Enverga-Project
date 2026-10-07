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
        mkdir($dir, 0755, true);
    }
}

// 2. Set environment overrides for serverless
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
putenv('APP_STORAGE=/tmp/storage');
putenv('APP_SERVICES_CACHE=/tmp/bootstrap/cache/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/bootstrap/cache/packages.php');
putenv('APP_CONFIG_CACHE=/tmp/bootstrap/cache/config.php');
putenv('APP_ROUTES_CACHE=/tmp/bootstrap/cache/routes.php');
putenv('APP_EVENTS_CACHE=/tmp/bootstrap/cache/events.php');

// 3. Setup SQLite database in /tmp if not already present
$sqliteSource = __DIR__ . '/../database/database.sqlite';
$sqliteTarget = '/tmp/database.sqlite';

if (!file_exists($sqliteTarget)) {
    if (file_exists($sqliteSource)) {
        copy($sqliteSource, $sqliteTarget);
    } else {
        touch($sqliteTarget);
    }
}

putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=' . $sqliteTarget);

// 4. Forward request to Laravel public/index.php
require __DIR__ . '/../public/index.php';
