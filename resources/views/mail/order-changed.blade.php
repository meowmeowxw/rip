@component('mail::message')

    {{ $sellerOrder->seller->company }} changed your order status.

    @component('mail::button', ['url' => $url, 'color' => 'success'])
        View Order
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
