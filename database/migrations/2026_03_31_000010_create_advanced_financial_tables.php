<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('cash_boxes')) {
            Schema::create('cash_boxes', function (Blueprint $table) {
                $table->id();
                $table->string('concepto');
                $table->decimal('monto', 15, 2);
                $table->enum('tipo', ['ingreso', 'egreso']);
                $table->decimal('saldo_anterior', 15, 2)->default(0);
                $table->decimal('saldo_nuevo', 15, 2)->default(0);
                $table->nullableMorphs('cashable');
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->text('notas')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('payment_receipts')) {
            Schema::create('payment_receipts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('payment_id')->unique()->constrained()->cascadeOnDelete();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('client_id')->constrained('clients', 'cli_id')->cascadeOnDelete();
                $table->foreignId('cash_box_id')->nullable()->constrained('cash_boxes')->nullOnDelete();
                $table->string('number')->unique();
                $table->decimal('amount', 15, 2);
                $table->string('currency', 3)->default('USD');
                $table->string('concept')->nullable();
                $table->string('status')->default('emitido');
                $table->timestamp('printed_at')->nullable();
                $table->json('metadata')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'receipt_number')) {
                $table->string('receipt_number')->nullable()->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('receipt_number');
        });
        Schema::dropIfExists('payment_receipts');
        Schema::dropIfExists('cash_boxes');
    }
};
