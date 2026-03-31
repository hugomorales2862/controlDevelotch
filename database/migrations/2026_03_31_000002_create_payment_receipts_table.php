<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_receipts', function (Blueprint $table) {
            $table->id();

            // Número correlativo único: DT-2026-00001
            $table->string('number')->unique();

            $table->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // cajero que emitió
            $table->foreignId('client_id')->constrained('clients', 'cli_id')->cascadeOnDelete();
            $table->foreignId('cash_box_id')->nullable()->constrained()->nullOnDelete(); // entrada en caja

            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('GTQ');
            $table->text('concept'); // Ej: "Hosting VPS Pro - Enero 2026"
            $table->enum('status', ['emitido', 'anulado'])->default('emitido');
            $table->timestamp('printed_at')->nullable();
            $table->json('metadata')->nullable(); // datos del servicio pagado, etc.

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_receipts');
    }
};
