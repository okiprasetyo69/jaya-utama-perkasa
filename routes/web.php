<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;


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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/register', 'App\Http\Controllers\HomeController@registerUser')->name('register');
Auth::routes();
Route::get('/', [LoginController::class, 'loginPage']);


Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/admin', 'App\Http\Controllers\HomeController@index')->name('home');
// admin page
Route::get('/dashboard', 'App\Http\Controllers\HomeController@adminDashboardPage')->name('dashboard')->middleware('superAdmin');
Route::get('/management-category', 'App\Http\Controllers\HomeController@managementCategory')->name('category-page')->middleware('superAdmin');
Route::get('/management-product', 'App\Http\Controllers\HomeController@managementProduct')->name('product-page')->middleware('superAdmin');
Route::get('/management-inventory', 'App\Http\Controllers\HomeController@managementInventory')->name('inventory-page')->middleware('superAdmin');

// data
Route::get('/categories', 'App\Http\Controllers\CategoryController@getAll')->name('category-data');
Route::post('/categories/save', 'App\Http\Controllers\CategoryController@create')->name('category-save');
Route::get('/categories/detail', 'App\Http\Controllers\CategoryController@detail')->name('category-detail');
Route::post('/categories/delete', 'App\Http\Controllers\CategoryController@delete')->name('category-delete');

Route::get('/products', 'App\Http\Controllers\ProductItemController@getProductItem')->name('product-data');
Route::post('/product/save', 'App\Http\Controllers\ProductItemController@create')->name('product-save');
Route::get('/product/detail', 'App\Http\Controllers\ProductItemController@detail')->name('product-detail');
Route::post('/product/delete', 'App\Http\Controllers\ProductItemController@delete')->name('product-delete');

Route::get('/inventories', 'App\Http\Controllers\InventoriesController@getInventory')->name('inventory-data');
Route::post('/inventories/save', 'App\Http\Controllers\InventoriesController@create')->name('inventory-create');
Route::get('/inventories/detail', 'App\Http\Controllers\InventoriesController@detail')->name('product-detail');