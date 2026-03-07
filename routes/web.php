<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::resource('students', StudentController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('books', BookController::class);

    Route::get('/borrow', [BorrowController::class, 'index'])->name('borrow.index');
});

require __DIR__.'/auth.php';