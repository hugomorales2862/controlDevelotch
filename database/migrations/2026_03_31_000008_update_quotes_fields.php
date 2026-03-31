<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            if (!Schema::hasColumn('quotes', 'title')) {
                $table->string('title')->nullable()->after('reference');
            }
            if (!Schema::hasColumn('quotes', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
            if (!Schema::hasColumn('quotes', 'valid_until')) {
                $table->date('valid_until')->nullable()->after('description');
            }
            if (!Schema::hasColumn('quotes', 'notes')) {
                $table->text('notes')->nullable()->after('valid_until');
            }
            // Ensure status can handle all controller types
            $table->string('status')->default('draft')->change();
        });

        Schema::table('quote_items', function (Blueprint $table) {
            if (!Schema::hasColumn('quote_items', 'unit_price')) {
                 $table->decimal('unit_price', 15, 2)->after('quantity');
            }
            // Allow null service_id if it's a custom item
            $table->foreignId('service_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'valid_until', 'notes']);
        });
    }
};
