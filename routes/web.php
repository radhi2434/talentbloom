<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\TalentController;
use App\Http\Controllers\Admin\SettingsController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\StudentProfileController;
use App\Http\Controllers\Teacher\TeacherTalentController;

use App\Http\Controllers\Student\StudentDashboardController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/hello', function () {
    return 'Hello, TalentBloom!';
});


/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

Auth::routes(['register' => false]);


/*
|--------------------------------------------------------------------------
| User Profile (Teacher / Student)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');

    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::post('/profile/expertise/add', [ProfileController::class, 'addExpertise'])
        ->name('profile.expertise.add');

    Route::get('/profile/expertise/delete/{id}', [ProfileController::class, 'deleteExpertise'])
        ->name('profile.expertise.delete');

    Route::post('/profile/award/add', [ProfileController::class, 'addAward'])
        ->name('profile.award.add');

    Route::get('/profile/award/delete/{award}', [ProfileController::class, 'deleteAward'])
        ->name('profile.award.delete');

    Route::get('/user/profile/{user}', 
        [\App\Http\Controllers\ProfileController::class, 'show'])
        ->name('user.profile.show');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // ================= DASHBOARD =================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/admin/analytics', [AnalyticsController::class, 'index'])
        ->name('admin.analytics');


    // ================= SETTINGS =================
    Route::get('/settings', [SettingsController::class, 'index'])
        ->name('settings');

    // ADD
    Route::post('/settings/class', [SettingsController::class, 'storeClass'])
        ->name('settings.class.store');

    Route::post('/settings/form', [SettingsController::class, 'storeForm'])
        ->name('settings.form.store');

    Route::post('/settings/position', [SettingsController::class, 'storePosition'])
        ->name('settings.position.store');

    // DELETE
    Route::delete('/settings/class/{id}', [SettingsController::class, 'deleteClass'])
        ->name('settings.class.delete');

    Route::delete('/settings/form/{id}', [SettingsController::class, 'deleteForm'])
        ->name('settings.form.delete');

    Route::delete('/settings/position/{id}', [SettingsController::class, 'deletePosition'])
        ->name('settings.position.delete');

    Route::put('/settings/award/{id}', [SettingsController::class, 'updateAward'])
        ->name('settings.award.update');
    
    Route::post('/settings/award/store', [SettingsController::class, 'storeAward'])
        ->name('settings.award.store');

    Route::delete('/settings/award/{id}', [SettingsController::class, 'deleteAward'])
        ->name('settings.award.delete');

    Route::post('/settings/award-category', [SettingsController::class, 'storeAwardCategory'])
        ->name('settings.award.category.store');

    Route::delete('/settings/award-category/{id}', [SettingsController::class, 'deleteAwardCategory'])
        ->name('settings.award.category.delete');


    // ================= USERS =================
    Route::resource('users', UserController::class);


    // ================= IMPORT =================
    Route::get('/students/import', [\App\Http\Controllers\Admin\ImportController::class, 'showStudents'])
        ->name('students.import.show');

    Route::post('/students/import', [\App\Http\Controllers\Admin\ImportController::class, 'handleStudents'])
        ->name('students.import.handle');

    Route::get('/teachers/import', [\App\Http\Controllers\Admin\ImportController::class, 'showTeachers'])
        ->name('teachers.import.show');

    Route::post('/teachers/import', [\App\Http\Controllers\Admin\ImportController::class, 'handleTeachers'])
        ->name('teachers.import.handle');


    // ================= STUDENTS =================
    Route::resource('students', \App\Http\Controllers\Admin\StudentController::class);


    // ================= TEACHERS =================
    Route::resource('teachers', \App\Http\Controllers\Admin\TeacherController::class);


    // ================= TALENTS =================
    Route::get('/talents', [TalentController::class, 'index'])->name('talents.index');
    Route::get('/talents/create', [TalentController::class, 'create'])->name('talents.create');
    Route::post('/talents', [TalentController::class, 'store'])->name('talents.store');
    Route::get('/talents/{talent}/edit', [TalentController::class, 'edit'])->name('talents.edit');
    Route::put('/talents/{talent}', [TalentController::class, 'update'])->name('talents.update');
    Route::delete('/talents/{talent}', [TalentController::class, 'destroy'])->name('talents.destroy');

    Route::get('/talents/student/{student}', [TalentController::class, 'studentTalents'])
        ->name('talents.student');


    // ================= ADMIN PROFILE =================
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');

    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    Route::post('/profile/photo', [AdminProfileController::class, 'updatePhoto'])->name('profile.photo');

    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');
});


/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'teacher'])->prefix('teacher')->name('teacher.')->group(function () {

    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/students', [StudentProfileController::class, 'index'])
        ->name('students.index');

    Route::get('/students/{student}', [StudentProfileController::class, 'show'])
        ->name('students.show');

    Route::get('/students/{student}/talents/create',[StudentProfileController::class, 'createTalent'])
        ->name('students.talents.create');

    Route::post('/students/{student}/talents', [StudentProfileController::class, 'storeTalent'])
        ->name('students.talents.store');

    Route::get('/talents', [TeacherTalentController::class, 'index'])
        ->name('talents.index');

    Route::get('/talents/student/{student}', [TeacherTalentController::class, 'studentTalents'])
        ->name('talents.student');

    Route::get('/talents/create', [TeacherTalentController::class, 'create'])
        ->name('talents.create');

    Route::post('/talents', [TeacherTalentController::class, 'store'])
        ->name('talents.store');

    Route::get('/talents/{talent}/edit', [TeacherTalentController::class, 'edit'])
        ->name('talents.edit');

    Route::put('/talents/{talent}', [TeacherTalentController::class, 'update'])
        ->name('talents.update');

    Route::delete('/talents/{talent}', [TeacherTalentController::class, 'destroy'])
        ->name('talents.destroy');
});


/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','student'])->prefix('student')->name('student.')->group(function () {

    Route::get('/dashboard',[\App\Http\Controllers\Student\StudentDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/achievements',[\App\Http\Controllers\Student\AchievementController::class, 'index'])
        ->name('achievements');

    Route::get('/achievements-list', [StudentDashboardController::class, 'achievementList']);
    
    Route::get('/ranking',[\App\Http\Controllers\Student\RankingController::class, 'index'])
        ->name('ranking');

    Route::get('/profile', fn() => view('student.profile.edit'))->name('profile');
});