<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::with('store','category')->latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create', [
            'stores' => Store::all(),
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'code' => 'required',
            'discount' => 'required',
            'store_id' => 'required',
            'category_id' => 'required',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['status'] = 1;

        if ($request->hasFile('image')) {
            $file = time().'.'.$request->file('image')->extension();
            $request->file('image')->move(public_path('uploads/coupons'), $file);
            $data['image'] = $file;
        }

        Coupon::create($data);

        return redirect()->route('admin.coupons.index')
            ->with('success','Coupon Added');
    }

    public function show($id)
    {
        return redirect()->route('admin.coupons.index');
    }

    public function edit($id)
    {
        return view('admin.coupons.edit', [
            'coupon' => Coupon::findOrFail($id),
            'stores' => Store::all(),
            'categories' => Category::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {

            if ($coupon->image && file_exists(public_path('uploads/coupons/'.$coupon->image))) {
                unlink(public_path('uploads/coupons/'.$coupon->image));
            }

            $file = time().'.'.$request->file('image')->extension();
            $request->file('image')->move(public_path('uploads/coupons'), $file);
            $data['image'] = $file;
        }

        $coupon->update($data);

        return redirect()->route('admin.coupons.index')
            ->with('success','Coupon Updated');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);

        if ($coupon->image && file_exists(public_path('uploads/coupons/'.$coupon->image))) {
            unlink(public_path('uploads/coupons/'.$coupon->image));
        }

        $coupon->delete();

        return back()->with('success','Coupon Deleted');
    }
}
