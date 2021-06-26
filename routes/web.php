<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\TrackRecordController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PayBillController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CapitalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->name('dashboard');

// ;

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    // Dashboard routes
    // Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard.index');
    //trucks routes
    Route::get('/trucks', [TruckController::class, 'index'])->name('trucks.index');
    Route::post('/trucks', [TruckController::class, 'store'])->name('trucks.store');
    Route::post('/trucks/{id}', [TruckController::class, 'update'])->name('trucks.update');
    Route::delete('/trucks/{id}', [TruckController::class, 'destroy'])->name('trucks.destroy');
    // track record routes
    Route::get('/track-record', [TrackRecordController::class, 'index'])->name('track-record.index');
    Route::post('/track-record', [TrackRecordController::class, 'store'])->name('track-record.store');
    Route::post('/track-record/{id}', [TrackRecordController::class, 'update'])->name('track-record.update');
    Route::delete('/track-record/{id}', [TrackRecordController::class, 'destroy'])->name('track-record.destroy');
    // drivers routes
    Route::get('/drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::post('/drivers', [DriverController::class, 'store'])->name('drivers.store');
    Route::post('/drivers/{id}', [DriverController::class, 'update'])->name('drivers.update');
    Route::delete('/drivers/{id}', [DriverController::class, 'destroy'])->name('drivers.destroy');
    // clients routes
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::post('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
    // regions routes
    Route::get('/regions', [RegionController::class, 'index'])->name('regions.index');
    Route::post('/regions', [RegionController::class, 'store'])->name('regions.store');
    Route::post('/regions/{id}', [RegionController::class, 'update'])->name('regions.update');
    Route::delete('/regions/{id}', [RegionController::class, 'destroy'])->name('regions.destroy');
    // expenses routes
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::post('/expenses/{id}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    // bills routes
    Route::get('/bills', [PayBillController::class, 'index'])->name('bills.index');
    Route::post('/bills', [PayBillController::class, 'store'])->name('bills.store');
    Route::post('/bills/{id}', [PayBillController::class, 'update'])->name('bills.update');
    Route::delete('/bills/{id}', [PayBillController::class, 'destroy'])->name('bills.destroy');
    // invoices routes
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::post('/invoices/{id}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
    // capital routes
    Route::get('/capital', [CapitalController::class, 'index'])->name('capital.index');
    Route::post('/capital', [CapitalController::class, 'store'])->name('capital.store');
    Route::post('/capital/{id}', [CapitalController::class, 'update'])->name('capital.update');
    Route::get('/capital/{id}', [CapitalController::class, 'show'])->name('capital.show');
    // report routes
    Route::get('/report', [InvoiceController::class, 'index'])->name('report.index');
    Route::post('/report', [InvoiceController::class, 'store'])->name('report.store');
    Route::post('/report/{id}', [InvoiceController::class, 'update'])->name('report.update');
    Route::get('/report/{id}', [InvoiceController::class, 'show'])->name('report.show');
});
