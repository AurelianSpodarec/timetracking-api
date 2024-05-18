<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', Controllers\HomeController::class)->name('home');

Route::get('about', Controllers\AboutController::class)->name('about');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', Controllers\DashboardController::class)->name('dashboard');

    Route::controller(Controllers\ProfileController::class)->middleware('auth')->group(function () {
        Route::get('profile/edit', 'edit')->name('profile.edit');
        Route::patch('profile', 'update')->name('profile.update');
        Route::delete('profile', 'destroy')->name('profile.destroy');
    });

    Route::controller(Controllers\ProjectController::class)->middleware('auth')->group(function () {
        Route::get('projects', 'index')->name('project.index');
        Route::get('project/edit', 'edit')->name('project.edit');
        Route::patch('project', 'update')->name('project.update');
        Route::delete('project', 'destroy')->name('project.destroy');
    });

    Route::controller(Controllers\ReportController::class)->middleware('auth')->group(function () {
        Route::get('reports', 'index')->name('report.index');
        Route::get('report/edit', 'edit')->name('report.edit');
        Route::patch('report', 'update')->name('report.update');
        Route::delete('report', 'destroy')->name('report.destroy');
    });

    Route::controller(Controllers\TimerController::class)->middleware('auth')->group(function () {
        Route::get('timers', 'index')->name('timer.index');
        Route::get('timer/edit', 'edit')->name('timer.edit');
        Route::patch('timer', 'update')->name('timer.update');
        Route::delete('timer', 'destroy')->name('timer.destroy');
    });
});

require __DIR__ . '/features.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/dev.php';
