<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Exports\BlogsExport;
use App\Imports\BlogsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();

        return view(
            'admin.blogs.index',
            compact('blogs')
        );
    }

    public function create()
    {
        $categories = [];

        if (Schema::hasTable('blog_categories')) {
            $categories = DB::table('blog_categories')
                ->orderBy('name')
                ->get();
        }

        return view(
            'admin.blogs.create',
            compact('categories')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
    'title'       => 'required|max:255',
    'content'     => 'required',
    'category_id' => 'required',
    'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
]);

        $data = [
            'title'       => $request->title,
            'slug'        => Str::slug($request->title) . '-' . time(),
            'content'     => $request->content,
            'category_id' => $request->category_id,
            'status'      => $request->status ?? 1,
        ];

        if ($request->hasFile('image')) {

            $file = time() . '.' .
                $request->file('image')->extension();

            $request->file('image')
                ->move(public_path('uploads/blogs'), $file);

            $data['image'] = $file;
        }

        Blog::create($data);

        return redirect('/admin/blogs')
            ->with('success', 'Blog Added Successfully');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);

        $categories = [];

        if (Schema::hasTable('blog_categories')) {
            $categories = DB::table('blog_categories')
                ->orderBy('name')
                ->get();
        }

        return view(
            'admin.blogs.edit',
            compact(
                'blog',
                'categories'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
    'title'       => 'required|max:255',
    'content'     => 'required',
    'category_id' => 'required',
    'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
]);

        $data = [
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'content'     => $request->content,
            'category_id' => $request->category_id,
            'status'      => $request->status ?? 1,
        ];

        if ($request->hasFile('image')) {

            if (
                $blog->image &&
                file_exists(
                    public_path(
                        'uploads/blogs/' . $blog->image
                    )
                )
            ) {
                unlink(
                    public_path(
                        'uploads/blogs/' . $blog->image
                    )
                );
            }

            $file = time() . '.' .
                $request->file('image')->extension();

            $request->file('image')
                ->move(public_path('uploads/blogs'), $file);

            $data['image'] = $file;
        }

        $blog->update($data);

        return redirect('/admin/blogs')
            ->with('success', 'Blog Updated Successfully');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if (
            $blog->image &&
            file_exists(
                public_path(
                    'uploads/blogs/' . $blog->image
                )
            )
        ) {
            unlink(
                public_path(
                    'uploads/blogs/' . $blog->image
                )
            );
        }

        $blog->delete();

        return back()
            ->with('success', 'Blog Deleted Successfully');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:blog_categories,name'
        ]);

        $id = DB::table('blog_categories')->insertGetId([
            'name'       => $request->name,
            'slug'       => Str::slug($request->name),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'id'      => $id,
            'name'    => $request->name
        ]);
    }

	public function deleteCategory(Request $request, $id)
{
    $category = DB::table('blog_categories')
        ->where('id', $id)
        ->first();

    if (!$category) {
        return response()->json([
            'success' => false,
            'message' => 'Category not found'
        ]);
    }

    $blogsCount = Blog::where('category_id', $id)->count();

    /*
    =====================================
    IF BLOGS EXIST
    =====================================
    */
    if ($blogsCount > 0) {

        /*
        MOVE BLOGS TO OTHER CATEGORY
        */
        if ($request->action == 'move') {

            if (!$request->move_to) {
                return response()->json([
                    'success' => false,
                    'message' => 'Target category required'
                ]);
            }

            Blog::where('category_id', $id)
                ->update([
                    'category_id' => $request->move_to
                ]);

            DB::table('blog_categories')
                ->where('id', $id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted and blogs moved successfully'
            ]);
        }

        /*
        DELETE BLOGS + CATEGORY
        */
        if ($request->action == 'delete_all') {

            Blog::where('category_id', $id)->delete();

            DB::table('blog_categories')
                ->where('id', $id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category and related blogs deleted successfully'
            ]);
        }

        /*
        ASK USER WHAT TO DO
        */
        return response()->json([
            'success' => false,
            'need_action' => true,
            'message' => 'This category is used in blogs'
        ]);
    }

    /*
    NO BLOGS FOUND
    */
    DB::table('blog_categories')
        ->where('id', $id)
        ->delete();

    return response()->json([
        'success' => true,
        'message' => 'Category Deleted Successfully'
    ]);
}

     public function uploadEditorImage(Request $request)
{
    if ($request->hasFile('upload')) {

        $file = $request->file('upload');

        $name = time().'_'.$file->getClientOriginalName();

        $destination = public_path('uploads/editor');

        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }

        $file->move($destination, $name);

        return response()->json([
            'uploaded' => 1,
            'fileName' => $name,
            'url' => asset('uploads/editor/'.$name)
        ]);
    }

    return response()->json([
        'uploaded' => 0,
        'error' => [
            'message' => 'Image upload failed'
        ]
    ]);
}

     public function export()
{
    return Excel::download(
        new BlogsExport,
        'blogs.xlsx'
    );
}

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    Excel::import(
        new BlogsImport,
        $request->file('file')
    );

    return back()->with(
        'success',
        'Blogs Imported Successfully'
    );
}

}