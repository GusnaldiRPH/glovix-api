<?php

// Mengalihkan direktori storage Laravel ke folder /tmp Vercel
$exec = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($exec as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

require __DIR__ . '/../public/index.php';
