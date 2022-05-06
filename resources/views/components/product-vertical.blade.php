<div class="card bg-transparent col border-0 {{$class ?? ''}}">

    <a href="{{route('product.id', $product->id)}}" class="">
        <img class="card-img-top-xl" src="{{$product->path ?? '-'}}" alt="Card Beer {{$product->id+1 ?? '0'}}">

        <div class="card-footer mt-auto text-dark">
            <div class="card-title">
                <strong>{{$product->name ?? '-'}}</strong>
            </div>
            <p class="card-text">sold by
                <strong>{{ \App\Models\Seller::where('id', $product->seller_id)->first()->company }}</strong>
            </p>
            {{--<b>{{ \App\Models\Seller::find($beer->seller_id)->company }}</b>--}}
        </div>
    </a>
</div>

