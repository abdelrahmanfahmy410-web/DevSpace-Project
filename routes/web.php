<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\AreaOfInterestController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/investor/register',[InvestorController::class, 'create']);
Route::post('/investor/register', [InvestorController::class, 'store']);

Route::get('/role/add_role', [RoleController::class, 'create']);
Route::post('/role/add_role', [RoleController::class, 'store']);

Route::get('/mentor/register', [MentorController::class, 'create'])->name('mentor.register');
Route::post('/mentor/register', [MentorController::class, 'store'])->name('mentor.store');

Route::get('/skill/add_skill', [SkillController::class, 'create']);
Route::post('/skill/add_skill', [SkillController::class, 'store']);

Route::get('/specialization/add_specialization', [SpecializationController::class, 'create']);
Route::post('/specialization/add_specialization', [SpecializationController::class, 'store']);

Route::get('/add-area-of-interest',[AreaOfInterestController::class, 'create'])->name('area_of_interest.create');
Route::post('/add-area-of-interest',[AreaOfInterestController::class, 'store'])->name('area_of_interest.store');