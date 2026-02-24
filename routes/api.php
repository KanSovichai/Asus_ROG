<?php

use App\Http\Controllers\FormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/signup', [App\Http\Controllers\FormController::class, 'storeUserData']);
Route::post('/login',[FormController::class,'login']);
Route::post('/logout',[FormController::class,'logout']);
Route::post('/setProduct',[App\Http\Controllers\ProductController::class,'formDataProduct']);
Route::get('/getProducts',[App\Http\Controllers\ProductController::class,'getProductData']);
Route::post('/deleteProduct/{id}',[App\Http\Controllers\ProductController::class,'deleteProduct']);
Route::post('/editProduct/{id}',[App\Http\Controllers\ProductController::class,'editProduct']);
Route::put('/updateProduct/{id}',[App\Http\Controllers\ProductController::class,'updateProduct']);
Route::get('/getUsers',[App\Http\Controllers\UsersController::class,'getUserData']);
Route::put('/changeRole/{id}',[App\Http\Controllers\UsersController::class,'changeRole']);
Route::delete('/deleteUser/{id}',[App\Http\Controllers\UsersController::class,'deleteUser']);
Route::post('/createUser',[App\Http\Controllers\UsersController::class,'createUser']);
Route::put('/updateUser/{id}',[App\Http\Controllers\UsersController::class,'updateUser']);
Route::post('/setOrder',[App\Http\Controllers\OrderController::class,'setOrder']);
Route::get('/getOrders/{id}',[App\Http\Controllers\OrderController::class,'getOrder']);