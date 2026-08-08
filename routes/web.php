<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('pages.dashboard');})->name('dashboard');
Route::get('/forms', fn() => view('pages.forms'))->name('forms.demo');
Route::get('/tables', fn() => view('pages.tables'))->name('tables.demo');
Route::get('/roles', fn() => view('roles.index'))->name('roles.index');
Route::get('/roles/create', fn() => view('roles.form'))->name('roles.create');
Route::get('/roles/{id}/edit', fn() => view('roles.form'))->name('roles.edit');
Route::get('/login', fn() => view('auth.login'))->name('login');