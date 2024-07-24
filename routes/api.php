<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PossibilityFailureController;
use App\Http\Controllers\ProcessController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
});

Route::resource('action', ActionController::class);
Route::resource('class', ClassController::class);
Route::resource('possibility_failure', PossibilityFailureController::class);
Route::resource('office', OfficeController::class);
Route::resource('person', PersonController::class);
Route::resource('legal-process', ProcessController::class);


