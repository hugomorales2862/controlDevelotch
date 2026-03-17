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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->string('nombre');
            $table->string('tipo'); // hosting, aplicaciones, etc.
            $table->text('descripcion')->nullable();
            $table->date('fecha_inicio');
            $table->decimal('precio_mensual', 10, 2);
            $table->integer('dia_pago');
            $table->enum('estado', ['activo', 'suspendido', 'cancelado'])->default('activo');
            
            // Datos Técnicos / Infraestructura
            $table->string('proveedor')->nullable(); 
            $table->string('ip_servidor')->nullable();
            $table->string('so')->nullable(); // Sistema Operativo
            $table->string('panel_control')->nullable();
            $table->string('dominio')->nullable();
            $table->string('proveedor_dominio')->nullable();
            $table->date('fecha_vencimiento_dominio')->nullable();
            $table->string('proveedor_dns')->nullable();
            $table->text('registros_dns')->nullable();
            $table->string('tipo_db')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
