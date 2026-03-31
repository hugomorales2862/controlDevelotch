<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prospects', function (Blueprint $table) {
            // Rename columns to match controller if they exist
            if (Schema::hasColumn('prospects', 'name')) {
                $table->renameColumn('name', 'contact_name');
            }
            if (Schema::hasColumn('prospects', 'company')) {
                $table->renameColumn('company', 'company_name');
            }
            
            // Add missing columns
            $table->string('address')->nullable()->after('phone');
            $table->string('city', 100)->nullable()->after('address');
            $table->string('country', 100)->nullable()->after('city');
            $table->string('website')->nullable()->after('country');
            $table->string('industry', 100)->nullable()->after('website');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('prospects', function (Blueprint $table) {
            $table->renameColumn('contact_name', 'name');
            $table->renameColumn('company_name', 'company');
            $table->dropColumn(['address', 'city', 'country', 'website', 'industry', 'created_by']);
        });
    }
};
