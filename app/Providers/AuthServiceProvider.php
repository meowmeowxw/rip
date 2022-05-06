<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\SellerOrder;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Product;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('seller', function(User $user) {
            return $user->is_seller;
        });

        Gate::define('edit-product', function (User $user, Product $product) {
            return $user->seller->id === $product->seller_id;
        });

        Gate::define('seller-order', function (User $user, SellerOrder $sellerOrder) {
            return $user->seller->id === $sellerOrder->seller->id;
        });

        Gate::define('customer-order', function (User $user, Order $order) {
            $customer = $order->customer;
            if ($customer) {
                return $user->id === $customer->user->id;
            }
            return false;
        });
    }
}
