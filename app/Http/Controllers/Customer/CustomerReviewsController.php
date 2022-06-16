<?php

namespace App\Http\Controllers\Customer;

use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\Gate;

class CustomerReviewsController extends Controller
{

    public function __construct()
    {
        $this->middleware([
            'auth',
            'customer'
        ]);
    }

    public function show()
    {
        $reviews = Auth::user()->role()->reviews;
        return view('customer.reviews', ['reviews' => $reviews]);

    }

    public function detail($id)
    {
        $review = Auth::user()->role()->reviews->where("id", $id)->first();
        if ($review) {
            return view('customer.review', ['review' => $review]);
        }
    }

}
