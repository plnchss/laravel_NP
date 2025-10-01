<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;


//comments
Route::resource('comments', CommentController::class)->only(['store', 'destroy']);



//article
Route::resource('/article', ArticleController::class)->middleware('auth:sanctum');


//auth
Route::get('/auth/signin', [AuthController::class, 'signin']);
Route::post('/auth/registr', [AuthController::class, 'registr']);
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/authenticate', [AuthController::class, 'authenticate']);
Route::get('/auth/logout', [AuthController::class, 'logout']);

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
