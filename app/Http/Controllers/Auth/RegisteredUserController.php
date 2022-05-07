<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewUser;
use App\Models\Customer;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
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
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
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
        ]);

        $customer = new Customer();

        if ($request->filled('credit_card')) {
            $request->validate([
                'credit_card' => 'string|numeric|digits_between:10,24',
            ]);
            $customer->credit_card = $request->credit_card;
        }

        if ($request->filled('street')) {
            $request->validate([
                'street' => 'string|max:128',
            ]);
            $customer->street = $request->street;
        }

        if ($request->filled('city')) {
            $request->validate([
                'city' => 'string|max:128',
            ]);
            $customer->city = $request->city;
        }

        Auth::login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_seller' => false,
            'userable_id' => $customer->id,
            'userable_type' => Customer::class,
        ]));

        $user->saveAll();
        // $user->customer()->save($customer);

        event(new Registered($user));
        Mail::to($request->email)->send(new NewUser($user));

        return redirect(RouteServiceProvider::HOME);
    }
}
