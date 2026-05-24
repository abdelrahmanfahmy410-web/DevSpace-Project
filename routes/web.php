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

Route::get('/developer/skills/{id}/edit', [DeveloperSkillController::class, 'edit']);
Route::post('/developer/skills/{id}/update', [DeveloperSkillController::class, 'update']);

Route::get('/project/create', [ProjectController::class, 'create'])->name('projects.create');
Route::post('/project', [ProjectController::class, 'store'])->name('projects.store');
Route::get('/project/{project}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/add-area-of-interest',[AreaOfInterestController::class, 'create'])->name('area_of_interest.create');
Route::post('/add-area-of-interest',[AreaOfInterestController::class, 'store'])->name('area_of_interest.store');

Route::get('/project/projects_show', [ProjectController::class, 'show_projects'])->name('projects.show_projects');
Route::get('/projects/create/{specialization}', [ProjectController::class, 'getSkillsBySpecialization'])->name('projects.getSkillsBySpecialization');
