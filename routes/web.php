<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvestorController;
Route::get('/', function () {
    return view('welcome');
});
//add route for investor registration
Route::get('/investor/register',[InvestorController::class, 'create']);
Route::post('/investor/register', [InvestorController::class, 'store']);
