<?php

namespace App\Http\Controllers\Customer;

use App\Models\PaymentInfo;
use App\Providers\RouteServiceProvider;
use App\Models\ShippingInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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

    public function addShippingInfo(Request $request)
    {
        $request->validate([
            'street' => 'required|string|max:128',
            'city' => 'required|string|max:128',
            'cap' => 'required|string|digits_between:3,10',
        ]);
        $customer = Auth::user()->role();

        $customer->shippingInfos()->save($s = ShippingInfo::make([
            'street' => $request->street,
            'city' => $request->city,
            'cap' => $request->cap,
        ]));
        $s->save();
        return redirect(route('customer.settings'));
    }

    public function addPaymentInfo(Request $request)
    {
        $request->validate([
            'card_number' => 'required|string|digits_between:10,24',
            'expire' => 'required|date',
        ]);
        $customer = Auth::user()->role();

        $customer->paymentInfos()->save($p = PaymentInfo::make([
            'card_number' => $request->card_number,
            'expire' => $request->expire,
        ]));
        $p->save();
        return redirect(route('customer.settings'));
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
            if ($request->action === 'Delete') {
                if ($user->role()->paymentInfos->count() >= 2) {
                    $p = $user->role()->paymentInfos->where('id', $request->id)->first();
                    if ($p) {
                        $p->delete();
                    }
                } else {
                    return redirect(route('customer.settings'));
                }
            } else {
                $p = $user->role()->paymentInfos->where('id', $request->id)->first();
                $p->card_number = $request->card_number;
                $p->expire = $request->expire;
                $p->save();
            }
        } elseIf ($request->type === 'shipping-info') {
            $request->validate([
                'street' => 'required|string|max:128',
                'city' => 'required|string|max:128',
                'cap' => 'required|string|digits_between:3,10',
                'id' => 'required'
            ]);
            if ($request->action === 'Delete') {
                if ($user->role()->shippingInfos->count() >= 2) {
                    $s = $user->role()->shippingInfos->where('id', $request->id)->first();
                    if ($s) {
                        $s->delete();
                    }
                } else {
                    return redirect(route('customer.settings'));
                }
            } else {
                $s = $user->role()->shippingInfos->where('id', $request->id)->first();
                if (is_null($s)) {
                    App::abort(403, 's is '.$s);
                    return redirect(route('customer.settings'));
                }
                $s->street = $request->street;
                $s->city = $request->city;
                $s->cap = $request->cap;
                $s->save();
            }
        }

        return redirect(route('customer.settings'));
    }
}
