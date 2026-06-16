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
use App\Http\Controllers\DashboardController;
use App\Models\Project;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\TeamRoleController;
use App\Http\Controllers\FollowingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\HomeController;



//home for all users 
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/join', fn() => view('layouts.join'))->name('join');
////////////////////
Route::get('/add-area-of-interest',[AreaOfInterestController::class, 'create'])->name('area_of_interest.create');
Route::post('/add-area-of-interest',[AreaOfInterestController::class, 'store'])->name('area_of_interest.store');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');


//all users

Route::get('/add-area-of-interest',[AreaOfInterestController::class, 'create'])->name('area_of_interest.create');
Route::post('/add-area-of-interest',[AreaOfInterestController::class, 'store'])->name('area_of_interest.store');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

//investor Routes
Route::get('/investor/register',[InvestorController::class, 'create']);
Route::get('/investor/edit', [InvestorController::class, 'edit'])->name('investor.edit');
Route::get('/investor/profile', [InvestorController::class, 'showProfile'])->name('investor.profile');
// ----------------------------------------------------
// All Users & General Routes
// ----------------------------------------------------


Route::get('/add-area-of-interest', [AreaOfInterestController::class, 'create'])->name('area_of_interest.create');
Route::post('/add-area-of-interest', [AreaOfInterestController::class, 'store'])->name('area_of_interest.store');

// ----------------------------------------------------
// User Authentication
// ----------------------------------------------------
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'savelogin'])->name('login.save');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// ----------------------------------------------------
// Investor Routes
// ----------------------------------------------------
Route::get('/investor/register', [InvestorController::class, 'create'])->name('investor.register');
Route::post('/investor/register', [InvestorController::class, 'store'])->name('investor.store');

// ----------------------------------------------------
// Developer Routes
// ----------------------------------------------------
Route::get('/developer/register', [DeveloperController::class, 'create'] )->name('developer.register');
Route::post('/developer/register', [DeveloperController::class, 'store'])->name('developer.store');
//Route::get('/developer/profile', [DeveloperController::class, 'show'])->name('developer.profile');
Route::get('/developer/edit', [DeveloperController::class, 'edit'])->name('developer.edit');
Route::post('/developer/update', [DeveloperController::class, 'update'])->name('developer.update');
Route::get('/developer/skills/{id}/edit', [DeveloperSkillController::class, 'edit']);
Route::post('/developer/skills/{id}/update', [DeveloperSkillController::class, 'update']);
Route::get('/developer/developers', [DeveloperController::class, 'allDevelopers'])->name('developer.all_developers');
//mentor routes
Route::get('/developer/skills/edit', [DeveloperSkillController::class, 'edit']);
Route::post('/developer/skills/update', [DeveloperSkillController::class, 'update']);

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

// Wishlist Routes
Route::post('/wishlist/toggle/{project}', [ProjectController::class, 'toggleWishlist'])->name('wishlist.toggle');
Route::get('/wishlist', [ProjectController::class, 'wishlist'])->name('wishlist.index');

//////////////////////
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

Route::get('/api/users/search', [ProjectController::class, 'searchUsers']);

Route::get('/member/profile', [UserController::class, 'showMemberProfile'])->name('member.profile');
Route::get('/member/profile', [UserController::class, 'showMemberProfile'])
    ->name('member.profile')
    ->middleware('auth');

    Route::get('/member/profile/{id}', [UserController::class, 'showOtherProfile'])
    ->name('member.other_profile')
    ->middleware('auth');
// ----------------------------------------------------
Route::post('/user/follow/{user}', [FollowingController::class, 'toggleFollow'])->name('user.follow');    // ----------------------------------------------------
// API / AJAX Routes
// ----------------------------------------------------
Route::get('/api/skills-by-specialization/{specialization}', [ProjectController::class, 'getSkillsBySpecialization'])
     ->name('api.skills.by_specialization');

Route::get('/projects/skills/{specialization}', [ProjectController::class, 'getSkillsBySpecialization'])
     ->name('projects.get_skills');

Route::get('/api/users/search', [ProjectController::class, 'searchUsers']);

// Team Member Profile
Route::get('/team-member/{teamRole}/profile', [ProjectController::class, 'memberProfile'])
     ->name('team-role.profile');

// ----------------------------------------------------
// Development / Temporary Routes
// ----------------------------------------------------
Route::get('/dev-login', function () {
    auth()->loginUsingId(14); 
    return redirect('/dashboard');
});
   Route::get('/team-member/{teamRole}/profile', [ProjectController::class, 'memberProfile'])
    ->name('team-role.profile');


    
    // routes/web.php  (add inside your auth middleware group)
    Route::middleware(['auth'])->group(function () {

    // Inbox: list all conversations
    Route::get('/inbox', [ConversationController::class, 'index'])->name('inbox');

    // Start or open a conversation with a user
    Route::get('/conversations/start/{user}', [ConversationController::class, 'start'])->name('conversations.start');

    // Show a specific conversation (chat page)
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');

});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/teammates', [TeamRoleController::class, 'index'])->name('my_team.index');
Route::get('/mentees', [TeamRoleController::class, 'mentees'])->name('mentees.index');
Route::get('/my-followers', [FollowingController::class, 'followers'])->name('followers.index');

Route::post('/team-roles/{teamRole}/accept', [TeamRoleController::class, 'accept'])->name('team_roles.accept');
Route::post('/team-roles/{teamRole}/reject', [TeamRoleController::class, 'reject'])->name('team_roles.reject');
Route::get('/my-followers', [FollowingController::class, 'show'])->name('followers.index');

// ----------------------------------------------------
// Admin Areas
// ----------------------------------------------------
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {

       Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    //All users 
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');

    // All projects
    Route::get('/projects', [AdminController::class, 'projects'])->name('projects.index');
    Route::get('/projects/{project}', [AdminController::class, 'showProject'])->name('projects.show');

    // Roles
    Route::get('/role/add_role',  [RoleController::class, 'create'])->name('role.create');
    Route::post('/role/add_role', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');

    // Skills
    Route::get('/skill',           [SkillController::class, 'index'])->name('skill.index');
    Route::get('/skill/add_skill', [SkillController::class, 'create'])->name('skill.create');
    Route::post('/skill/add_skill',[SkillController::class, 'store'])->name('skill.store');

    // Specializations
    Route::get('/specialization',                      [SpecializationController::class, 'index'])->name('specialization.index');
    Route::get('/specialization/add_specialization',   [SpecializationController::class, 'create'])->name('specialization.create');
    Route::post('/specialization/add_specialization',  [SpecializationController::class, 'store'])->name('specialization.store');
    Route::get('/specialization/skills',              [SpecializationController::class, 'specializationSkills'])->name('specialization.skills');
});
    
