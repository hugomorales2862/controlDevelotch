<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'priority')) {
                $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->after('status');
            }
            if (!Schema::hasColumn('projects', 'due_date')) {
                $table->date('due_date')->nullable()->after('start_date');
            }
            if (!Schema::hasColumn('projects', 'budget')) {
                $table->decimal('budget', 15, 2)->nullable()->after('due_date');
            }
            if (!Schema::hasColumn('projects', 'assigned_to')) {
                $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete()->after('budget');
            }
            if (!Schema::hasColumn('projects', 'notes')) {
                $table->text('notes')->nullable()->after('description');
            }
            if (!Schema::hasColumn('projects', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->after('assigned_to');
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['priority', 'due_date', 'budget', 'assigned_to', 'notes', 'user_id']);
        });
    }
};
