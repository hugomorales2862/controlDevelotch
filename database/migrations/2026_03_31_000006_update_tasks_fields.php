<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Fix status enum to match TaskController
            $table->string('status')->default('pending')->change();
            
            if (!Schema::hasColumn('tasks', 'priority')) {
                $table->string('priority')->default('medium')->after('status');
            } else {
                $table->string('priority')->default('medium')->change();
            }

            if (!Schema::hasColumn('tasks', 'estimated_hours')) {
                $table->decimal('estimated_hours', 8, 2)->nullable()->after('due_date');
            }
            if (!Schema::hasColumn('tasks', 'actual_hours')) {
                $table->decimal('actual_hours', 8, 2)->nullable()->after('estimated_hours');
            }
            if (!Schema::hasColumn('tasks', 'notes')) {
                $table->text('notes')->nullable()->after('description');
            }
            if (!Schema::hasColumn('tasks', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->after('assigned_to');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['estimated_hours', 'actual_hours', 'notes', 'user_id']);
        });
    }
};
