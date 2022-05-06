<div class="col-sm-6 col-md-4 services-box hoverServices ">
    <a href="{{route('product.id', ['id' => $product->id])}}" class="text-dark">
        <p class="h4 text-center">{{ $product->name }}</p>

        <div class="service-icon">
            <img src="{{$product->path ?? '-'}}"
                 alt="Card Beer {{$product->id+1 ?? '0'}}">
        </div>
        <div class="">
            <div class="col justify-content-center">
                <div class="row">
                    @if ($product->isAvailable())
                        <div class="col-3">
                            <p class="font-weight-bold ">
                                {{ $product->cl }} cl
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold ">
                                {{ $product->alcohol }} % {{__('alcohol')}}
                            </p>
                        </div>
                        <div class="col-3">
                            <p class="font-weight-bold ">
                                {{ $product->price }} &euro;
                            </p>
                        </div>
                    @else
                        <div class="col">
                            <p class="font-weight-bold ">
                                {{__('Not Available')}}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </a>
</div>
