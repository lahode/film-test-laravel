<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FilmController;



Route::apiResource('films', FilmController::class);
/*
Route::get('films', [FilmController::class, 'index']);
Route::post('films', [FilmController::class, 'store']);
Route::get('films/{id}', [FilmController::class, 'show']);
Route::put('films/{id}', [FilmController::class, 'update']);
Route::patch('films/{id}', [FilmController::class, 'update']);
Route::delete('films/{id}', [FilmController::class, 'delete']);
*/
