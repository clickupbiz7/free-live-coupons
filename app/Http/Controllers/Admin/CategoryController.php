<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    // ================= CREATE =================
    public function create()
    {
        return view('admin.categories.create');
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'icon'  => 'nullable|string',
            'image' => 'nullable|image'
        ]);

        $data = [
            'name'   => $request->name,
            'slug'   => Str::slug($request->name),
            'icon'   => $request->icon,
            'status' => 1
        ];

        // IMAGE UPLOAD (optional)
        if ($request->hasFile('image')) {

            $file = time().'_'.$request->file('image')->getClientOriginalName();

            $request->file('image')->move(public_path('uploads/categories'), $file);

            $data['image'] = $file;
        }

        Category::create($data);

        return redirect('/admin/categories')->with('success', 'Category Added');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'icon'  => 'nullable|string',
            'image' => 'nullable|image'
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon
        ];

        // IMAGE UPDATE
        if ($request->hasFile('image')) {

            // OLD IMAGE DELETE
            if ($category->image && file_exists(public_path('uploads/categories/'.$category->image))) {
                unlink(public_path('uploads/categories/'.$category->image));
            }

            $file = time().'_'.$request->file('image')->getClientOriginalName();

            $request->file('image')->move(public_path('uploads/categories'), $file);

            $data['image'] = $file;
        }

        $category->update($data);

        return redirect('/admin/categories')->with('success', 'Category Updated');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // IMAGE DELETE
        if ($category->image && file_exists(public_path('uploads/categories/'.$category->image))) {
            unlink(public_path('uploads/categories/'.$category->image));
        }

        $category->delete();

        return back()->with('success', 'Category Deleted');
    }
}