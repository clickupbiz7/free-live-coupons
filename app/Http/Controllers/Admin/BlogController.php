<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => 1
        ];

        // IMAGE UPLOAD
        if ($request->hasFile('image')) {
            $file = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads/blogs'), $file);
            $data['image'] = $file;
        }

        Blog::create($data);

        return redirect('/admin/blogs')->with('success', 'Blog Added');
    }

    public function edit($id)
    {
        return view('admin.blogs.edit', [
            'blog' => Blog::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
        ];

        // IMAGE UPDATE
        if ($request->hasFile('image')) {

            if ($blog->image && file_exists(public_path('uploads/blogs/' . $blog->image))) {
                unlink(public_path('uploads/blogs/' . $blog->image));
            }

            $file = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads/blogs'), $file);

            $data['image'] = $file;
        }

        $blog->update($data);

        return redirect('/admin/blogs')->with('success', 'Blog Updated');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image && file_exists(public_path('uploads/blogs/' . $blog->image))) {
            unlink(public_path('uploads/blogs/' . $blog->image));
        }

        $blog->delete();

        return back()->with('success', 'Blog Deleted');
    }
}