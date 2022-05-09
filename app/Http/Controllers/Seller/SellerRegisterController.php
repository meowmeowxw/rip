<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerRegisterController extends Controller
{
    /**
     * Instantiate a new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('seller.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:1',
            'company' => 'required|string|max:64',
            'description' => 'required|string|max:300'
        ]);

        $seller = Seller::create([
            'company' => $request->company,
            'description' => $request->description,
        ]);

        Auth::login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_seller' => true,
            'userable_id' => $seller->id,
            'userable_type' => Seller::class,
        ]));

        event(new Registered($user));
        Mail::to($user->email)->send(new NewUser($user));

        return redirect(RouteServiceProvider::HOME);
    }
}
