<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\SpecializationController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/investor/register',[InvestorController::class, 'create']);
Route::post('/investor/register', [InvestorController::class, 'store']);

//developer registration
Route::get('/developer/register', [DeveloperController::class, 'create']);
 Route::post('/developer/register', [DeveloperController::class, 'store']);
Route::get('/role/add_role', [RoleController::class, 'create']);
Route::post('/role/add_role', [RoleController::class, 'store']);

Route::get('/mentor/register', [MentorController::class, 'create'])->name('mentor.register');
Route::post('/mentor/register', [MentorController::class, 'store'])->name('mentor.store');

Route::get('/skill/add_skill', [SkillController::class, 'create']);
Route::post('/skill/add_skill', [SkillController::class, 'store']);

Route::get('/specialization/add_specialization', [SpecializationController::class, 'create']);
Route::post('/specialization/add_specialization', [SpecializationController::class, 'store']);
