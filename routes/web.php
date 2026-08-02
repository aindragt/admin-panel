<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('pages.dashboard');})->name('dashboard');
Route::get('/forms', fn() => view('pages.forms'))->name('forms.demo');
Route::get('/users', fn() => view('pages.users'))->name('users.index');
Route::get('/login', fn() => view('auth.login'))->name('login');