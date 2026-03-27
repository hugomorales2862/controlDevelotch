<?php
use Illuminate\Support\Facades\Schema;

Schema::dropIfExists('sales');
Schema::dropIfExists('subscriptions');
Schema::dropIfExists('expenses');
Schema::dropIfExists('services');
Schema::dropIfExists('clients');
echo "Tables dropped successfully.\n";
