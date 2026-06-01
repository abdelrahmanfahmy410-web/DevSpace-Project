<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\DeveloperSkillController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AreaOfInterestController;
//all users
Route::get('/', function () {
    return view('layouts.app');
});
Route::get('/add-area-of-interest',[AreaOfInterestController::class, 'create'])->name('area_of_interest.create');
Route::post('/add-area-of-interest',[AreaOfInterestController::class, 'store'])->name('area_of_interest.store');
//investor Routes
Route::get('/investor/register',[InvestorController::class, 'create']);
Route::post('/investor/register', [InvestorController::class, 'store']);
//developer Routes 
//developer registration
Route::get('/developer/register', [DeveloperController::class, 'create']);
Route::post('/developer/register', [DeveloperController::class, 'store']);
Route::get('/developer/profile', [DeveloperController::class, 'show'])->name('developer.profile');
Route::get('/developer/edit', [DeveloperController::class, 'edit'])->name('developer.edit');
Route::post('/developer/update', [DeveloperController::class, 'update'])->name('developer.update');
//mentor routes
Route::get('/mentor/register', [MentorController::class, 'create'])->name('mentor.register');
Route::post('/mentor/register', [MentorController::class, 'store'])->name('mentor.store');
Route::get('/mentor/{mentor}', [MentorController::class, 'show'])->name('mentor.show');

Route::get('/project/create', [ProjectController::class, 'create'])->name('projects.create');
Route::post('/project', [ProjectController::class, 'store'])->name('projects.store');
//show project details
Route::get('/project/{project}', [ProjectController::class, 'show'])->name('projects.show');


//Admin Areas
Route::get('/role/add_role', [RoleController::class, 'create']);
Route::post('/role/add_role', [RoleController::class, 'store']);
Route::get('/skill/add_skill', [SkillController::class, 'create']);
Route::post('/skill/add_skill', [SkillController::class, 'store']);
Route::get('/skill', [SkillController::class, 'index'])->name('skill.index');
//add skill specilization
Route::get('/specialization/add_specialization', [SpecializationController::class, 'create']);
Route::post('/specialization/add_specialization', [SpecializationController::class, 'store']);
/*
Route::get('/project/create', [ProjectController::class, 'create'])->name('projects.create');
Route::post('/project', [ProjectController::class, 'store'])->name('projects.store');
Route::get('/project/{project}', [ProjectController::class, 'show'])->name('projects.show');
*/
Route::get('/add-area-of-interest',[AreaOfInterestController::class, 'create'])->name('area_of_interest.create');
Route::post('/add-area-of-interest',[AreaOfInterestController::class, 'store'])->name('area_of_interest.store');

//Route::get('/project/create', [ProjectController::class, 'create'])->name('projects.create');
//Route::post('/project', [ProjectController::class, 'store'])->name('projects.store');

//Route::get('/project/{project}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/api/skills-by-specialization/{specialization}', [ProjectController::class, 'getSkillsBySpecialization'])->name('api.skills.by_specialization');

//Route::get('/project/add_media/{project}', [ProjectController::class, 'addMedia'])->name('projects.add_media');
//Route::post('/project/store_media/{project}', [ProjectController::class, 'storeMedia'])->name('projects.store_media');  

Route::get('/project/create', [ProjectController::class, 'create'])->name('projects.create');
Route::get('/project/add_media/{project}', [ProjectController::class, 'addMedia'])->name('projects.add_media');
Route::get('/project/{project}', [ProjectController::class, 'show'])->name('projects.show');

Route::post('/project', [ProjectController::class, 'store'])->name('projects.store');
Route::post('/project/store_media/{project}', [ProjectController::class, 'storeMedia'])->name('projects.store_media');
Route::get('/login', function () {
    return response()->json(['message' => 'Not authenticated'], 401);
})->name('login');