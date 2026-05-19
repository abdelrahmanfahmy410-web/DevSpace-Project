<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\SkillController;
Route::get('/', function () {
    return view('welcome');
});
//add route for investor registration
Route::get('/investor/register',[InvestorController::class, 'create']);
Route::post('/investor/register', [InvestorController::class, 'store']);
// add route for specialization
Route::get('/specialization/add_specialization', [SpecializationController::class, 'create']);
Route::post('/specialization/add_specialization', [SpecializationController::class, 'store']);
// add route for skill
Route::get('/skill/add_skill', [SkillController::class, 'create']);
Route::post('/skill/add_skill', [SkillController::class, 'store']);