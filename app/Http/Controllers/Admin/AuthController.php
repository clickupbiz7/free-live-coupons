<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Login Form
    |--------------------------------------------------------------------------
    */
    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt([
            'email'    => $request->email,
            'password' => $request->password
        ], $remember)) {

            $request->session()->regenerate();

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Login Successful');
        }

        return back()->with('error', 'Invalid Login Details');
    }

    /*
    |--------------------------------------------------------------------------
    | Profile Page
    |--------------------------------------------------------------------------
    */
    public function profile()
    {
        return view('admin.profile');
    }

    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'new_email' => 'nullable|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|confirmed|min:8'
        ]);

        /*
        |--------------------------------------------------------------------------
        | PASSWORD UPDATE
        |--------------------------------------------------------------------------
        */
        if ($request->filled('password')) {

            if (!$request->filled('current_password')) {
                return back()->with('error', 'Current password required');
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password incorrect');
            }

            $user->password = Hash::make($request->password);
            $user->save();
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPLE EMAIL CHANGE SYSTEM
        |--------------------------------------------------------------------------
        */
        if ($request->filled('new_email')) {

            if ($request->new_email == $user->email) {
                return back()->with('error', 'New email must be different');
            }

            $token = Str::random(64);

            $user->pending_email      = $request->new_email;
            $user->email_change_token = $token;
            $user->save();

            $link = route('admin.confirm.current.email', $token);

            Mail::html("
                <div style='font-family:Arial;padding:30px'>
                    <h2>Confirm Email Change</h2>

                    <p>You requested to change your login email.</p>

                    <p>Click button below to confirm.</p>

                    <a href='{$link}'
                    style='background:#111827;
                           color:#fff;
                           padding:12px 22px;
                           border-radius:8px;
                           text-decoration:none;
                           display:inline-block'>
                        Confirm Email Change
                    </a>
                </div>
            ", function ($message) use ($user) {

                $message->to($user->email)
                        ->subject('Confirm Email Change');

            });

            return back()->with(
                'success',
                'Confirmation link sent to CURRENT email.'
            );
        }

        return back()->with(
            'success',
            'Profile Updated Successfully'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIRM CURRENT EMAIL
    |--------------------------------------------------------------------------
    */
    public function confirmCurrentEmail($token)
    {
        $user = User::where(
            'email_change_token',
            $token
        )->first();

        if (!$user) {
            return redirect('/admin/profile')
                ->with('error', 'Invalid link');
        }

        $user->email = $user->pending_email;
        $user->pending_email = null;
        $user->email_change_token = null;
        $user->email_verified_at = now();
        $user->save();

        return redirect('/admin/profile')
            ->with(
                'success',
                'Email updated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFY NEW EMAIL (NOT USED NOW)
    |--------------------------------------------------------------------------
    */
    public function verifyNewEmail($token)
    {
        return redirect('/admin/profile');
    }

    /*
    |--------------------------------------------------------------------------
    | Forgot Password Form
    |--------------------------------------------------------------------------
    */
    public function forgotForm()
    {
        return view('admin.forgot');
    }

    /*
    |--------------------------------------------------------------------------
    | Forgot Password Submit
    |--------------------------------------------------------------------------
    */
    public function forgotSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where(
            'email',
            $request->email
        )->first();

        if (!$user) {
            return back()->with('error', 'Email not found');
        }

        $newPassword = 'Admin@123';

        $user->password = Hash::make($newPassword);
        $user->save();

        return back()->with(
            'success',
            'Password Reset Successful. New Password: ' . $newPassword
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('success', 'Logged Out Successfully');
    }
}
