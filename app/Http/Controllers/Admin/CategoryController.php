<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;

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
    Category::destroy($category_id);
    return redirect()->back();
  }
}
