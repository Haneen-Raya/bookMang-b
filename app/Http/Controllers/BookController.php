<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Image;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    /**
     * * Display a listing of the books.
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $books      = Book::orderBy('created_at','DESC')->paginate('5');
        $authors    = Author::orderBy('created_at','DESC')->paginate('5');
        $categories = Category::orderBy('created_at','DESC')->paginate('5');

    return view ('Book.index',compact('books','authors','categories'));
    }

    /**
     *
     * * Show the form for creating a new book.
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $authors    = Author::all();
        $categories = Category::all();

    return view('Book.create',compact('authors','categories'));
    }

    /**
     *
     *Store a newly created book in storage.
     * @param \App\Http\Requests\BookRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BookRequest $request)
{

    $validated = $request->validated();


    if ($request->hasFile('cover')) {
        $file = $request->file('cover');
        $path = $file->store('covers', 'public');
        $validated['cover'] = $path;
    }

    $book = Book::create([
        'title'     => $validated['title'],
        'body'      => $validated['body'],
        'cover'     => $validated['cover'] ?? null,
        'author_id' => $validated['author_id'],
    ]);


    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('images', $imageName, 'public');

            Image::create([
                'book_id' => $book->id,
                'images'  => $imageName,
            ]);
        }
    }

    if (isset($validated['categories']) && !empty($validated['categories'])) {
        $book->categories()->sync($validated['categories']);
        $book->categories()->detach();
    }

    return redirect()->route('books.index')->with('success', 'تم إنشاء الكتاب بنجاح!');
}



    /**
     *
     * Display the specified book.
     * @param \App\Models\Book $book
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Book $book)
    {
        $book->load(['categories','images','author']);

        return view('Book.show',compact('book'));
    }

    /**
     *
     ** Show the form for editing the specified book.
     * @param \App\Models\Book $book
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Book $book)
    {
        $book->load(['categories', 'images', 'author']);
        $authors = Author::all();
        $categories = Category::all();
        return view('Book.edit', compact('book', 'authors', 'categories'));
    }

    /**
     *
     *Update the specified book in storage.
     * @param \App\Http\Requests\BookRequest $request
     * @param \App\Models\Book $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BookRequest $request, Book $book)
{
    // dd($request);
    $validated = $request->validated();
    // dd($validated);
    $book->update([
        'title'     => $validated['title'],
        'body'      => $validated['body'],
        'author_id' => $validated['author_id'],
    ]);

    if ($request->hasFile('cover')) {

        if ($book->cover && File::exists(public_path('storage/' . $book->cover))) {
            File::delete(public_path('storage/' . $book->cover));
        }
        $file = $request->file('cover');
        $path = $file->store('covers', 'public');
        $book->update(['cover' => $path]);
    }

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('images', $imageName, 'public');

            Image::create([
                'book_id' => $book->id,
                'images'  => $imageName,
            ]);}
    }
    if (isset($validated['categories']) && !empty($validated['categories'])) {
        $book->categories()->sync($validated['categories']);
    } else {
        $book->categories()->detach();
    }
    return redirect()->route('books.index')->with('success', 'تم تحديث الكتاب بنجاح!');
}

    /**
     *
     *Remove (soft delete) the specified book from storage.
     * @param \App\Models\Book $book
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Book $book)
    {
        if(File::exists("cover/.$book->cover")){
            File::delete("cover/.$book->cover");
    }
    $images = Image::where("book_id",$book->id)->get();
        foreach($images as $image){
        if(File::exists("images/.$image->image"));
        File::delete("images/.$image->image");
    }
    $book->delete();
    return redirect()->route('books.index');
}

/**
 *
 *Delete all additional images associated with a specific book.
 * @param mixed $id
 * @return \Illuminate\Http\RedirectResponse
 */
public function deleteImages($id)
{

    $book = Book::findOrFail($id);


    $images = Image::where('book_id', $book->id)->get();
    foreach ($images as $image) {
        if (File::exists(public_path('/images/' . $image->image))) {
            File::delete(public_path('/images/' . $image->image));
        }
        $image->delete();
    }

    return redirect()->route('books.edit', $id)->with('success', 'Images deleted successfully!');
}

/**
 *
 * Delete a specific additional image associated with a book.
 * @param mixed $id
 * @param mixed $image_id
 * @return \Illuminate\Http\RedirectResponse
 */
public function deleteImage($id, $image_id)
{

    $image = Image::findOrFail($image_id);

    if (File::exists(public_path('/images/' . $image->image))) {
        File::delete(public_path('/images/' . $image->image));
    }

    $image->delete();

    return redirect()->route('books.edit', $id)->with('success', 'Image deleted successfully!');
}

/**
 *
 *Display a listing of the soft-deleted books (trashed).
 * @return \Illuminate\Contracts\View\View
 */
public function trashed()
    {

        $books = Book::onlyTrashed()->with('author')->latest('deleted_at')->paginate(10);

        return view('Book.trashed', compact('books'));
    }

    /**
     *
     *Restore the specified soft-deleted book.
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {

        $book = Book::onlyTrashed()->findOrFail($id);
        $book->restore();

        return redirect()->route('books.trashed')
                         ->with('message', 'Book restored successfully.');
    }

    /**
     *
     * * Permanently delete the specified soft-deleted book.
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {

        $book = Book::onlyTrashed()->findOrFail($id);

        $book->forceDelete();
        return redirect()->route('books.trashed')
                         ->with('message', 'Book permanently deleted successfully.');
    }
}

