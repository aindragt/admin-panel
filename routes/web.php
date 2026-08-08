<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('pages.dashboard');})->name('dashboard');
Route::get('/forms', fn() => view('pages.forms'))->name('forms.demo');
Route::get('/ui-components', fn() => view('pages.ui-components'))->name('ui.demo');
Route::get('/tables', fn() => view('pages.tables'))->name('tables.demo');
Route::get('/login', fn() => view('auth.login'))->name('login');
