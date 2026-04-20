<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings');
    }

    public function save(Request $request)
    {
        /* ================= HEADER LOGO ================= */
        if ($request->hasFile('logo')) {

            $file = $request->file('logo');
            $name = time().'_header.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/settings'), $name);

            DB::table('settings')->updateOrInsert(
                ['key' => 'logo'],
                ['value' => 'uploads/settings/'.$name]
            );
        }

        /* ================= FOOTER LOGO ================= */
        if ($request->hasFile('footer_logo')) {

            $file = $request->file('footer_logo');
            $name = time().'_footer.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/settings'), $name);

            DB::table('settings')->updateOrInsert(
                ['key' => 'footer_logo'],
                ['value' => 'uploads/settings/'.$name]
            );
        }

        /* ================= FAVICON ================= */
        if ($request->hasFile('favicon')) {

            $file = $request->file('favicon');
            $name = time().'_favicon.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/settings'), $name);

            DB::table('settings')->updateOrInsert(
                ['key' => 'favicon'],
                ['value' => 'uploads/settings/'.$name]
            );
        }

        /* ================= SOCIAL LINKS SAVE ================= */

        if ($request->has('social_name')) {

            $socials = [];

            foreach ($request->social_name as $i => $name) {

                if (
                    !empty($name) &&
                    !empty($request->social_url[$i])
                ) {
                    $socials[] = [
                        'name' => $name,
                        'icon' => $request->social_icon[$i] ?? 'fa-solid fa-link',
                        'url'  => $request->social_url[$i]
                    ];
                }
            }

            DB::table('settings')->updateOrInsert(
                ['key' => 'social_links'],
                ['value' => json_encode($socials)]
            );
        }

        /* ================= OTHER SETTINGS ================= */

        $skip = [
            '_token',
            'logo',
            'footer_logo',
            'favicon',
            'social_name',
            'social_icon',
            'social_url'
        ];

        foreach ($request->except($skip) as $key => $value) {

            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                [
                    'value' => is_array($value)
                        ? json_encode($value)
                        : $value
                ]
            );
        }

        /* ================= CHECKBOX FIX ================= */

        if (!$request->has('maintenance')) {

            DB::table('settings')->updateOrInsert(
                ['key' => 'maintenance'],
                ['value' => 0]
            );
        }

        return back()->with('success', 'Settings Saved Successfully');
    }
}