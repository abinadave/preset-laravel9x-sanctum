<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function(){
    return "Hellow World!";
});

Route::get('/testdb', function(){
    $pdo = DB::connection()->getPdo();
    if($pdo){
        return "Connected successfully to database";
    }else {
        return "You are not connected to any database";
    }
});
