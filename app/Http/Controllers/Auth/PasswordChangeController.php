<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\ChangePassword;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordChangeController extends Controller
{
    /**
     * Instantiate a new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Handle an incoming reset password request
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * TODO Email
     */
    public function edit(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:1',
            'new_password' => 'required|string|confirmed|min:1',
        ]);

        if (Auth::attempt(['email' => Auth::user()->email, 'password' => $request->password])) {
            $user = Auth::user();
            $user->password = Hash::make($request->new_password);
            $user->save();
            $request->session()->regenerate();
            Mail::to($user->email)->send(new ChangePassword($user));
            return redirect()->back();
        }

        return back()->withErrors([
            'password' => 'Old password doesn\'t match'
        ]);
    }

}
