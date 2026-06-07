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
use App\Http\Controllers\UserController;
use App\Models\Project;
//all users
Route::get('/', function () {
    return view('layouts.app');
});
Route::get('/add-area-of-interest',[AreaOfInterestController::class, 'create'])->name('area_of_interest.create');
Route::post('/add-area-of-interest',[AreaOfInterestController::class, 'store'])->name('area_of_interest.store');
Route::get('/dashboard', function () {
    $projects = Project::whereHas('team_roles', function ($query) {
        $query->where('user_id', auth()->id());
    })->get();

    return view('layouts.dashboard', compact('projects'));
});
//investor Routes
Route::get('/investor/register',[InvestorController::class, 'create']);

// ----------------------------------------------------
// All Users & General Routes
// ----------------------------------------------------
Route::get('/', function () {
    return view('layouts.app');
});

Route::get('/add-area-of-interest', [AreaOfInterestController::class, 'create'])->name('area_of_interest.create');
Route::post('/add-area-of-interest', [AreaOfInterestController::class, 'store'])->name('area_of_interest.store');

// ----------------------------------------------------
// User Authentication (Login)
// ----------------------------------------------------
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'savelogin'])->name('login.save');

// ----------------------------------------------------
// Investor Routes
// ----------------------------------------------------
Route::get('/investor/register', [InvestorController::class, 'create']);
Route::post('/investor/register', [InvestorController::class, 'store']);

// ----------------------------------------------------
// Developer Routes
// ----------------------------------------------------
Route::get('/developer/register', [DeveloperController::class, 'create']);
Route::post('/developer/register', [DeveloperController::class, 'store']);
Route::get('/developer/profile', [DeveloperController::class, 'show'])->name('developer.profile');
Route::get('/developer/edit', [DeveloperController::class, 'edit'])->name('developer.edit');
Route::post('/developer/update', [DeveloperController::class, 'update'])->name('developer.update');
Route::get('/developer/skills/{id}/edit', [DeveloperSkillController::class, 'edit']);
Route::post('/developer/skills/{id}/update', [DeveloperSkillController::class, 'update']);
Route::get('/developer/developers', [DeveloperController::class, 'allDevelopers'])->name('developer.all_developers');
//mentor routes

// ----------------------------------------------------
// Mentor Routes
// ----------------------------------------------------
Route::get('/mentor/register', [MentorController::class, 'create'])->name('mentor.register');
Route::post('/mentor/register', [MentorController::class, 'store'])->name('mentor.store');
Route::get('/mentor/{mentor}', [MentorController::class, 'show'])->name('mentor.show');

// ----------------------------------------------------
// Project Routes (CRUD & Management)
// ----------------------------------------------------
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/my-projects', [ProjectController::class, 'myProjects'])->name('projects.my');

Route::get('/project/create', [ProjectController::class, 'create'])->name('projects.create');
Route::post('/project/create/', [ProjectController::class, 'store'])->name('projects.store');

Route::get('/project/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/project/{project}/details', [ProjectController::class, 'showProjectDetails'])->name('projects.details');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/my_project_details/{project}', [ProjectController::class, 'showmyProjectDetails'])->name('projects.my_details');
Route::get('/assigned-projects', [ProjectController::class, 'assignedProjects'])->name('projects.assigned');


Route::get('/project/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
Route::put('/project/{project}', [ProjectController::class, 'update'])->name('projects.update');
Route::delete('/project/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

// Project Media
Route::get('/project/add_media/{project}', [ProjectController::class, 'addMedia'])->name('projects.add_media');
Route::post('/project/store_media/{project}', [ProjectController::class, 'storeMedia'])->name('projects.store_media');

// ----------------------------------------------------
// Admin Areas (Roles, Skills & Specializations)
// ----------------------------------------------------
Route::get('/role/add_role', [RoleController::class, 'create']);
Route::post('/role/add_role', [RoleController::class, 'store']);

Route::get('/skill/add_skill', [SkillController::class, 'create']);
Route::post('/skill/add_skill', [SkillController::class, 'store']);
Route::get('/skill', [SkillController::class, 'index'])->name('skill.index');

Route::get('/specialization/add_specialization', [SpecializationController::class, 'create']);
Route::post('/specialization/add_specialization', [SpecializationController::class, 'store']);
Route::get('/project/create', [ProjectController::class, 'create'])->name('projects.create');
Route::get('/add-area-of-interest',[AreaOfInterestController::class, 'create'])->name('area_of_interest.create');
Route::post('/add-area-of-interest',[AreaOfInterestController::class, 'store'])->name('area_of_interest.store');

Route::get('/api/skills-by-specialization/{specialization}', [ProjectController::class, 'getSkillsBySpecialization'])->name('api.skills.by_specialization');

Route::get('/projects/skills/{specialization}', [ProjectController::class, 'getSkillsBySpecialization'])
     ->name('projects.get_skills');
     
Route::get('/project/create', [ProjectController::class, 'create'])->name('projects.create');
Route::get('/project/add_media/{project}', [ProjectController::class, 'addMedia'])->name('projects.add_media');
Route::get('/project/{project}', [ProjectController::class, 'show'])->name('projects.show');

Route::post('/project/create/', [ProjectController::class, 'store'])->name('projects.store');
Route::post('/project/store_media/{project}', [ProjectController::class, 'storeMedia'])->name('projects.store_media');

Route::get('/projects/skills/{specialization}', [\App\Http\Controllers\ProjectController::class, 'getSkillsBySpecialization'])
     ->name('projects.get_skills');
     
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

Route::get('/api/users/search', [ProjectController::class, 'searchUsers']);

//login routes

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'savelogin'])->name('login.save');


Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

// ----------------------------------------------------
// API / AJAX Routes
// ----------------------------------------------------
Route::get('/api/skills-by-specialization/{specialization}', [ProjectController::class, 'getSkillsBySpecialization'])->name('api.skills.by_specialization');
Route::get('/projects/skills/{specialization}', [ProjectController::class, 'getSkillsBySpecialization'])->name('projects.get_skills');
Route::get('/api/users/search', [ProjectController::class, 'searchUsers']);

// ----------------------------------------------------
// Views / Temporary Pages
// ----------------------------------------------------
Route::get('/projects-index', function () {
    $projects = \App\Models\Project::with(['skills', 'specializations'])->get();
    return view('Project.projects-index', compact('projects'));})->name('projects.index.page');

Route::get('/api/users/search', [ProjectController::class, 'searchUsers']);


Route::get('/dev-login', function () {
    auth()->loginUsingId(14); // the ID you saw in the database
    return redirect('/dashboard');
});
   Route::get('/team-member/{teamRole}/profile', [ProjectController::class, 'memberProfile'])
    ->name('team-role.profile');