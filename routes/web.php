<?php

use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PrintReportController;
use App\Http\Controllers\ReportExcelController;
use App\Http\Livewire\Account\Setting\SettingComponent;
use App\Http\Livewire\Configuration\Sell\SellSettingsComponent;
use App\Http\Livewire\Configuration\User\UserComponent;
use App\Http\Livewire\Expences\Expences\AddExpencesComponent;
use App\Http\Livewire\Expences\Expences\EditExpencesComponent;
use App\Http\Livewire\Expences\Expences\ExpencesComponent;
use App\Http\Livewire\Inventory\Batch\AddBatchComponent;
use App\Http\Livewire\Inventory\Batch\BatchComponent;
use App\Http\Livewire\Inventory\Batch\BatchedProductComponent;
use App\Http\Livewire\Inventory\Batch\EditBatchedProductComponent;
use App\Http\Livewire\Inventory\Category\CategoryComponent;
use App\Http\Livewire\Inventory\Product\ProductComponent;
use App\Http\Livewire\Inventory\Supplier\SupplerLedgerComponent;
use App\Http\Livewire\Inventory\Supplier\SupplierComponent;
use App\Http\Livewire\Inventory\Unit\UnitComponent;
use App\Http\Livewire\Reports\DueSellsReport\DueSellsReportComponent;
use App\Http\Livewire\Reports\ProfitLossReport\ProfitLossReportComponent;
use App\Http\Livewire\Reports\SellReport\SellReportComponent;
use App\Http\Livewire\Reports\StockReport\StockReportComponent;
use App\Http\Livewire\Sell\Customer\CustomerComponent;
use App\Http\Livewire\Sell\Customer\CustomerLedgerComponent;
use App\Http\Livewire\Sell\Payment\PaymentMethodComponent;
use App\Http\Livewire\Sell\Refund\RefundComponent;
use App\Http\Livewire\Sell\Sell\SellComponent;
use App\Http\Livewire\Sell\Sell\SellRecordComponent;
use Illuminate\Support\Facades\Route;

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
    // return view('welcome');
    return redirect()->route('login');
});

Route::get('/inactive', function () {
    return view('livewire.dashboard.inactive');
})->name('inactive');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified','auth.cashier'
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    //Cashier , Manager, Admin --------------------------------------------------------------------
        // Sell---------------------------------------------------------------------------------
        // Customers-------------------------------------------------------------------------
        Route::get('/customers', CustomerComponent::class)->name('customers');
        Route::get('/customers_ledger/{id}', CustomerLedgerComponent::class)->name('customers_ledger');

        // // Payment Method-------------------------------------------------------------------------
        // Route::get('/payment_method', PaymentMethodComponent::class)->name('payment_method');

        // Sell-------------------------------------------------------------------------
        Route::get('/make_sell', SellComponent::class)->name('make_sell');
        Route::get('/sell_record', SellRecordComponent::class)->name('sell_record');

        // // Refund-------------------------------------------------------------------------
        // Route::get('/refund', RefundComponent::class)->name('refund');

    // Sell---------------------------------------------------------------------------------

    //Cashier , Manager, Admin --------------------------------------------------------------------

    Route::get('/invoice', function () {
        return view('livewire.sell.sell.invoice');
    })->name('invoice');
    // Invoice ------------------------------------------------------------------------------------
    Route::get('/old_invoice/{id}', [InvoiceController::class, 'old_invoice'])->name('old_invoice');
    Route::get('/new_invoice/{id}', [InvoiceController::class, 'new_invoice'])->name('new_invoice');


    // Settings-------------------------------------------------------------------------------------
    Route::get('/account_settings', SettingComponent::class)->name('account_settings');
    // Settings-------------------------------------------------------------------------------------


    // Admin and Manager route group
    Route::middleware(['auth','auth.manager'])->group(function(){

        // dashboard route
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // inventory---------------------------------------------------------------------------------
        // Category--------------------
        Route::get('/category', CategoryComponent::class)->name('category');
        // Supplier--------------------
        Route::get('/suppliers', SupplierComponent::class)->name('suppliers');
        Route::get('/suppliers_ledger/{id}', SupplerLedgerComponent::class)->name('suppliers_ledger');

        // Unit----------------------------------------------------------------------
        Route::get('/units', UnitComponent::class)->name('units');

        // Batch----------------------------------------------------------------------
        Route::get('/batches', BatchComponent::class)->name('batches');
        Route::get('/add_batch', AddBatchComponent::class)->name('add_batch');
        Route::get('/batched_products/{id}', BatchedProductComponent::class)->name('batched_products');
        Route::get('/edit_batched_products/{id}', EditBatchedProductComponent::class)->name('edit_batched_products');

        // Products----------------------------------------------------------------------
        Route::get('/products', ProductComponent::class)->name('products');
        Route::get('/barcode/{id}', [BarcodeController::class, 'index'])->name('barcode');

    // inventory---------------------------------------------------------------------------------

    // // Sell---------------------------------------------------------------------------------
    //     // Customers-------------------------------------------------------------------------
    //     Route::get('/customers', CustomerComponent::class)->name('customers');
    //     Route::get('/customers_ledger/{id}', CustomerLedgerComponent::class)->name('customers_ledger');

        // Payment Method-------------------------------------------------------------------------
        Route::get('/payment_method', PaymentMethodComponent::class)->name('payment_method');

    //     // Sell-------------------------------------------------------------------------
    //     Route::get('/make_sell', SellComponent::class)->name('make_sell');
    //     Route::get('/sell_record', SellRecordComponent::class)->name('sell_record');

        // // Refund-------------------------------------------------------------------------
        Route::get('/refund', RefundComponent::class)->name('refund');

    // // Sell---------------------------------------------------------------------------------

    // Expences---------------------------------------------------------------------------------
        Route::get('/expences', ExpencesComponent::class)->name('expences');
        Route::get('/add_expences', AddExpencesComponent::class)->name('add_expences');
        Route::get('/edit_expences/{id}', EditExpencesComponent::class)->name('edit_expences');
    // Expences---------------------------------------------------------------------------------

    // Report---------------------------------------------------------------------------------
        // Sell report-------------------------------------------------------------------------
        Route::get('/sell_report', SellReportComponent::class)->name('sell_report');
        Route::get('/sell_report_pdf/{from}/{to}/{flag?}', [PrintReportController::class , 'sell_report'])->name('sell_report_pdf');
        Route::get('/sell_report_excel/{from}/{to}/{flag?}', [ReportExcelController::class , 'sell_report'])->name('sell_report_excel');
        // Due Sell report-------------------------------------------------------------------------
        Route::get('/due_sell_report', DueSellsReportComponent::class)->name('due_sell_report');
        Route::get('/due_sell_report_pdf/{from}/{to}/{flag?}', [PrintReportController::class , 'due_sell_report'])->name('due_sell_report_pdf');
        Route::get('/due_sell_report_excel/{from}/{to}/{flag?}', [ReportExcelController::class , 'due_sell_report'])->name('due_sell_report_excel');
        // profit Loss report-------------------------------------------------------------------
        Route::get('/profit_loss_report', ProfitLossReportComponent::class)->name('profit_loss_report');
        Route::get('/profit_loss_report_pdf/{from}/{to}/{flag?}', [PrintReportController::class , 'profit_loss_report'])->name('profit_loss_report_pdf');
        Route::get('/profit_loss_report_excel/{from}/{to}/{flag?}', [ReportExcelController::class , 'profit_loss_report'])->name('profit_loss_report_excel');
        // Stock report-------------------------------------------------------------------------
        Route::get('/stock_report', StockReportComponent::class)->name('stock_report');
        Route::get('/stock_report_pdf/{data?}', [PrintReportController::class , 'stock_report'])->name('stock_report_pdf');
        Route::get('/stock_report_excel/{data?}', [ReportExcelController::class , 'stock_report'])->name('stock_report_excel');
    // Report---------------------------------------------------------------------------------

    // Configuration----------------------------------------------------------------------------
        // Users-------------------------------------------------------------------------
        Route::get('/user', UserComponent::class)->name('user');
        Route::get('/sell_settings', SellSettingsComponent::class)->name('sell_settings');
    // Configuration----------------------------------------------------------------------------

    });

    // Admin route group
    Route::middleware(['auth','auth.manager'])->group(function(){
        
    });
    


});
