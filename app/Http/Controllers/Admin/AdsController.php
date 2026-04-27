<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;

class AdsController extends Controller
{
    public function index()
    {
        $ads = Ad::latest()->get();
        return view('admin.ads.index', compact('ads'));
    }

    public function create()
    {
        return view('admin.ads.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required',
            'network'    => 'required',
            'placement'  => 'required',
            'ad_code'    => 'required',
        ]);

        Ad::create([
            'title'      => $request->title,
            'network'    => $request->network,
            'placement'  => $request->placement,
            'size'       => $request->size,
            'device'     => $request->device,
            'priority'   => $request->priority ?? 1,
            'ad_code'    => $request->ad_code,
            'status'     => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.ads.index')
            ->with('success', 'Ad Added Successfully');
    }

    public function edit($id)
    {
        $ad = Ad::findOrFail($id);
        return view('admin.ads.form', compact('ad'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'      => 'required',
            'network'    => 'required',
            'placement'  => 'required',
            'ad_code'    => 'required',
        ]);

        $ad = Ad::findOrFail($id);

        $ad->update([
            'title'      => $request->title,
            'network'    => $request->network,
            'placement'  => $request->placement,
            'size'       => $request->size,
            'device'     => $request->device,
            'priority'   => $request->priority ?? 1,
            'ad_code'    => $request->ad_code,
            'status'     => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.ads.index')
            ->with('success', 'Ad Updated Successfully');
    }

    public function destroy($id)
    {
        $ad = Ad::findOrFail($id);
        $ad->delete();

        return back()->with('success', 'Ad Deleted Successfully');
    }
}