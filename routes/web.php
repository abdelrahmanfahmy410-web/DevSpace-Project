<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('welcome');
});
//add route for investor registration
Route::get('/investor/register',[InvestorController::class, 'create']);
Route::post('/investor/register', [InvestorController::class, 'store']);

Route::get('/role/add_role', [RoleController::class, 'create']);
Route::post('/role/add_role', [RoleController::class, 'store']);
