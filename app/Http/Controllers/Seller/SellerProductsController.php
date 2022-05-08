<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller;
use App\Models\Category;
use App\Models\Product;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SellerProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware([
            'auth',
            'seller'
        ]);
    }

    /**
     * Delete a product (Set quantity to 0 and active to false)
     *
     * @return \Illuminate\View\View
     */
    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|integer',
        ]);

        if (! Gate::allows('edit-product', Product::find($request->id))) {
            abort(403);
        }

        $product = Auth::user()->role()->products()->find($request->id);
        $product->active = false;
        $product->quantity = 0;
        $product->save();
        return back();
    }
    /**
     * Edit a product
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:60',
            'description' => 'required|string|max:1024',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|integer|min:0',
            'id' => 'required|numeric|integer',
            'cl' => 'required|numeric|integer|min:10',
            'alcohol' => 'required|numeric|min:0',
            // 'path' => 'required|string|max:1024',
        ]);

        if (! Gate::allows('edit-product', Product::find($request->id))) {
            abort(403);
        }

        $product = Auth::user()->role()->products()->find($request->id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->cl = $request->cl;
        $product->alcohol = $request->alcohol;
        // $product->path = $request->path;
        $product->save();
        return back();
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:60',
            'description' => 'required|string|max:1024',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|integer|min:0',
            'logo' => 'mimes:jpg,bmp,png|required',
            'category' => 'required|string',
            'cl' => 'required|numeric|integer|min:10',
            'alcohol' => 'required|numeric|min:0',
        ]);

        $category = Category::where('name', $request->category)->first();
        if (!$category) {
            return back()->withErrors([
                'category' => 'invalid category',
            ]);
        }
        if(config('app.env') === 'production') {
            $path = $request->file('logo')->store('logos', 's3');
            $url = Storage::disk('s3')->url($path);
        } else {
            $url = '/'.$request->file('logo')->store('logos');
        }
        $product = new Product([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'cl' => $request->cl,
            'alcohol' => $request->alcohol,
            'path' => $url,
        ]);
        $product->category_id = $category->id;
        $product->seller_id = Auth::user()->role()->id;
        $product->save();
        return back();
    }

    /**
     * Display the registration seller view.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create()
    {
        return redirect(route('seller.id', Auth::user()->role()->id));
    }

    /**
     * Display Add product view.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function createAdd()
    {
        return view('seller.product-add');
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
        Auth::user()->is_seller = true;
        Auth::user()->save();
        Auth::user()->role()->create([
            'company' => $request->company,
            'credit_card' => $request->credit_card,
        ]);
        return redirect(RouteServiceProvider::HOME);
    }
}
