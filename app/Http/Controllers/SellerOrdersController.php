<?php


namespace App\Http\Controllers;

use App\Mail\ChangeOrderStatus;
use App\Models\Status;
use App\Models\SellerOrder;
use App\Notifications\NotificationChangeOrderStatus;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class SellerOrdersController extends Controller
{

    public function __construct()
    {
        $this->middleware([
            'auth',
            'seller'
        ]);
    }

    /**
     * Display all the ordes view.
     *
     * @return View
     */
    public function create()
    {
        $seller = Auth::user()->seller;
        $sellerOrders = $seller->orders()
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $totalProfit = $seller->orders()
            ->sum('profit');

        return view('seller.orders', [
            'seller' => $seller,
            'sellerOrders' => $sellerOrders,
            'totalProfit' => $totalProfit,
        ]);
    }

    /**
     * Display order id view.
     *
     * @return View;
     */
    public function show($id)
    {
        $sellerOrder = SellerOrder::find($id);
        if (!Gate::allows('seller-order', $sellerOrder)) {
            abort(403);
        }

        return view('seller.order', [
            'sellerOrder' => $sellerOrder,
            'allStatus' => Status::all(),
            'currentStatus' => $sellerOrder->status,
        ]);
    }

    /**
     * Update order status
     *
     * @return View
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|integer',
            'status' => 'required|string',
        ]);

        $sellerOrder = SellerOrder::find($request->id);
        if (!Gate::allows('seller-order', $sellerOrder)) {
            abort(403);
        }

        $newStatus = Status::where('name', $request->status)->first();
        if (!$newStatus) {
            back();
        }

        $sellerOrder->status_id = $newStatus->id;
        $sellerOrder->save();
        $customerUser = $sellerOrder->order->customer->user;
        $customerUser->notify(new NotificationChangeOrderStatus($sellerOrder));
        Mail::to($customerUser->email)->send(new ChangeOrderStatus($sellerOrder));
        return back();
    }

}
