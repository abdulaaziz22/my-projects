<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\BookController;
use App\http\Controllers\CategoryController;
use App\http\Controllers\AuthorController;
use App\http\Controllers\PublisherController;
use App\http\Controllers\AuthorBookController;





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
Route::prefix('/BooK')->group(function(){
    Route::get('/',[BookController::class,'index']);
    Route::post('/store',[BookController::class,'store']);
    Route::get('/show/{id}',[BookController::class,'show']);


});


Route::prefix('/Category')->group(function(){
    Route::get('/',[CategoryController::class,'index']);

});


Route::prefix('/Publisher')->group(function(){
    Route::get('/',[PublisherController::class,'index']);
    Route::get('/store',[PublisherController::class,'store']);
    

});


Route::prefix('/Author')->group(function(){
    Route::get('/',[AuthorController::class,'index']);
    Route::get('/store',[AuthorController::class,'store']);

});

Route::prefix('/AuthorBook')->group(function(){
    Route::get('/store',[AuthorBookController::class,'store']);

});


