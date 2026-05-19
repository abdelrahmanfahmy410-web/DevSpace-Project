<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\InvestorController;
Route::get('/', function () {
    return view('welcome');
});
//add route for investor registration
Route::get('/investor/register',[InvestorController::class, 'create']);
Route::post('/investor/register', [InvestorController::class, 'store']);

//developer registration
Route::get('/developer/register', [DeveloperController::class, 'create']);
 Route::post('/developer/register', [DeveloperController::class, 'store']);