<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vps_servers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider');
            $table->string('ip_address')->nullable();
            $table->string('region')->nullable();
            $table->json('details')->nullable();
            $table->timestamps();
        });

        Schema::create('server_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vps_server_id')->constrained('vps_servers')->cascadeOnDelete();
            $table->string('username');
            $table->text('password'); // cifrado a nivel aplicación
            $table->text('ssh_key')->nullable();
            $table->timestamps();
        });

        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients', 'cli_id')->cascadeOnDelete();
            $table->string('name')->unique();
            $table->date('expires_at')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients', 'cli_id')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('subject');
            $table->text('description');
            $table->enum('status', ['new', 'open', 'pending', 'resolved', 'closed'])->default('new');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->timestamps();
        });

        Schema::create('ticket_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_messages');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('domains');
        Schema::dropIfExists('server_credentials');
        Schema::dropIfExists('vps_servers');
    }
};