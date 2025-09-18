<?php

use App\Http\Controllers\BanksoalController;
use App\Http\Controllers\BanksoalDetailController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseDetailController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\ModulDetailController;
use App\Http\Controllers\ModuldetailSectionController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\ProgressUserController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\SoalDetailController;
use App\Http\Controllers\UserAnswerController;
use Illuminate\Support\Facades\Route;

require('auth.php');

/*
 * Tidak bisa diakses jika sudah login.
 */
Route::middleware('guest')->group(function () {
    Route::get('/', [LandingController::class, 'index'])->name('landing');
});

/*
 * Perlu login untuk mengakses
 */
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Master

    Route::get("peserta/generate", [PesertaController::class, "generate"])->name("peserta.generate");
    Route::resource("peserta", PesertaController::class)->parameters([
        "peserta" => "peserta"
    ]);

    Route::get("course/my-course", [CourseController::class, "myCourse"])->name("course.my-course");
    Route::get("course/{id}/my-modules", [CourseController::class, "myModules"])->name("course.my-modules");
    Route::get("course/{courseId}/my-section/{id}", [CourseController::class, "myModulSection"])->name("course.my-module-section");
    Route::resource("course", CourseController::class);

    Route::resource("modul", ModulController::class);

    Route::post("modul-detail/konfirmasi", [ModulDetailController::class, "konfirmasi"])->name("modul-detail.konfirmasi");
    Route::resource("modul-detail", ModulDetailController::class);

    Route::resource("moduldetail-section", ModuldetailSectionController::class);

    Route::resource("banksoal", BanksoalController::class);

    Route::resource("banksoal-detail", BanksoalDetailController::class);

    // Back Office

    Route::resource("course-detail", CourseDetailController::class);

    Route::match(["get", "post"], "soal/test/{modulDetailId}", [SoalController::class, "test"])->name("soal.test");

    Route::resource("soal", SoalController::class);
    Route::resource("soal-detail", SoalDetailController::class);

    // Log

    Route::resource("progress-user", ProgressUserController::class);

    Route::resource("user-answer", UserAnswerController::class);
});
