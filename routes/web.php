<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;


//article
Route::resource('/article', ArticleController::class);


//auth
Route::get('/auth/signin', [AuthController::class,  'signin']);
Route::post('/auth/registr', [AuthController::class,  'registr']);



//main
Route::get('/', [MainController::class,  'index']);
Route::get('/full_image/{img}', [MainController::class,  'show']);

Route::get('/about', function () {
    return view('main/about'); 
});

Route::get('/contact', function () {
    $array = [
        'name' => 'Moscow Polytech' ,
        'adres' => 'Pryaniki ',
        'email' => 'tyt email',
        'phone' => '+7 666 66 66',
        'tg' => '@tyttg'
    ];
    return view('main/contact', ['contact'=> $array]); 
});
