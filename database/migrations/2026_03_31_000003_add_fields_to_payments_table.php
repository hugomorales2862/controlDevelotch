<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Quién registró el pago
            $table->foreignId('user_id')->nullable()->after('bank_account_id')
                  ->constrained()->nullOnDelete();
            // Suscripción que originó el cobro (opcional, para cobros recurrentes)
            $table->foreignId('subscription_id')->nullable()->after('user_id')
                  ->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropConstrainedForeignId('subscription_id');
        });
    }
};
