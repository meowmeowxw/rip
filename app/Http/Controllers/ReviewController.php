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

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth',
            'customer'
        ]);
    }

    public function checkIfAlreadyReviewed($customer, $id, $reviewable_type)
    {
        if ($reviewable_type !== 'App\\Models\\Product') {
            $reviewable_type = Seller::class;
        }
        return $customer->reviews->where('reviewable_type', $reviewable_type)
            ->where('reviewable_id', $id)->count() > 0;
    }

    public function checkIfCustomerOrdered($customer, $id, $reviewable_type)
    {
        if ($reviewable_type !== 'App\\Models\\Product') {
            return DB::table('customers')
                ->join('orders', 'customers.id', '=', 'orders.customer_id')
                ->join('seller_orders', 'orders.id', '=', 'seller_orders.order_id')
                ->join('sub_orders', 'seller_orders.id', '=', 'sub_orders.seller_order_id')
                ->select('customers.id')
                ->where('orders.customer_id', '=', $customer->id)
                ->get()
                ->count() > 0;
        } else {
            $products_ordered = DB::table('customers')
                ->join('orders', 'customers.id', '=', 'orders.customer_id')
                ->join('seller_orders', 'orders.id', '=', 'seller_orders.order_id')
                ->join('sub_orders', 'seller_orders.id', '=', 'sub_orders.seller_order_id')
                ->select('customers.id', 'sub_orders.product_id')
                ->where('sub_orders.product_id', '=', $id)
                ->where('orders.customer_id', '=', $customer->id)
                ->get();
            return $products_ordered->count() > 0;
        }
    }

    public function updateReview(Request $request)
    {
        $request->validate([
            'star' => 'required|int|max:5|min:1',
            'description' => 'required|string|max:128',
            'id' => 'required|int',
            'reviewable_type' => 'required|string|max:128'
        ]);
        $user = Auth::user();
        $customer = $user->role();
        if ($this->checkIfCustomerOrdered($customer, $request->id, $request->reviewable_type)) {
            if (!$this->checkIfAlreadyReviewed($customer, $request->id, $request->reviewable_type)) {
                Review::create([
                    'description' => $request->description,
                    'star' => $request->star,
                    'reviewable_type' => $request->reviewable_type,
                    'reviewable_id' => $request->id,
                    'customer_id' => $customer->id,
                ]);
            } else {
                $rev = $customer->reviews->where('reviewable_id', $request->id)
                    ->where('reviewable_type', $request->reviewable_type)
                    ->first();
                $rev->description = $request->description;
                $rev->star = $request->star;
                $rev->save();
            }
        } else {
            abort(405);
        }

        if ($request->reviewable_type === "App\\Models\\Seller") {
            return redirect("/seller/".$request->id);
        } else {
            return redirect("/product/".$request->id);
        }
    }

}
