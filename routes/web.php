<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DownloadController;

Route::get('/aboutme', function() {
    return view('aboutme');
});

Route::get('/', [DownloadController::class, 'showForm']);
Route::post('/get-video', [DownloadController::class, 'getVideo'])->name('getvideo');
Route::POST('/download-video', [DownloadController::class, 'downloadVideo'])->name('download.video');



