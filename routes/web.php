<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
// composer require laravel/ui
// php artisan ui bootstrap --auth
// npm install 
// npm run dev

Route::get('/', [ItemController::class, 'getItems'])->name('getItems');
Route::get('/add-to-cart/{id}', [ItemController::class, 'addToCart'])->name('addToCart');
Route::get('/shopping-cart', [ItemController::class, 'getCart'])->name('getCart');
Route::get('/reduce/{id}', [ItemController::class, 'getReduceByOne'])->name('reduceByOne');
Route::get('/remove/{id}', [ItemController::class, 'getRemoveItem'])->name('removeItem');
Route::get('/checkout', [ItemController::class, 'postCheckout'])->name('checkout')->middleware('auth');
Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');


Route::post('/items-import', [ItemController::class, 'import'])->name('item.import');

Route::get('/admin/users',[DashboardController::class,'getUsers'])->name('admin.users');
Route::get('/admin/customers',[DashboardController::class,'getCustomers'])->name('admin.customers');
Route::post('/user/update/{id}',[UserController::class,'update_role'])->name('users.update');

Route::resource('items', ItemController::class);

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
