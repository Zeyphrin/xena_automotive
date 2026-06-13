<?php

// 1. Memaksa Laravel memindahkan semua file cache internal ke folder /tmp
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_EVENTS_CACHE=/tmp/events.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('VIEW_COMPILED_PATH=/tmp');

// 2. Memastikan driver yang digunakan ramah Serverless
putenv('CACHE_DRIVER=array');
putenv('LOG_CHANNEL=stderr');
putenv('SESSION_DRIVER=cookie');

// 3. Menjalankan Laravel seperti biasa
require __DIR__ . '/../public/index.php';