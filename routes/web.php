<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;


Route::get('/admin', function () {
    return Inertia::render('Admin');
});
Route::get('/', function () {
    return Inertia::render('Public');
});
