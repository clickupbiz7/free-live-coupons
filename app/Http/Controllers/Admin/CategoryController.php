<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Exports\CategoriesExport;
use App\Imports\CategoriesImport;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;


class CategoryController extends Controller
{
    // INDEX
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    // CREATE
    public function create()
    {
        return view('admin.categories.form');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'icon'      => 'nullable|mimes:svg,svg+xml',
            'image'     => 'nullable|image',
        ]);

        $data = [];
        $data['name']   = $request->name;
        $data['slug']   = Str::slug($request->name);
        $data['status'] = 1;

        /* SVG upload */
        if ($request->hasFile('icon')) {

            $svg = time().'_icon.'.$request->icon->extension();
            $request->icon->move(public_path('uploads/categories/icons'), $svg);

            $data['icon'] = $svg;

            /* image auto remove if svg uploaded */
            $data['image'] = null;
        }

        /* IMAGE upload */
        if ($request->hasFile('image')) {

            $img = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/categories'), $img);

            $data['image'] = $img;

            /* svg auto remove if image uploaded */
            $data['icon'] = null;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
        ->with('success','Category Added');
    }

    // EDIT
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.form', compact('category'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'icon'  => 'nullable|mimes:svg,svg+xml',
            'image' => 'nullable|image',
        ]);

        $data = [];
        $data['name'] = $request->name;
        $data['slug'] = Str::slug($request->name);

        /* REMOVE SVG manually */
        if ($request->remove_icon == 1) {

            if ($category->icon &&
                file_exists(public_path('uploads/categories/icons/'.$category->icon))) {

                unlink(public_path('uploads/categories/icons/'.$category->icon));
            }

            $data['icon'] = null;
        }

        /* REMOVE IMAGE manually */
        if ($request->remove_image == 1) {

            if ($category->image &&
                file_exists(public_path('uploads/categories/'.$category->image))) {

                unlink(public_path('uploads/categories/'.$category->image));
            }

            $data['image'] = null;
        }

        /* NEW SVG upload */
        if ($request->hasFile('icon')) {

            if ($category->icon &&
                file_exists(public_path('uploads/categories/icons/'.$category->icon))) {

                unlink(public_path('uploads/categories/icons/'.$category->icon));
            }

            if ($category->image &&
                file_exists(public_path('uploads/categories/'.$category->image))) {

                unlink(public_path('uploads/categories/'.$category->image));
            }

            $svg = time().'_icon.'.$request->icon->extension();
            $request->icon->move(public_path('uploads/categories/icons'), $svg);

            $data['icon']  = $svg;
            $data['image'] = null;
        }

        /* NEW IMAGE upload */
        if ($request->hasFile('image')) {

            if ($category->image &&
                file_exists(public_path('uploads/categories/'.$category->image))) {

                unlink(public_path('uploads/categories/'.$category->image));
            }

            if ($category->icon &&
                file_exists(public_path('uploads/categories/icons/'.$category->icon))) {

                unlink(public_path('uploads/categories/icons/'.$category->icon));
            }

            $img = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/categories'), $img);

            $data['image'] = $img;
            $data['icon']  = null;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
        ->with('success','Category Updated');
    }

    // DELETE
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image &&
            file_exists(public_path('uploads/categories/'.$category->image))) {
            unlink(public_path('uploads/categories/'.$category->image));
        }

        if ($category->icon &&
            file_exists(public_path('uploads/categories/icons/'.$category->icon))) {
            unlink(public_path('uploads/categories/icons/'.$category->icon));
        }

        $category->delete();

        return back()->with('success','Category Deleted');
    }

    public function export()
{
    return Excel::download(
        new CategoriesExport,
        'categories.xlsx'
    );
}

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    Excel::import(
        new CategoriesImport,
        $request->file('file')
    );

    return back()->with(
        'success',
        'Categories Imported Successfully'
    );
}
}