<?php

use App\Http\Controllers;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TimerController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('about', AboutController::class)->name('about');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::controller(ProfileController::class)->middleware('auth')->group(function () {
        Route::get('profile/edit', 'edit')->name('profile.edit');
        Route::patch('profile', 'update')->name('profile.update');
        Route::delete('profile', 'destroy')->name('profile.destroy');
    });

    Route::controller(ProjectController::class)->middleware('auth')->group(function () {
        Route::get('projects', 'index')->name('project.index');
        Route::get('project/edit', 'edit')->name('project.edit');
        Route::patch('project', 'update')->name('project.update');
        Route::delete('project', 'destroy')->name('project.destroy');
    });

    Route::controller(ReportController::class)->middleware('auth')->group(function () {
        Route::get('reports', 'index')->name('report.index');
        Route::get('report/edit', 'edit')->name('report.edit');
        Route::patch('report', 'update')->name('report.update');
        Route::delete('report', 'destroy')->name('report.destroy');
    });

    Route::controller(TimerController::class)->middleware('auth')->group(function () {
        Route::get('timers', 'index')->name('timer.index');
        Route::get('timer/edit', 'edit')->name('timer.edit');
        Route::patch('timer', 'update')->name('timer.update');
        Route::delete('timer', 'destroy')->name('timer.destroy');
    });

    Route::controller(ClientController::class)->middleware('auth')->group(function () {
        Route::get('clients', 'index')->name('client.index');
        Route::get('client/edit', 'edit')->name('client.edit');
        Route::patch('client', 'update')->name('client.update');
        Route::delete('client', 'destroy')->name('client.destroy');
    });
});

require __DIR__ . '/features.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/dev.php';
