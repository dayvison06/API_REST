<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;


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


Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function ($router){
    Route::get('/books',[BookController::class,'getBooks']);
    Route::get('/book/{id}', [BookController::class,'getBook']);
    Route::post('/books', [BookController::class,'addBook']);
});

//
//# O middleware 'force-json' força a resposta a ser em JSON
//# mesmo que o cliente não especifique o cabeçalho Accept como application/json

//Route::middleware(['auth:api', 'force-json'])->prefix('v1')->group(function () {
//    Route::prefix('auth')->controller(AuthController::class)->group(function () {
//        Route::withoutMiddleware('auth:api')->post('login', 'login');
//        Route::post('logout', 'logout');
//    })

