<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// routes/web.php
Route::get('/', fn()=>view('home'))->name('home');

Route::middleware('auth')->group(function(){
  //Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class,'__invoke'])->name('dashboard');
  //Route::resource('/animals', \App\Http\Controllers\AnimalController::class)->except('show');
  //Route::view('/alerts', 'alerts.index', ['alerts'=>\App\Models\Alert::latest()->paginate(20)])->name('alerts.index');
  Route::view('/iot-guide', 'iot_guide')->name('iot.guide');
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
