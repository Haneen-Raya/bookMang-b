<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $categories = Category::paginate(5);
       return view('Category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Category.create');
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(category $category)
    {
        return view('Category.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category $category)
    {
        return view('Category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        $category ->update($validated);

        return redirect()->route('categories.index')->with('massage','Updated Successfuly');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('message','Deleted Successfully');

    }
}
