<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProspectController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\VpsServerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\PettyCashController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'role:admin|staff'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('clients', \App\Http\Controllers\ClientController::class);
    Route::resource('applications', \App\Http\Controllers\ApplicationController::class);
    Route::resource('services', \App\Http\Controllers\ServiceController::class);
    Route::resource('subscriptions', SubscriptionController::class);
    Route::resource('sales', SaleController::class);
    Route::resource('expenses', ExpenseController::class);
    
    // Commercial Module
    Route::resource('prospects', ProspectController::class);
    Route::post('prospects/{prospect}/convert', [ProspectController::class, 'convertToClient'])->name('prospects.convert');
    Route::resource('quotes', QuoteController::class);
    Route::post('quotes/{quote}/send', [QuoteController::class, 'send'])->name('quotes.send');
    Route::post('quotes/{quote}/approve', [QuoteController::class, 'approve'])->name('quotes.approve');
    Route::post('quotes/{quote}/reject', [QuoteController::class, 'reject'])->name('quotes.reject');
    Route::get('quotes/{quote}/pdf', [QuoteController::class, 'pdf'])->name('quotes.pdf');
    
    // Operations Module
    Route::resource('projects', ProjectController::class);
    Route::resource('tasks', TaskController::class);
    Route::post('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
    
    // Contacts Module (nested under clients)
    Route::resource('clients.contacts', \App\Http\Controllers\ContactController::class);

    // Users & Roles Module (Administración)
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('roles', \App\Http\Controllers\RoleController::class);

    // Hosting/SaaS Module
    Route::resource('servers', VpsServerController::class);
    Route::resource('credentials', \App\Http\Controllers\ServerCredentialController::class);
    
    // Financial Module
    Route::resource('invoices', InvoiceController::class);
    Route::post('invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('invoices.send');
    Route::post('invoices/{invoice}/mark-paid', [InvoiceController::class, 'markAsPaid'])->name('invoices.mark-paid');
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'generatePdf'])->name('invoices.pdf');
    Route::resource('payments', PaymentController::class);
    Route::get('payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
    Route::get('payments/{payment}/receipt/pdf', [PaymentController::class, 'receiptPdf'])->name('payments.receipt.pdf');
    Route::post('payments/egreso', [PaymentController::class, 'egreso'])->name('payments.egreso');

    // Soporte / Tickets
    Route::resource('tickets', \App\Http\Controllers\TicketController::class);
    Route::post('tickets/{ticket}/add-message', [\App\Http\Controllers\TicketController::class, 'addMessage'])->name('tickets.add-message');
    
    // Domains
    Route::resource('domains', \App\Http\Controllers\DomainController::class);
    Route::resource('bank-accounts', BankAccountController::class);
    Route::resource('petty-cash', PettyCashController::class);
    
    // Audit Module
    Route::resource('audit-logs', AuditLogController::class)->only(['index', 'show']);
    
    // Emails Module
    Route::resource('emails', EmailController::class)->only(['create', 'store', 'index']);
    
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de Autenticación de Cliente (Token-based)
Route::prefix('ayuda')->group(function () {
    Route::get('/login', [ClientAuthController::class, 'showLoginForm'])->name('client.auth.login');
    Route::post('/send-token', [ClientAuthController::class, 'sendToken'])->name('client.auth.send-token');
    Route::get('/verificar', [ClientAuthController::class, 'showVerifyForm'])->name('client.auth.verify');
    Route::post('/verificar', [ClientAuthController::class, 'verifyToken'])->name('client.auth.verify.post');
    Route::post('/logout', [ClientAuthController::class, 'logout'])->name('client.auth.logout');
});

// Portal del Cliente
Route::middleware(['auth', 'role:client|admin|staff'])->prefix('portal')->group(function () {
    Route::get('/', [PortalController::class, 'dashboard'])->name('portal.dashboard');
    Route::get('/tickets', [PortalController::class, 'tickets'])->name('portal.tickets');
    Route::post('/tickets/new', [PortalController::class, 'createTicket'])->name('portal.tickets.create');
    Route::get('/tickets/{ticket}', [PortalController::class, 'showTicket'])->name('portal.tickets.show');
    Route::post('/tickets/{ticket}/message', [PortalController::class, 'addMessage'])->name('portal.tickets.message');
    Route::post('/tickets/{ticket}/select-handler', [PortalController::class, 'selectHandler'])->name('portal.tickets.select-handler');
    
    // Secciones futuras
    Route::get('/facturas', [PortalController::class, 'invoices'])->name('portal.invoices');
    Route::get('/pagos', [PortalController::class, 'payments'])->name('portal.payments');
});

require __DIR__.'/auth.php';
