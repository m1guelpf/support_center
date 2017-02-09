<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function show()
    {
        $categories = Category::all();

        return view('admin.categories', compact('categories'));
    }

    public function add(Request $request)
    {
        $this->validate($request, [
        'name' => 'required|unique:categories,name',
    ]);
        Category::create([
        'name' => $request->name,
    ]);

        return redirect()->back();
    }

    public function delete($category_id)
    {
        $category = Category::findOrFail($category_id);
        foreach ($category->tickets as $ticket) {
            $ticket->delete();
        }
        $category->delete();

        return redirect()->back();
    }
}
