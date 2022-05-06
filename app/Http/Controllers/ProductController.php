<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Category;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Return the view of a product
     * @param id of the product
     *
     * @return  View
     */
    public function view($id = 1)
    {
        $product = Product::find($id);
        if (!$product) {
            abort(404);
        }

        if (!$product->active) {
            return redirect(route('dashboard'));
        }
        $seller = $product->seller;
        $category = $product->category;
        return view('product', [
            'product' => $product,
            'seller' => $seller,
            'category' => $category,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     *
     */
    public function show()
    {
        $products = Product::where('active', true)->paginate(Config::get('constants.numProducts'));
        $latest = Product::orderBy('created_at', 'DESC')
            ->where('active', true)
            ->where('quantity', '>', 0)
            ->take(3)->get();
        return view('dashboard', [
            'latest' => $latest,
            'products' => $products,
            'categories' => Category::all(),
        ]);
    }
}
