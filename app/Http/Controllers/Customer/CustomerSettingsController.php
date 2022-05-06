<?php

namespace App\Http\Controllers\Customer;

use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerSettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware([
            'auth',
            'customer'
        ]);
    }

    /**
     * Display the customer settings view
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $customer = Auth::user()->customer;
        return view('customer.settings', ['customer' => $customer]);
    }

    /**
     * Handle an incoming settings edit request
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
        ]);

        $user = Auth::user();
        if ($request->type === 'user') {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email',
            ]);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
        } elseif ($request->type === 'customer') {
            $request->validate([
                'credit_card' => 'required|string|digits_between:10,24',
                'street' => 'required|string|max:128',
                'city' => 'required|string|max:128',
            ]);
            $user->customer->credit_card = $request->credit_card;
            $user->customer->street = $request->street;
            $user->customer->city = $request->city;
            $user->customer->save();
        }

        return redirect(route('customer.settings'));
    }
}
