<?php

use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/add', [UserController::class, 'add']);
    Route::put('/update/{id}', [UserController::class, 'update']);
    Route::delete('/delete/{id}', [UserController::class, 'delete']);
    Route::get('/search', [UserController::class,'search']);
});

Route::middleware('auth')->prefix('categoryproducts')->group(function () {
    Route::get('/', [CategoryProductController::class,  'index']);
    Route::post('/add', [CategoryProductController::class, 'add']);
    Route::put('/update/{id}', [CategoryProductController::class, 'update']);
    Route::delete('/delete/{id}', [CategoryProductController::class, 'delete']);
});
Route::middleware('auth')->prefix('products')->group(function () {
    Route::get('/', [ProductController::class,  'index']);
    Route::post('/add', [ProductController::class, 'add']);
    Route::post('/update/{id}', [ProductController::class, 'update']);
    Route::delete('/delete/{id}', [ProductController::class, 'delete']);
});
Route::middleware('auth')->prefix('orders')->group(function () {
    Route::get('/', [AdminOrderController::class,  'show']);
    Route::get('/detail/{id}', [AdminOrderController::class, 'detailOrder']);
    Route::put('/update/{id}', [AdminOrderController::class,'updateStatus']);
    Route::delete('/delete/{id}', [AdminOrderController::class, 'delete']);
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/change-pass', [AuthController::class, 'changePassWord']);
    Route::post('/reset-password', [AuthController::class, 'sendMail']);
    Route::put('/reset-password/{token}', [AuthController::class, 'reset']);
});
Route::prefix('home')->group(function () {
    Route::get('/phone',[HomeController::class, 'getPhone']);
    Route::get('/laptop',[HomeController::class, 'getLaptop']);
    Route::get('/new',[HomeController::class, 'getProductNew']);
    Route::get('/outstanding',[HomeController::class, 'getProductOutstanding']);
});
Route::get('/product/{slug}',[ProductController::class, 'ProductDetail']);
Route::get('/productCategoryList/{slug}',[ProductController::class, 'ProductCategoryList']);
Route::prefix('order')->group(function () {
    Route::post('/addOrder',[OrderController::class, 'addOrder']);
    Route::post('/addDetailOrder',[OrderController::class, 'addDetailOrder']);
});
