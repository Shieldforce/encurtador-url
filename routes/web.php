<?php

use App\Http\Controllers\EncurtadorController;
use Illuminate\Support\Facades\Route;


Route::get('/{hash?}', [
    EncurtadorController::class,
    'index'
]);

Route::get('/generate/url', function () {
    return view('generate');
})->name('generate');

Route::post("encurtar", [
    EncurtadorController::class,
    "encurtar"
])->name("encurtar");
