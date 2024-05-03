<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\categoriesController;
use App\Http\Controllers\InvoiceAchiveController;
use App\Http\Controllers\OrdersDetialsController;
use App\Http\Controllers\maincategoriesController;
use App\Http\Controllers\InvoicesDetailsController;
 
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


Route::get('/dashboard', function () { 
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
 
Route::resource('maincategories', maincategoriesController::class);

Route::resource('categories', categoriesController::class);

Route::resource('products', ProductsController::class);
Route::post('products/{id}', [ProductsController::class, 'update'])->name('products.update');

Route::resource('orders', OrdersController::class);
Route::resource('orderdetials', OrdersDetialsController::class);
Route::post('update_status', [OrdersController::class, 'update_status'])->name('update_status');
Route::get('ordershipped',  [OrdersController::class, 'show'])->name('ordershipped');

require __DIR__.'/auth.php';
 