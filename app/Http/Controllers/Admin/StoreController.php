<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::latest()->get();
        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
        return view('admin.stores.create');
    }

  public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
    ]);

    $data = [];

    $data['name'] = $request->name;
    $data['slug'] = \Str::slug($request->name);
    $data['status'] = 1;

    // IMAGE UPLOAD (LOGO)
    if ($request->hasFile('logo')) {

        $image = $request->file('logo');

        $filename = time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('uploads/stores'), $filename);

        $data['logo'] = $filename;
    }

    \App\Models\Store::create($data);

    return redirect('/admin/stores')->with('success', 'Store Added');
}
    public function edit($id)
    {
        $store = Store::findOrFail($id);
        return view('admin.stores.edit', compact('store'));
    }

    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);

        $request->validate([
            'name' => 'required'
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $file = time().'_'.$request->logo->getClientOriginalName();
            $request->logo->move(public_path('uploads/stores'), $file);
            $data['logo'] = $file;
        }

        $store->update($data);

        return redirect('/admin/stores')->with('success', 'Store Updated');
    }

    public function destroy($id)
    {
        Store::findOrFail($id)->delete();
        return back()->with('success', 'Deleted');
    }
}