<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/home', function () {
        return Inertia::render('home');
    })->name('home');
    
    Route::get('/panel_index', [PanelController::class, 'index'])->name('panel_index');

    Route::post('/create_panel', [PanelController::class, 'store'])->name('create_panel');

    Route::delete('/delete_panel/{panel}', [PanelController::class, 'destroy'])->name('delete_panel');

    ////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('/category/{id}', [CategoryController::class, 'index'])->name('category');


    Route::post('/create_category', [CategoryController::class, 'store'])->name('create_category');

    Route::delete('/delete_category/{id}', [CategoryController::class, 'destroy'])->name('delete_category');

    //Route::post('/create_category', [CategoryController::class, 'index'])->name('create_category');

    ////////////////////////////////////////////////////////////////////////////////////////////////

    Route::post('/category/add_task', [TaskController::class, 'store'])->name('category.add_task');

    Route::delete('/delete_task/{id}', [TaskController::class, 'destroy'])->name('delete_task');
    
    ////////////////////////////////////////////////////////////////////////////////////////////

    Route::put('/category/editCategoryTask', [TaskController::class, 'changeTaskCategory'])->name('edit.category.task');

    Route::put('/category/editOrderTask', [TaskController::class, 'editOrderTask'])->name('edit.Order.task');
});
