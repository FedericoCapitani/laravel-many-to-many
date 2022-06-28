<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all()->sortDesc();
        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate_data = $request->validate([
            'name' => 'required|unique:categories'
        ]);
        $validate_data['slug'] = Str::slug($request->name);
        Category::create($validate_data);
        return redirect()->back()->with('status',"Category $request->name Created Successfully");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validate_data = $request->validate([
            'name' => ['required', Rule::unique('categories')->ignore($category)]
        ]);
        $validate_data['slug'] = Str::slug($request->name);
        $category->update($validate_data);
        return redirect()->back()->with('status', "Category $category->name Update SuccessFully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('status',"Category $category->name Delete Succesfully");
    }
}
