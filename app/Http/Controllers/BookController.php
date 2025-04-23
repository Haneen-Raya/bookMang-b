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
     * Display a listing of the resource.
     */
    public function index()
    {
        $books      = Book::orderBy('created_at','DESC')->paginate('5');
        $authors    = Author::orderBy('created_at','DESC')->paginate('5');
        $categories = Category::orderBy('created_at','DESC')->paginate('5');

    return view ('Book.index',compact('books','authors','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors    = Author::all();
        $categories = Category::all();

    return view('Book.create',compact('authors','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
{
    // البيانات التي تم التحقق منها
    $validated = $request->validated();

    // رفع الغلاف (cover)
    if ($request->hasFile('cover')) {
        $file = $request->file('cover');
        $path = $file->store('covers', 'public'); // تخزين في نظام التخزين العام
        $validated['cover'] = $path; // إضافة المسار إلى البيانات
    }

    // إنشاء الكتاب
    $book = Book::create([
        'title'     => $validated['title'],
        'body'      => $validated['body'],
        'cover'     => $validated['cover'] ?? null, // إضافة الغلاف إذا تم رفعه
        'author_id' => $validated['author_id'],
    ]);

    // رفع الصور الإضافية (images)
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('images', $imageName, 'public'); // تخزين الصور في نظام التخزين العام

            // تخزين الصورة في جدول images
            Image::create([
                'book_id' => $book->id,
                'images'  => $imageName,
            ]);
        }
    }

    // ربط الكتاب بالأصناف (categories)
    if (isset($validated['categories']) && !empty($validated['categories'])) {
        $book->categories()->sync($validated['categories']); // ربط الكتاب بالأصناف
    } else {
        $book->categories()->detach(); // فصل أي أصناف إذا لم يتم تحديدها
    }
    // إعادة التوجيه مع رسالة النجاح
    return redirect()->route('books.index')->with('success', 'تم إنشاء الكتاب بنجاح!');
}



    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load(['categories','images','author']);

        return view('Book.show',compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $book->load(['categories', 'images', 'author']); // تحميل العلاقات
        $authors = Author::all(); // جلب جميع المؤلفين
        $categories = Category::all(); // جلب جميع الأصناف
        return view('Book.edit', compact('book', 'authors', 'categories')); // تمرير البيانات إلى الـ view

    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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

// To delete all Images
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


public function deleteImage($id, $image_id)
{

    $image = Image::findOrFail($image_id);

    if (File::exists(public_path('/images/' . $image->image))) {
        File::delete(public_path('/images/' . $image->image));
    }

    $image->delete();

    return redirect()->route('books.edit', $id)->with('success', 'Image deleted successfully!');
}

}
