<?php


namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
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
        $can_review = false;
        if (!Auth::user()->is_seller()) {
            $customer = Auth::user()->role();
            if (!$this->checkIfProductIsAlreadyReviewed($product->id, Auth::user()->role())) {
                $can_review = $this->checkIfCustomerOrderedProduct($product->id, Auth::user()->role()->id);
            }
        }
        return view('product', [
            'product' => $product,
            'seller' => $seller,
            'category' => $category,
            'reviews' => $product->reviews,
            'can_review' => $can_review,
        ]);
    }

    public function checkIfProductIsAlreadyReviewed($product_id, $customer)
    {
        return $customer->reviews->where('reviewable_type', Product::class)
            ->where('reviewable_id', $product_id)->count() > 0;
    }

    public function checkIfCustomerOrderedProduct($product_id, $customer_id)
    {
        $products_ordered = DB::table('customers')
            ->join('orders', 'customers.id', '=', 'orders.customer_id')
            ->join('seller_orders', 'orders.id', '=', 'seller_orders.order_id')
            ->join('sub_orders', 'seller_orders.id', '=', 'sub_orders.seller_order_id')
            ->select('customers.id', 'sub_orders.product_id')
            ->where('sub_orders.product_id', '=', $product_id)
            ->where('orders.customer_id', '=', $customer_id)
            ->get();
        return $products_ordered->count() > 0;
    }
    public function setReview(Request $request)
    {
        if (Auth::user()->is_seller()) {
            abort(404);
        }

        $request->validate([
            'star' => 'required|int|max:5|min:1',
            'description' => 'required|string|max:128',
            'id' => 'required|int',
        ]);
        $user = Auth::user();
        $customer = $user->role();
        if ($this->checkIfCustomerOrderedProduct($request->id, $customer->id)) {
            $rev = Review::create([
                'description' => $request->description,
                'star' => $request->star,
                'reviewable_type' => "App\\Models\\Product",
                'reviewable_id' => $request->id,
                'customer_id' => $customer->id,
            ]);
            //echo $request->id;
            //echo($products_ordered);
        } else {
            abort(405);
        }
        return redirect("/product/".$request->id);
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
