<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('Dash');
});
Route::get('/authors/trashed', action: [AuthorController::class, 'trashed'])->name('authors.trashed');
Route::get('/categories/trashed', [CategoryController::class, 'trashed'])->name('categories.deleted');

Route::get('/authors/restore/{id}', [AuthorController::class, 'restore'])->name('authors.restore');
Route::get('/categories/restore/{id}', [CategoryController::class, 'restoreCategory'])->name('categories.restore');

Route::delete('authors/{id}/force-delete',[AuthorController::class ,'forceDelete'])->name('authors.forceDelete');
Route::resource('authors', AuthorController::class);
Route::resource('categories', CategoryController::class);
Route::resource('books', BookController::class);




// حذف جميع الصور الإضافية
Route::post('/books/{book}/delete-images', [BookController::class, 'deleteImages'])->name('books.deleteImages');

// حذف صورة إضافية معينة
Route::delete('/books/{book}/delete-image/{image}', [BookController::class, 'deleteImage'])->name('books.deleteImage');
