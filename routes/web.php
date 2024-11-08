<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route for dashboard based on the role of the logged-in user
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
 // Company Routes
 // Routes for company profile
 Route::get('/company/edit', [CompanyController::class, 'edit'])->name('company.edit');
 Route::patch('/company/update', [CompanyController::class, 'update'])->name('company.update');

    
});

//company routes
Route::middleware(['auth'])->group(function () {
    Route::get('/register-company', [CompanyController::class, 'create'])->name('register.company');
    Route::post('/register-company', [CompanyController::class, 'store'])->name('company.store');
});


//invoices routes
Route::get('/invoices', [InvoiceController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('invoices');
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
Route::get('invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
Route::post('invoices', [InvoiceController::class, 'store'])->name('invoices.store');
Route::get('/invoices/choose-template/{invoiceId}', [InvoiceController::class, 'chooseTemplate'])->name('invoices.chooseTemplate');
Route::post('/invoices/generate-pdf/{invoiceId}', [InvoiceController::class, 'generatePDF'])->name('invoices.generatePDF');
Route::post('/invoices/{id}/update-status', [InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus');
Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

Route::post('/invoices/update-status', [InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus');
Route::get('/invoices/{invoiceId}/preview', [InvoiceController::class, 'preview'])->name('invoices.preview');
Route::put('/invoices/{id}/update-type', [InvoiceController::class, 'updateInvoiceType'])->name('invoices.updateType');
Route::post('/client/update', [ClientController::class, 'update'])->name('client.update');


require __DIR__.'/auth.php';
