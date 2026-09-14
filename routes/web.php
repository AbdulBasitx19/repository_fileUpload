<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

Route::get('/', [DocumentController::class, 'index'])->name('documents.index');
Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
Route::get('/documents/{id}/download', [DocumentController::class, 'download'])->name('documents.download');
Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');