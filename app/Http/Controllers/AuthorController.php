<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Requests\AuthorRequest;

class AuthorController extends Controller
{
    /**
     * View all authors
     * @return \Illuminate\Contracts\View\View
     */
    public function index(){
        $authors = Author::paginate(5);
        return view('Author.index',compact('authors'));
    }

    /**
     * Go to the creation page
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('Author.create');
    }

    /**
     * Store authors' information
     * @param \App\Http\Requests\AuthorRequest $request
     * @return \Illuminate\Http\RedirectResponse
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
     * Show single author
     * @param \App\Models\Author $author
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Author $author)
    {
        return view('Author.show' , compact('author'));
    }

    /**
     * Go to the edit page
     * @param \App\Models\Author $author
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Author $author)
    {
        return view('Author.edit',compact('author'));
    }
    /**
     * Edit author information
     * @param \App\Http\Requests\AuthorRequest $request
     * @param \App\Models\Author $author
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AuthorRequest $request,Author $author)
    {
        $validated = $request->validated() ;
        $author ->update($validated);
        $author->save();

        return redirect()->route('authors.index')->with('message', 'Updated Successfully');

    }

    /**
     * Delete author
     * @param \App\Models\Author $author
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('authors.index')->with('message','Deleted Successfully');
    }

    /**
     * Show deleted authors
     * @return \Illuminate\Contracts\View\View
     */
    public function trashed(){
        $authors = Author::onlyTrashed()->paginate(5);

        return view('Author.trashed',compact('authors'));
    }


    /**
     * Restore author
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore ($id){

        $author = Author::withTrashed()->findOrFail($id) ;
        $author->restore();

        return redirect()->route('authors.index')->with('message','Recovered');
    }

    /**
     * Delete the author permanently
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id){
        $author = Author::onlyTrashed()->findOrFail($id);
        if ($author->books()->withTrashed()->exists()) {
            return redirect()->back()->with('error', 'Cannot permanently delete this author because they have associated books.');
        }
        $author->forceDelete();
        return redirect()->route('authors.index')->with('message','Author Permanently Delete!');

    }
}
