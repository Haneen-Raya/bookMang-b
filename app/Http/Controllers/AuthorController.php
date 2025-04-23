<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Requests\AuthorRequest;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $authors = Author::paginate(5);
        return view('Author.index',compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Author.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorRequest $request)
    {
        $validated = $request->validated() ;

        $authors = new Author() ;
        $authors->name = $validated['name'];
        $authors->email = $validated['email'];
        $authors->save();

        return redirect()->route('authors.index')->with('Created Successfuly');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return view('Author.show' , compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return view('Author.edit',compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorRequest $request,Author $author)
    {
        $validated = $request->validated() ;
        $author ->update($validated);
        $author->save();

        return redirect()->route('authors.index')->with('message', 'Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('authors.index')->with('message','Deleted Successfully');
    }

    public function trashed(){
        $authors = Author::onlyTrashed()->paginate(5);

        return view('Author.trashed',compact('authors'));
    }

    public function restore ($id){

        $author = Author::withTrashed()->findOrFail($id) ;
        $author->restore();

        return redirect()->route('authors.index')->with('message','Recovered');
    }

    public function forceDelete($id){
        $author = Author::onlyTrashed()->findOrFail($id);
        $author->forceDelete();
        return redirect()->route('authors.index')->with('message','Author Permanently Delete!');

    }
}
