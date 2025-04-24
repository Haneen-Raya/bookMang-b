<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     *  Display a listing of the categories.
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
       $categories = Category::paginate(5);
       return view('Category.index',compact('categories'));
    }

    /**
     *  Show the form for creating a new category.
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('Category.create');
    }

    /**
     *   Store a newly created category in storage.
     * @param \App\Http\Requests\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $validated = $request->validated() ;
        $category = new Category();
        $category->name = $validated['name'];
        $category->save();

        return redirect()->route('categories.index')->with('message','Created Successfuly');
    }

    /**
     *  Display the specified category.
     * @param \App\Models\Category $category
     * @return \Illuminate\Contracts\View\View
     */
    public function show(category $category)
    {
        return view('Category.show',compact('category'));
    }

    /**
     *  Show the form for editing the specified category.
     * @param \App\Models\Category $category
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(category $category)
    {
        return view('Category.edit',compact('category'));
    }

    /**
     *  Update the specified category in storage.
     * @param \App\Http\Requests\CategoryRequest $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        $category ->update($validated);

        return redirect()->route('categories.index')->with('massage','Updated Successfuly');

    }

    /**
     * Remove (soft delete) the specified category from storage.Summary of destroy
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('message','Deleted Successfully');

    }
    /**
     *  Display a listing of the soft-deleted categories (trashed).
     * @return \Illuminate\Contracts\View\View
     */
    public function trashed(){
      $categories = Category::onlyTrashed()->paginate('5');
      return view('Category.trashed',compact('categories'));

    }
    /**
     *  estore the specified soft-deleted category.
     * @param mixed $id
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function restore($id){
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('categories.index');
    }
    /**
     *  Permanently delete the specified soft-deleted category.
     * @param mixed $id
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id){
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('categories.trashed');
    }
}
