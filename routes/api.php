<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthorController;
use App\Http\Controllers\API\BookController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthorController::class,'register']);
Route::post('login',[AuthorController::class,'login']);
Route::get('list-book',[BookController::class,'listBook']);

Route::group(['middleware'=>['auth:api']],function(){
   Route::get('profile',[AuthorController::class,'profile']);
   Route::post('logout',[AuthorController::class,'logout']);

   Route::post('create-book',[BookController::class,'createBook']);
   Route::get('author-books',[BookController::class,'authorBook']);
   Route::get('list-single-book/{id}',[BookController::class,'listSingleBook']);
   Route::post('update-book/{id}',[BookController::class,'updateBook']);
   Route::get('delete-book/{id}',[BookController::class,'deleteBook']);
});