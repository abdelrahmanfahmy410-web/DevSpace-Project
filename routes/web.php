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

Route::get('/mentor/register', [MentorController::class, 'create'])->name('mentor.register');
Route::post('/mentor/register', [MentorController::class, 'store'])->name('mentor.store');