<?php

use App\Http\Controllers\StudentController;

Route::get('/', [StudentController::class, 'index'])->name('students.index');
Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
