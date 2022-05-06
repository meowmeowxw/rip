<?php

namespace App\Http\Controllers\Customer;

use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\Gate;

class CustomerOrdersController extends Controller
{

    public function __construct()
    {
        $this->middleware([
            'auth',
            'customer'
        ]);
    }

    /**
     * Display the customer order[s] view
     *
     * @return \Illuminate\View\View
     */
    public function create($id = null)
    {
        if ($id) {
            $order = Order::find($id);
            if ($order && Gate::allows('customer-order', $order)) {
                return view('customer.order', [
                    'order' => $order,
                ]);
            } else {
                abort(403);
            }
        }

        $customer = Auth::user()->customer;

        if ($customer->orders()->count() === 0) {
            return view('customer.orders', [
                'orders' => null,
            ]);
        }

        return view('customer.orders', [
            'orders' => $customer->orders()->orderBy('id', 'DESC')->paginate(5)
        ]);
    }

}
