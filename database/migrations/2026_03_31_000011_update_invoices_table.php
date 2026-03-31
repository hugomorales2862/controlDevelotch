<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Rename columns to match InvoiceController if they exist with different names
            if (Schema::hasColumn('invoices', 'number')) {
                $table->renameColumn('number', 'invoice_number');
            }
            
            // Add missing columns as per InvoiceController
            if (!Schema::hasColumn('invoices', 'tax_rate')) {
                $table->decimal('tax_rate', 5, 2)->default(0)->after('due_date');
            }
            if (!Schema::hasColumn('invoices', 'discount')) {
                $table->decimal('discount', 15, 2)->default(0)->after('tax_rate');
            }
            if (!Schema::hasColumn('invoices', 'notes')) {
                $table->text('notes')->nullable()->after('metadata');
            }
            if (!Schema::hasColumn('invoices', 'items')) {
                $table->json('items')->nullable()->after('notes');
            }
            
            // Ensure status enum matches controller
            // current: ['draft', 'sent', 'paid', 'partial', 'overdue']
            // controller: ['draft', 'sent', 'paid', 'overdue', 'cancelled']
            // We'll keep the union: ['draft', 'sent', 'paid', 'partial', 'overdue', 'cancelled']
        });
        
        // Update enum via raw SQL if necessary, but for dev we'll just add cancelled
        DB::statement("ALTER TABLE invoices MODIFY COLUMN status ENUM('draft', 'sent', 'paid', 'partial', 'overdue', 'cancelled') DEFAULT 'draft'");
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['tax_rate', 'discount', 'notes', 'items']);
            if (Schema::hasColumn('invoices', 'invoice_number')) {
                $table->renameColumn('invoice_number', 'number');
            }
        });
    }
};
