<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\SerieController;
use App\Http\Controllers\Api\GenreController;

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/series', [SerieController::class, 'index']);
Route::get('/genres', [GenreController::class, 'index']);