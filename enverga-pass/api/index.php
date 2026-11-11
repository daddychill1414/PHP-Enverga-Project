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

// 2. Set environment overrides for serverless runtime (Strictly Supabase PostgreSQL)
$envVars = [
    'APP_STORAGE' => '/tmp/storage',
    'VIEW_COMPILED_PATH' => '/tmp/storage/framework/views',
    'LOG_CHANNEL' => 'stderr',
    'SESSION_DRIVER' => getenv('SESSION_DRIVER') ?: 'cookie',
    'CACHE_STORE' => 'array',
    'DB_CONNECTION' => 'pgsql',
    'DB_HOST' => getenv('DB_HOST') ?: 'aws-0-ap-southeast-1.pooler.supabase.com',
    'DB_PORT' => getenv('DB_PORT') ?: '6543',
    'DB_DATABASE' => getenv('DB_DATABASE') ?: 'postgres',
    'DB_USERNAME' => getenv('DB_USERNAME') ?: 'postgres.tphrymcpfcopqepqelds',
    'DB_PASSWORD' => getenv('DB_PASSWORD') ?: 'Ranielgina1.',
    'DB_SSLMODE' => getenv('DB_SSLMODE') ?: 'require',
    'VERCEL' => '1',
    // Point cache files to /tmp
    'APP_SERVICES_CACHE' => '/tmp/bootstrap/cache/services.php',
    'APP_PACKAGES_CACHE' => '/tmp/bootstrap/cache/packages.php',
    'APP_CONFIG_CACHE' => '/tmp/bootstrap/cache/config.php',
    'APP_ROUTES_CACHE' => '/tmp/bootstrap/cache/routes-v7.php',
    'APP_EVENTS_CACHE' => '/tmp/bootstrap/cache/events.php',
    // Mail configuration for Gmail SMTP on Vercel
    'MAIL_MAILER' => getenv('MAIL_MAILER') ?: 'smtp',
    'MAIL_HOST' => getenv('MAIL_HOST') ?: 'smtp.gmail.com',
    'MAIL_PORT' => getenv('MAIL_PORT') ?: '587',
    'MAIL_USERNAME' => getenv('MAIL_USERNAME') ?: 'ranielgoapps@gmail.com',
    'MAIL_PASSWORD' => getenv('MAIL_PASSWORD') ?: 'shzjellaslsupusb',
    'MAIL_ENCRYPTION' => getenv('MAIL_ENCRYPTION') ?: 'tls',
    'MAIL_FROM_ADDRESS' => getenv('MAIL_FROM_ADDRESS') ?: 'ranielgoapps@gmail.com',
    'MAIL_FROM_NAME' => getenv('MAIL_FROM_NAME') ?: 'Manuel S. Enverga University Foundation',
];

foreach ($envVars as $key => $val) {
    putenv("{$key}={$val}");
    $_ENV[$key] = $val;
    $_SERVER[$key] = $val;
}

// 4. Handle request
try {
    require __DIR__ . '/../vendor/autoload.php';
    /** @var \Illuminate\Foundation\Application $app */
    $app = require __DIR__ . '/../bootstrap/app.php';
    $app->useStoragePath('/tmp/storage');

    // Ensure core providers are always registered in serverless environment
    if (! $app->providerIsLoaded(\Illuminate\View\ViewServiceProvider::class)) {
        $app->register(\Illuminate\View\ViewServiceProvider::class);
    }
    if (! $app->providerIsLoaded(\Illuminate\Database\DatabaseServiceProvider::class)) {
        $app->register(\Illuminate\Database\DatabaseServiceProvider::class);
    }
    if (! $app->providerIsLoaded(\Illuminate\Mail\MailServiceProvider::class)) {
        $app->register(\Illuminate\Mail\MailServiceProvider::class);
    }
    if (! $app->providerIsLoaded(\Illuminate\Session\SessionServiceProvider::class)) {
        $app->register(\Illuminate\Session\SessionServiceProvider::class);
    }

    $app->handleRequest(\Illuminate\Http\Request::capture());
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<h1>EnvergaPass Serverless Exception</h1>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (Line " . $e->getLine() . ")</p>";
    echo "<pre style='background:#f4f4f4;padding:15px;border-radius:5px;overflow:auto;font-size:12px;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
