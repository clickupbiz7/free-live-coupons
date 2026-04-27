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
        /*
        ==========================================
        REMOVE IMAGES
        ==========================================
        */
        $removeFiles = [
            'remove_logo'           => 'logo',
            'remove_footer_logo'   => 'footer_logo',
            'remove_favicon'       => 'favicon',
            'remove_youtube_thumb' => 'youtube_thumb',
        ];

        foreach ($removeFiles as $removeKey => $dbKey) {

            if ($request->$removeKey == 1) {

                $old = DB::table('settings')
                    ->where('key', $dbKey)
                    ->value('value');

                if ($old) {

                    $path = $dbKey == 'logo' ||
                            $dbKey == 'footer_logo' ||
                            $dbKey == 'favicon'
                        ? public_path($old)
                        : public_path('uploads/settings/'.$old);

                    if (file_exists($path)) {
                        @unlink($path);
                    }
                }

                DB::table('settings')->updateOrInsert(
                    ['key' => $dbKey],
                    ['value' => '']
                );
            }
        }

        /*
        ==========================================
        FILE UPLOADS
        ==========================================
        */

        if ($request->hasFile('logo')) {

            $file = $request->file('logo');
            $name = time().'_header.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/settings'), $name);

            DB::table('settings')->updateOrInsert(
                ['key' => 'logo'],
                ['value' => 'uploads/settings/'.$name]
            );
        }

        if ($request->hasFile('footer_logo')) {

            $file = $request->file('footer_logo');
            $name = time().'_footer.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/settings'), $name);

            DB::table('settings')->updateOrInsert(
                ['key' => 'footer_logo'],
                ['value' => 'uploads/settings/'.$name]
            );
        }

        if ($request->hasFile('favicon')) {

            $file = $request->file('favicon');
            $name = time().'_favicon.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/settings'), $name);

            DB::table('settings')->updateOrInsert(
                ['key' => 'favicon'],
                ['value' => 'uploads/settings/'.$name]
            );
        }

        if ($request->hasFile('youtube_thumb')) {

            $file = $request->file('youtube_thumb');
            $name = time().'_youtube.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/settings'), $name);

            DB::table('settings')->updateOrInsert(
                ['key' => 'youtube_thumb'],
                ['value' => $name]
            );
        }

        /*
        ==========================================
        SOCIAL LINKS
        ==========================================
        */
        if ($request->has('social_platform')) {

            $socials = [];

            foreach ($request->social_platform as $i => $platform) {

                $platform = trim($platform);
                $url = trim($request->social_url[$i] ?? '');

                if ($platform && $url) {

                    $socials[] = [
                        'platform' => $platform,
                        'icon' => $this->getSocialIcon($platform),
                        'url' => $url
                    ];
                }
            }

            DB::table('settings')->updateOrInsert(
                ['key' => 'social_links'],
                ['value' => json_encode($socials)]
            );
        }

        /*
        ==========================================
        OTHER TEXT SETTINGS
        ==========================================
        */
        $skip = [
            '_token',
            'logo',
            'footer_logo',
            'favicon',
            'youtube_thumb',
            'remove_logo',
            'remove_footer_logo',
            'remove_favicon',
            'remove_youtube_thumb',
            'social_platform',
            'social_url'
        ];

        foreach ($request->except($skip) as $key => $value) {

            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => is_array($value) ? json_encode($value) : $value]
            );
        }

        return back()->with('success', 'Settings Saved Successfully');
    }

    private function getSocialIcon($platform)
    {
        $platform = strtolower($platform);

        $icons = [
            'facebook'  => 'fab fa-facebook-f',
            'instagram' => 'fab fa-instagram',
            'youtube'   => 'fab fa-youtube',
            'twitter'   => 'fab fa-x-twitter',
            'x'         => 'fab fa-x-twitter',
            'tiktok'    => 'fab fa-tiktok',
            'whatsapp'  => 'fab fa-whatsapp',
            'telegram'  => 'fab fa-telegram-plane',
            'linkedin'  => 'fab fa-linkedin-in',
            'snapchat'  => 'fab fa-snapchat-ghost',
        ];

        return $icons[$platform] ?? 'fa-solid fa-link';
    }
}