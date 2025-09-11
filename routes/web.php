<?php

use App\Http\Controllers\admin\QuestionController;
use App\Http\Controllers\admin\SitemapController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\KeywordController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
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
        Route::get('/changeStatus/{id}', [CategoryController::class, 'changeStatus'])->name('category.changeStatus');
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
        Route::get('/changeStatus/{id}', [ProductController::class, 'changeStatus'])->name('product.changeStatus');
    });
    //Profile routes
    Route::get('profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::put('profile-update', [ProfileController::class, 'update'])->name('admin.profile.update');
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
