<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth')->group(function () {
   
});
 Route::get('/users/search', [UserController::class, 'search']);