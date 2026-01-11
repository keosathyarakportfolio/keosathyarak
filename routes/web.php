<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ChatbotController;
Route::get('/aboutme', function() {
    return view('aboutme');
});
Route::get('/aichat', function() {
    return view('aichat');
});
Route::post('/chat/send', [ChatbotController::class, 'chat']);
Route::get('/', [DownloadController::class, 'showForm']);
Route::post('/get-video', [DownloadController::class, 'getVideo'])->name('getvideo');
Route::POST('/download-video', [DownloadController::class, 'downloadVideo'])->name('download.video');
Route::get('get-video', function() {
    return redirect('/');
});



