<?php

use App\Http\Controllers\BookingAdjustController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingTermsConditionController;
use App\Http\Controllers\CheckClientMobileNumberController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CustomerCategoryController;
use App\Http\Controllers\CustomerDueListController;
use App\Http\Controllers\CustomerExportController;
use App\Http\Controllers\CustomerImportController;
use App\Http\Controllers\GoldBuySaleController;
use App\Http\Controllers\JakatCalculationController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleTypeController;
use App\Http\Controllers\Select2SearchController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierTransactionController;
use App\Http\Controllers\TermsConditionController;
use App\Http\Controllers\TodayRateController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WageSettingController;
use App\Http\Controllers\ZoneController;
use App\Models\CustomerCategory;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Route;

// Route::get('/', function ($path) {
//     return view('mobile_app');
// })->where('path', '.*');


Route::get('/', \App\Http\Controllers\DashboardController::class)
->name('home')
->middleware(['auth']);

// Route::view('/', 'mobile_app');

Route::group(['namespace' => '\Rap2hpoutre\LaravelLogViewer', 'middleware' => ['auth', 'can:access log']], function () {
    Route::get('logs', 'LogViewerController@index');
});

Route::put('change-password', [ProfileController::class, 'update_password'])
    ->name('update_password')
    ->middleware(['auth']);

Route::put('update-info', [ProfileController::class, 'update_info'])
    ->name('update_info')
    ->middleware(['auth']);

Route::get('profile', [ProfileController::class, 'show'])
    ->name('profile')
    ->middleware(['auth']);

Route::group(['middleware' => ['auth']], function(){

    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::post('role-permission/{role}', \App\Http\Controllers\RolePermissionController::class)
        ->name('role.permission');
    Route::resource('users', UsersController::class);

    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('tc', [TermsConditionController::class, 'index'])->name('tc.index');
    Route::post('tc', [TermsConditionController::class, 'store']);

    Route::get('booking_terms', [BookingTermsConditionController::class, 'index'])->name('booking_tc.index');
    Route::post('booking_terms', [BookingTermsConditionController::class, 'store']);

    Route::resource('clients', ClientController::class);
    Route::get('check_client_mobile_number', CheckClientMobileNumberController::class)
        ->name('check_client_mobile_number');

    Route::get('productsImport', [ProductImportController::class, 'create'])->name('productsImport');
    Route::post('productsImport', [ProductImportController::class, 'store']);

    Route::get('customersImport', [CustomerImportController::class, 'create'])->name('customersImport');
    Route::post('customersImport', [CustomerImportController::class, 'store']);
    Route::get('customerExport', [CustomerExportController::class, 'create'])->name('customerExport');
    Route::post('customerExport', [CustomerExportController::class, 'store']);

    Route::get('products/{product_nr}/bynr', [ProductController::class, 'bynr']);
    Route::resource('products', ProductController::class);

    Route::resource('sale-types', SaleTypeController::class)->except('destroy');
    Route::resource('product-categories', ProductCategoryController::class)->except('show');
    Route::resource('zones', ZoneController::class)->except('destroy');
    Route::resource('customer-categories', CustomerCategoryController::class)->except('destroy');
    Route::resource('payment-methods', PaymentMethodController::class)->except('destroy');
    Route::resource('wage-setting', WageSettingController::class)->only(['create', 'store']);

    Route::resource('pos', PosController::class)->except('destroy');
    Route::get('pos/{id}/print', [PosController::class, 'show']);
    Route::get('order-preview', [PosController::class, 'preview'])->name("order-preview");
    Route::get('select2-product', [Select2SearchController::class, 'product'])->name('select2.product');
    Route::get('select2-client', [Select2SearchController::class, 'client'])->name('select2.client');
    Route::get('select2-supplier', [Select2SearchController::class, 'supplier'])->name('select2.supplier');
    Route::get('select2-zone', [Select2SearchController::class, 'zone'])->name('select2.zone');

    Route::resource('booking', BookingController::class);
    Route::resource('bookingAdjust', BookingAdjustController::class);

    Route::resource('settings', \App\Http\Controllers\SettingController::class)
        ->only(['index', 'store']);
    Route::get('booking-preview', [BookingController::class, 'preview'])->name("booking-preview");
    Route::get('booking/{id}/print', [BookingController::class, 'show']);

    //Gold Buy Sale Routes
    Route::get('gold-buy-sale', [GoldBuySaleController::class, 'goldBuySale'])->name('gold-buy-sale');
    Route::get('gold-buy-sale/create', [GoldBuySaleController::class, 'createGoldBuySale'])->name('create-gold-buy-sale');
    Route::post('gold-buy-sale', [GoldBuySaleController::class, 'storeGoldBuySale'])->name('store-gold-buy-sale');
    Route::get('gold-buy-sale/{id}/edit', [GoldBuySaleController::class, 'editGoldBuySale'])->name('edit-gold-buy-sale');
    Route::put('gold-buy-sale/{id}', [GoldBuySaleController::class, 'updateGoldBuySale'])->name('update-gold-buy-sale');
    Route::delete('gold-buy-sale/{id}', [GoldBuySaleController::class, 'deleteGoldBuySale'])->name('delete-gold-buy-sale');
    //End of Gold Buy Sale Routes

    Route::resource('stocks', StockController::class);
    Route::get('/filter', [StockController::class, 'filter'])->name('stock.filter');

    Route::get('stock/sale-list', [StockController::class, 'saleList'])->name('stock.saleList');
    Route::get('sale-list/edit/{memo}', [StockController::class, 'saleEdit'])->name('sale-list.edit');
    Route::post('sale-list/update/{memo}', [StockController::class, 'saleUpdate'])->name('sale-list.update');

    Route::get('stock/report', [StockController::class, 'reportForm'])->name('stock.report.form');
    Route::get('stock/report/generate', [StockController::class, 'report'])->name('stock.report.generate');
    Route::get('/stock/report/pdf', [StockController::class, 'reportPdf'])->name('stock.report.pdf');
    Route::get('/stock/daily-summary', [StockController::class, 'dailySummary'])->name('stock.daily.summary');
    Route::get('/stock/daily-summary/pdf', [StockController::class, 'dailySummaryPdf'])->name('stock.daily.summary.pdf');
    
    // Cash Book //
    Route::get('/cash-book', [StockController::class, 'cashBookReport'])->name('cash.book.report');
    Route::get('/cash-book/pdf', [StockController::class, 'cashBookPdf'])->name('cash.book.pdf');
    // Cash Book End //

    // New route to get stock by memo
    Route::get('/stocks/by-memo/{cash_memo_no}', [StockController::class, 'getStockByCashMemo'])->name('stocks.byCashMemo');
    // End of new route

    Route::get('salesEntry', [StockAdjustmentController::class, 'salesEntryIndex'])->name('salesEntry');
    Route::post('salesEntry', [StockAdjustmentController::class, 'salesEntry']);
    Route::resource('stockAdjustment', StockAdjustmentController::class);

    Route::get('client_due', [CustomerDueListController::class, 'index'])->name('client_due');
    Route::get('client_due/{client_id}', [CustomerDueListController::class, 'show']);
    Route::get('client_due/{client_id}/print', [CustomerDueListController::class, 'print']);
    Route::resource('transactions', TransactionController::class);

    Route::resource('suppliers', SupplierController::class);
    Route::get('suppliers_due', [SupplierController::class, 'due'])->name('suppliers.due');
    Route::resource('supplier_transactions', SupplierTransactionController::class);

    Route::get('report', [ReportController::class, 'create'])->name('report');
    Route::get('report/view', [ReportController::class, 'show']);

    Route::resource('jakat', JakatCalculationController::class);
    // Route::post('jakat', [JakatCalculationController::class, 'store'])->name('jakat.store');
    // Route::get('jakat/{id}', [JakatCalculationController::class, 'show'])->name('jakat.show');

    Route::resource('today-rates', TodayRateController::class);
    Route::resource('transaction-codes', \App\Http\Controllers\TransactionCodeController::class);
    Route::resource('trx-heads', \App\Http\Controllers\TrxHeadController::class);
    Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);
    Route::get('expenses-report', [\App\Http\Controllers\ExpenseReportController::class, 'create'])
        ->name('expenses-report.create');

    Route::get('expenses-report-data', [\App\Http\Controllers\ExpenseReportController::class, 'store'])
        ->name('expenses-report.data');

    Route::get('sanctum/token', function () {
        $user = request()->user();
        if ($user) {
            return response()->json([
                'access_token' => $user->createToken('auth_token')->plainTextToken,
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    });

});



require __DIR__ . '/auth.php';


Route::get('/migrate', function(){
    \Illuminate\Support\Facades\Artisan::call('migrate --force');
});

Route::get('/seed', function(){
    \Illuminate\Support\Facades\Artisan::call('db:seed --force');
});

Route::get('/optimize-clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::view('/app', 'mobile_app');
Route::get('/app/{path}', function ($path) {
    return view('mobile_app');
})->where('path', '.*');