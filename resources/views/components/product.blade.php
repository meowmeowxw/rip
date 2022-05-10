<div class="row">
    <div class="d-flex col justify-content-start">
        <p class="text-break">
            <a href="{{route('product.id', $product->id)}}"><strong>{{ $product->name }}</strong></a>
        </p>
    </div>
    <div class="d-none d-md-block col">
            {{ $product->pivot->ordered_quantity }} x {{ $product->pivot->single_price }} =
            {{ $product->pivot->ordered_quantity * $product->pivot->single_price }} &euro;
    </div>
</div>
<div class="row">
    <div class="d-md-none col">
        {{ $product->pivot->ordered_quantity }} x {{ $product->pivot->single_price }} =
        {{ $product->pivot->ordered_quantity * $product->pivot->single_price }} &euro;
        {{--<a title="{{__('View details of product ')}}{{$product->id}}" href="#"> > </a> --}}
    </div>
</div>
