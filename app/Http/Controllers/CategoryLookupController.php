<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryLookupRequest;
use Illuminate\Http\Request;
use App\Models\CategoryLookup;

class CategoryLookupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("categories.index", [
            "categories" => CategoryLookup::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("categories.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryLookupRequest $request)
    {
        CategoryLookup::create($request->validated());
        // Redirect to index route
        return redirect()->route('category.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryLookup $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryLookupRequest $request, CategoryLookup $category)
    {

        $category->update($request->validated());
        return redirect()->route('category.index')->with('success', 'Updated succefully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryLookup $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Updated succefully!');

    }
}
