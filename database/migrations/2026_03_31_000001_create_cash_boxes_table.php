<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_boxes', function (Blueprint $table) {
            $table->id();
            $table->string('concepto');
            $table->decimal('monto', 15, 2);
            $table->enum('tipo', ['ingreso', 'egreso']);
            $table->decimal('saldo_anterior', 15, 2)->default(0);
            $table->decimal('saldo_nuevo', 15, 2)->default(0);

            // Polimorfismo: puede venir de un Payment, Subscription, gasto manual, etc.
            $table->nullableMorphs('cashable');

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_boxes');
    }
};
