<?php

use App\Http\Controllers\TodoController;
use App\Http\Middleware\DisableHeaders;
use Illuminate\Support\Facades\Route;


Route::fallback(function () {
    return view('errors/404');
});


Route::controller(TodoController::class)->group(function () {

    Route::get('/', 'index');

    Route::post('/add-todo', 'todoHandler')->name('add-todo');
    Route::post('/delete-todo', 'deleteHandler')->name('delete-todo');


    Route::post('/todo-list', 'getTodoList')->name('todo-list');
});