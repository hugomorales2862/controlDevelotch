<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vps_servers', function (Blueprint $table) {
            // Add missing columns as per VpsServerController
            if (!Schema::hasColumn('vps_servers', 'client_id')) {
                $table->foreignId('client_id')->nullable()->constrained('clients', 'cli_id')->cascadeOnDelete()->after('id');
            }
            if (!Schema::hasColumn('vps_servers', 'os')) {
                $table->string('os')->nullable()->after('ip_address');
            }
            if (!Schema::hasColumn('vps_servers', 'cpu_cores')) {
                $table->integer('cpu_cores')->default(1)->after('os');
            }
            if (!Schema::hasColumn('vps_servers', 'ram_gb')) {
                $table->integer('ram_gb')->default(1)->after('cpu_cores');
            }
            if (!Schema::hasColumn('vps_servers', 'storage_gb')) {
                $table->integer('storage_gb')->default(10)->after('ram_gb');
            }
            if (!Schema::hasColumn('vps_servers', 'status')) {
                $table->string('status')->default('active')->after('storage_gb');
            }
            if (!Schema::hasColumn('vps_servers', 'monthly_cost')) {
                $table->decimal('monthly_cost', 15, 2)->default(0)->after('status');
            }
            if (!Schema::hasColumn('vps_servers', 'setup_date')) {
                $table->date('setup_date')->nullable()->after('monthly_cost');
            }
            if (!Schema::hasColumn('vps_servers', 'expiry_date')) {
                $table->date('expiry_date')->nullable()->after('setup_date');
            }
            if (!Schema::hasColumn('vps_servers', 'notes')) {
                $table->text('notes')->nullable()->after('expiry_date');
            }
            if (!Schema::hasColumn('vps_servers', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->after('notes');
            }
            
            // Rename 'name' to 'hostname' if needed (optional since we added hostname)
            // But hostname is unique in controller.
        });
    }

    public function down(): void
    {
        Schema::table('vps_servers', function (Blueprint $table) {
            $table->dropColumn([
                'client_id', 'hostname', 'os', 'cpu_cores', 'ram_gb', 
                'storage_gb', 'monthly_cost', 'setup_date', 'expiry_date', 
                'notes', 'created_by'
            ]);
        });
    }
};
