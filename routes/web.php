<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\InvoiceController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SettingsController;
use Barryvdh\DomPDF\Facade\Pdf;

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

Route::get('/', [HomeController::class, 'welcome'])->name('front');
Route::get('/post/{id}/{slug}', [HomeController::class, 'single'])->name('front.single');
// Route::get('/', function () {
//     return view('auth/login');
// })->middleware('guest');
// Route::get('/', function () {
//     return view('auth/login');
// })->middleware('guest');

Auth::routes();


Route::group(['prefix' => 'admin', 'middleware' => ['auth'],], function () {
    Route::view('/', 'admin.index')->name('admin.index');
    Route::group(['prefix' => 'category'], function () {
        //category routes
        Route::get('/', [CategoryController::class, 'index'])->name('category');
        Route::get('/getCategoryData', [CategoryController::class, 'getData'])->name('getCategoryData');
        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
    });
    Route::group(['prefix' => 'product'], function () {
        //product routes
        Route::get('/', [ProductController::class, 'index'])->name('product');
        Route::get('/getProductData', [ProductController::class, 'getData'])->name('getProductData');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    });

    Route::group(['prefix' => 'customer'], function () {
        //customer routes
        Route::get('/', [CustomerController::class, 'index'])->name('customer');
        Route::get('/getCustomerData', [CustomerController::class, 'getData'])->name('getCustomerData');
        Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
        Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
        Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::put('/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
        Route::get('/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
        Route::post('/store_popup', [CustomerController::class, 'store_popup'])->name('customer.store_popup');
    });

    Route::group(['prefix' => 'invoice'], function () {
        //invoice routes
        Route::get('/', [InvoiceController::class, 'index'])->name('invoice');
        Route::get('/getInvoiceData', [InvoiceController::class, 'getData'])->name('getInvoiceData');
        Route::get('/ajax/customers', [InvoiceController::class, 'ajaxCustomers'])->name('invoice.get_customers_ajax_data');
        Route::get('/ajax/products', [InvoiceController::class, 'ajaxProducts'])->name('invoice.get_products_ajax_data');
        Route::get('/create', [InvoiceController::class, 'create'])->name('invoice.create');
        Route::post('/store', [InvoiceController::class, 'store'])->name('invoice.store');
        Route::get('/{id}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
        Route::put('/update/{id}', [InvoiceController::class, 'update'])->name('invoice.update');
        Route::get('/delete/{id}', [InvoiceController::class, 'delete'])->name('invoice.delete');
        Route::get('/ajax/payment_data', [InvoiceController::class, 'ajaxPaymentsData'])->name('invoice.get_payment_ajax_data');
        Route::post('/add_payment', [InvoiceController::class, 'addPayment'])->name('invoice.add_payment');
    });

    Route::group(['prefix' => 'payment'], function () {
        //payment routes
        Route::get('/', [PaymentController::class, 'index'])->name('payment');
        Route::get('/getInvoicePaymentData', [PaymentController::class, 'getData'])->name('getInvoicePaymentData');
        Route::get('/{id}/edit', [PaymentController::class, 'edit'])->name('payment.edit');
        Route::post('/{id}/update', [PaymentController::class, 'update'])->name('payment.update');

        Route::get('/delete/{id}', [PaymentController::class, 'delete'])->name('payment.delete');
    });

    //Profile routes
    Route::get('profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::put('profile-update/{id}', [ProfileController::class, 'update'])->name('admin.profile.update');

    //Setting routes
    Route::get('setting', [SettingsController::class, 'index'])->name('admin.setting');
    Route::put('setting-update/{id}', [SettingsController::class, 'update'])->name('admin.setting.update');
});

Route::get('/test-pdf', function () {
    $pdf = Pdf::loadView('invoice');
    return $pdf->stream('invoice.pdf');
});
Route::get('/test-thermal-pdf', function () {
    $html = view('thermal-invoice', [])->render();
    $finalPdf = Pdf::loadHTML($html)
        ->setPaper([0, 0, 226.77, 1000], 'portrait');
    return $finalPdf->stream('thermal-invoice.pdf');
});
