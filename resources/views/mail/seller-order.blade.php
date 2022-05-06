@component('mail::message')
    You have just received an order!

    @component('mail::button', ['url' => $url, 'color' => 'success'])
        View Order
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
