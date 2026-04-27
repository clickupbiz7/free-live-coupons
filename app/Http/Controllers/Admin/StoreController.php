<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Exports\StoresExport;
use App\Imports\StoresImport;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;


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
        $data['slug'] = Str::slug($request->name);

        /* STATUS FIX */
        $data['status'] = $request->status ?? 1;

        /* IMAGE UPLOAD */
        if ($request->hasFile('logo')) {

            $image = $request->file('logo');

            $filename = time().'.'.$image->getClientOriginalExtension();

            $image->move(
                public_path('uploads/stores'),
                $filename
            );

            $data['logo'] = $filename;
        }

        Store::create($data);

        return redirect('/admin/stores')
            ->with('success', 'Store Added Successfully');
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

        $data = [];

        $data['name'] = $request->name;
        $data['slug'] = Str::slug($request->name);

        /* STATUS FIX */
        $data['status'] = $request->status ?? 1;

        if ($request->hasFile('logo')) {

            /* OLD DELETE */
            if (
                $store->logo &&
                file_exists(
                    public_path(
                        'uploads/stores/'.$store->logo
                    )
                )
            ) {
                unlink(
                    public_path(
                        'uploads/stores/'.$store->logo
                    )
                );
            }

            $file = time().'.'.$request->logo->getClientOriginalExtension();

            $request->logo->move(
                public_path('uploads/stores'),
                $file
            );

            $data['logo'] = $file;
        }

        $store->update($data);

        return redirect('/admin/stores')
            ->with('success', 'Store Updated Successfully');
    }

    public function destroy($id)
    {
        $store = Store::findOrFail($id);

        if (
            $store->logo &&
            file_exists(
                public_path(
                    'uploads/stores/'.$store->logo
                )
            )
        ) {
            unlink(
                public_path(
                    'uploads/stores/'.$store->logo
                )
            );
        }

        $store->delete();

        return back()->with('success', 'Store Deleted Successfully');
    }

     public function export()
{
    return Excel::download(
        new StoresExport,
        'stores.xlsx'
    );
}

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    Excel::import(
        new StoresImport,
        $request->file('file')
    );

    return back()->with(
        'success',
        'Stores Imported Successfully'
    );
}

}