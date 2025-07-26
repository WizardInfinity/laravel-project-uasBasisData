<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "Running setup commands...\n";
$kernel->call('config:cache');
$kernel->call('route:cache');
$kernel->call('view:cache');
echo "Setup completed!\n";