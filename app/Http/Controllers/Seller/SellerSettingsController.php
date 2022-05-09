<?php

namespace App\Http\Controllers\Seller;

use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerSettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware([
            'auth',
            'seller'
        ]);
    }

    /**
     * Display the registration seller view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $seller = Auth::user()->role();
        return view('seller.settings', ['seller' => $seller]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * TODO
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'company' => 'required|string|max:64',
            'description' => 'required|string|max:300',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->seller->company = $request->company;
        $user->seller->description = $request->description;
        $user->seller->save();
        $user->save();
        return redirect(route('seller.settings'));
    }
}
