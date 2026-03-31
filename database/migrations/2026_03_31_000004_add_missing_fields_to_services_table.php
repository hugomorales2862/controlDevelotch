<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Solo agregar si no existen aún
            if (!Schema::hasColumn('services', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('services', 'type')) {
                $table->string('type')->nullable()->after('features');
            }
            if (!Schema::hasColumn('services', 'billing_cycle')) {
                $table->string('billing_cycle')->nullable()->after('type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumnIfExists('description');
            $table->dropColumnIfExists('type');
            $table->dropColumnIfExists('billing_cycle');
        });
    }
};
