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
        $customer = Auth::user()->role();
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
        } elseif ($request->type === 'payment-info') {
            $request->validate([
                'card_number' => 'required|string|digits_between:10,24',
                'expire' => 'required|date',
            ]);
            $user->role()->paymentInfo->credit_card = $request->credit_card;
            $user->role()->paymentInfo->expire = $request->expire;
            $user->role()->paymentInfo->save();
        } elseIf ($request->type === 'shipping-info') {
            $request->validate([
                'street' => 'required|string|max:128',
                'city' => 'required|string|max:128',
                'cap' => 'required|string|digits_between:3,10',
                'id' => 'required'
            ]);
            $s = $user->role()->shippingInfos()->find($request->id);
            if (is_null($s)) {
                return redirect(route('customer.settings'));
            }
            $s->street = $request->street;
            $s->city = $request->city;
            $s->cap = $request->cap;
            $s->save();
        }

        return redirect(route('customer.settings'));
    }
}
