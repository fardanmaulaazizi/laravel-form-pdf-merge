<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;

Route::get('/', function () {
    return view('input');
});

Route::post('/generate-pdf', [PDFController::class, 'generatePDF'])->name('generate-pdf');
