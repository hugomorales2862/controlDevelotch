<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\Schema;

Schema::dropIfExists('sales');
Schema::dropIfExists('subscriptions');
Schema::dropIfExists('expenses');
Schema::dropIfExists('services');
Schema::dropIfExists('clients');
echo "Done dropping.\n";
