<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

#Controllers
use App\Http\Controllers\AuthController;

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

Route::get('/hello/world', function(){
    return "Hello World";
});

Route::get('/print/{name}', function($name){
    return "Your name is $name";
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/me', [AuthController::class, 'me']);


#Protected API with SANCTUM
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/authenticated', function(){
        return "You are Authenticated!";
    });
    #You need to be logged in before logging out.. :)
    Route::post('/logout', [AuthController::class, 'logout']);
});