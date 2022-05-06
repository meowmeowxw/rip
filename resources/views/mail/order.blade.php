@component('mail::message')
    Thanks for your order {{ $user->name }}

    @component('mail::button', ['url' => $url, 'color' => 'success'])
        View Order
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
