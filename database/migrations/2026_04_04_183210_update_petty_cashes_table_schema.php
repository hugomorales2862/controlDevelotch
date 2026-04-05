<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('petty_cashes', function (Blueprint $table) {
            $table->enum('type', ['income', 'expense'])->default('expense')->after('amount');
            $table->string('category', 100)->nullable()->after('type');
            $table->string('description', 255)->nullable()->after('category');
            $table->string('receipt_number', 50)->nullable()->after('description');
            $table->decimal('balance', 15, 2)->default(0)->after('receipt_number');
            $table->date('transaction_date')->nullable()->after('balance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('petty_cashes', function (Blueprint $table) {
            $table->dropColumn(['type', 'category', 'description', 'receipt_number', 'balance', 'transaction_date']);
        });
    }
};
