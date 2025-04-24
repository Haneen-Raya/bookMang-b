<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('Dash');
});
Route::delete('/{id}/images', [BookController::class, 'deleteImages'])->name('books.destroyAllImages');
Route::delete('/{id}/images/{image_id}', [BookController::class, 'deleteImage'])->name('destroyBookSpecificImage');

Route::get('/authors/trashed', action: [AuthorController::class, 'trashed'])->name('authors.trashed');
Route::get('/categories/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');

Route::patch('/authors/restore/{id}', [AuthorController::class, 'restore'])->name('authors.restore');
Route::patch('/categories/restore/{id}', [CategoryController::class, 'restore'])->name('categories.restore');

Route::prefix('books')->name('books.')->group(function () {
    Route::get('/trashed', [BookController::class, 'trashed'])->name('trashed');
    Route::patch('/{id}/restore', [BookController::class, 'restore'])->name('restore');
    Route::delete('/{id}/force-delete', [BookController::class, 'forceDelete'])->name('forceDelete');
});
Route::delete('/categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
Route::delete('authors/{id}/force-delete',[AuthorController::class ,'forceDelete'])->name('authors.forceDelete');

Route::resource('authors', AuthorController::class);
Route::resource('categories', CategoryController::class);
Route::resource('books', BookController::class);
