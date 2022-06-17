<?php

namespace App\Http\Controllers\Customer;

use App\Mail\NewCustomerOrder;
use App\Mail\NewSellerOrder;
use App\Mail\NewUser;
use App\Notifications\NotificationCustomerOrder;
use App\Notifications\NotificationSellerOrder;
use App\Providers\RouteServiceProvider;
use App\Models\Product;
use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use App\Models\SellerOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class CustomerCartController extends Controller
{

    private function errorQuantity($id = null)
    {
        return back()->withErrors([
            'quantity' . $id => 'The selected quantity is not available',
        ]);
    }

    private function errorQuantityAjax() {
        return response()->json([
            'error' => 'The selected quantity is not available',
        ]);
    }

    private function updateQuantity(Request $request, $add = true)
    {
        $request->validate([
            'id' => 'required|numeric|integer',
            'quantity' => 'required|numeric|integer|min:1',
        ]);

        $product = Product::find($request->id);
        $session = $request->session();

        $product_id = $request->input('id');
        $id = $add ? null : $product_id;
        $ordered_quantity = $request->input('quantity');

        if ($ordered_quantity > $product->quantity) {
            if ($request->ajax()) {
                return $this->errorQuantityAjax();
            }
            return $this->errorQuantity($id);
        }

        if ($session->has('productsOrder')) {
            $productsOrder = $session->get('productsOrder');
            foreach ($productsOrder as $i => $po) {
                if ($po["product_id"] === $product_id) {
                    if ($add && $po["ordered_quantity"] + $ordered_quantity > $product->quantity) {
                        return $this->errorQuantity($id);
                    }

                    $session->forget('productsOrder');
                    $precedentQuantity = 0;
                    if ($add) {
                        $productsOrder[$i]["ordered_quantity"] += $ordered_quantity;
                    } else {
                        $precedentQuantity = $productsOrder[$i]["ordered_quantity"];
                        $productsOrder[$i]["ordered_quantity"] = $ordered_quantity;
                    }

                    $session->put('productsOrder', $productsOrder);
                    if ($request->ajax()) {
                        return response()->json([
                            'old_price' => $product->price * $precedentQuantity,
                            'new_price' => $product->price * $ordered_quantity,
                        ]);
                    }
                    return true;
                }
            }
        }

        return false;
    }

    public function __construct()
    {
        $this->middleware([
            'auth',
            'customer'
        ]);
    }

    /**
     * Display the customer cart view
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $productsOrder = $request->session()->get('productsOrder');

        if (!$productsOrder) {
            return view('customer.cart');
        }

        $finalOrder = [];
        $total_price = 0;
        foreach ($productsOrder as $po) {
            $product_id = $po["product_id"];
            $ordered_quantity = $po["ordered_quantity"];
            $product = Product::find($po["product_id"]);
            $finalOrder[] = [
                'product_id' => $product_id,
                'ordered_quantity' => $ordered_quantity,
                'total_price' => $ordered_quantity * $product->price,
                'single_price' => $product->price,
                'product' => $product,
            ];
            $total_price += $ordered_quantity * $product->price;
        }
        return view('customer.cart', [
            'customer' => Auth::user()->role(),
            'finalOrder' => $finalOrder,
            'total_price' => $total_price,
        ]);
    }

    /**
     * Handle an incoming store in cart request
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     */
    public function store(Request $request)
    {
        if (!$this->updateQuantity($request)) {
            $session = $request->session();
            $session->push('productsOrder', [
                'product_id' => $request->id,
                'ordered_quantity' => $request->quantity,
            ]);
        }

        return redirect(route('product.id', $request->id));
    }

    /**
     * Buy products
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function buy(Request $request)
    {
        $request->validate([
            'shipping_info' => 'required|int'
        ]);

        $productsOrder = $request->session()->get('productsOrder');
        if (!$productsOrder) {
            return back();
        }

        $customer = Auth::user()->role();
        $order = new Order([]);
        $ship_info = $customer->shippingInfos->where('id', $request->shipping_info)->first();
        if (!$ship_info) {
            return back();
        }
        $order->shipping_info_id = $ship_info->id;
        $order->payment_info_id = $customer->paymentInfo->id;
        $customer->orders()->save($order);

        $products = [];
        $sellers = collect([]);
        foreach ($productsOrder as $po) {
            $product = Product::find($po["product_id"]);
            $ordered_quantity = $po["ordered_quantity"];
            $seller = $product->seller;
            if ($product->quantity - $ordered_quantity < 0) {
                $order->delete();
                return $this->errorQuantity($product->id);
            }
        }

        foreach ($productsOrder as $po) {
            $product = Product::find($po["product_id"]);
            $ordered_quantity = $po["ordered_quantity"];
            $seller = $product->seller;
            if (!$sellers->has($seller->id)) {
                $sellerOrder = new SellerOrder;
                $sellerOrder->status_id = Status::where('name', 'waiting')->first()->id;
                $sellerOrder->seller_id = $seller->id;
                $sellerOrder->order_id = $order->id;
                // $sellerOrder->profit = 0.0;
                $seller->orders()->save($sellerOrder);
                $sellerOrder->save();
                $sellers->put($seller->id, $sellerOrder);
            }
            $product->quantity -= $ordered_quantity;
            $product->save();
            $sellerOrder = $sellers[$seller->id];
            $profit = $product->price * $ordered_quantity;
            $sellerOrder->products()->attach([$products[$product->id] = [
                'ordered_quantity' => $ordered_quantity,
                //'total_price' => $profit,
                'single_price' => $product->price,
                'product_id' => $product->id,
            ]]);
            // $sellerOrder->profit += $profit;
            $sellerOrder->save();
            // $order->price += $sellerOrder->profit();
        }

        $order->save();
        /*
        $order->products()->attach($products);

        $order->price = 0.0;
        foreach ($order->products as $product) {
            $order->price += $product->pivot->total_price;
        }
        $order->save();
        */
        Auth::user()->notify(new NotificationCustomerOrder($order));
        Mail::to(Auth::user()->email)->send(new NewCustomerOrder(Auth::user(), $order));
        foreach ($order->sellerOrders as $sellerOrder) {
            $sellerNotify = User::find($sellerOrder->seller->user->id);
            $sellerNotify->notify(new NotificationSellerOrder($sellerOrder));
            Mail::to($sellerNotify->email)->send(new NewSellerOrder($sellerOrder));
        }
        $request->session()->forget('productsOrder');

        return redirect(RouteServiceProvider::HOME);
    }

    public function update(Request $request)
    {
        return $this->updateQuantity($request, false);
    }

    public function deleteProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|integer',
        ]);

        $session = $request->session();
        if ($session->has('productsOrder')) {
            $index = -1;
            $productsOrder = $session->get('productsOrder');
            foreach ($productsOrder as $i => $po) {
                if ($po["product_id"] === $request->id) {
                    $index = $i;
                    break;
                }
            }
            if ($index !== -1) {
                $session->forget('productsOrder');
                array_splice($productsOrder, $index, 1);
                if (!empty($productsOrder)) {
                    $session->put('productsOrder', $productsOrder);
                }
            }
        }
        return back();
    }
}
