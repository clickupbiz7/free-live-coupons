<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        ], $remember))
        {
            $request->session()->regenerate();

            session([
                'last_activity' => time()
            ]);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Login Successful');
        }

        return back()->with('error', 'Invalid Login Details');
    }

    /*
    |--------------------------------------------------------------------------
    | Show Profile Page
    |--------------------------------------------------------------------------
    */
    public function profile()
    {
        return view('admin.profile');
    }

    /*
    |--------------------------------------------------------------------------
    | Update Email / Password
    |--------------------------------------------------------------------------
    */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,

            'password' => [
                'nullable',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ]
        ]);

        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profile Updated Successfully');
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

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email Not Found');
        }

        // Temporary New Password
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

        return redirect()->route('admin.login')
            ->with('success', 'Logged Out Successfully');
    }
}