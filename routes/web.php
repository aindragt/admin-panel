<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard');
});

Route::get('/forms', function () {
    return view('pages.forms');
})->name('forms.demo');
