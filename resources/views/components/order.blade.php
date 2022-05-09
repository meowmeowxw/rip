<div class="card mt-2" id="customer-order.{{$order->id}}">
    <a title="{{__('Order details')}}" href="{{route('customer.order.id', $order->id)}}">
        <div class="card-header d-flex flex-row">
            <div class="mr-auto">{{__('Order ID')}}: <strong>{{$order->id}}</strong></div>
            <!-- <div class="m-auto">{{__('Date')}}: <strong>{{date('d-m-Y', strtotime($order->created_at))}}</strong></div> -->
            <div class="ml-auto">{{__('Total Price')}}:<strong>{{$order->price()}} &euro;</strong></div>
        </div>
    </a>
    <div class="card-body">
        <div class="card-text">
            @foreach ($order->sellerOrders as $i => $sellerOrder)
                <div class="row">
                    <div class="col">
                        <p>{{__('From')}}: <a
                                href="{{route('seller.id', $sellerOrder->seller->id)}}">{{$sellerOrder->seller->company}}</a>
                        </p>
                    </div>
                    <div class="col text-center">
                        <p>
                            {{date('d-m-Y', strtotime($order->created_at))}}
                        </p>
                    </div>
                    <div class="col text-right">
                        <p class="h5">
                            <x-status :status="$sellerOrder->status->name"></x-status>
                        </p>
                    </div>
                </div>

                <div class="container-fluid border">
                    @foreach($sellerOrder->products as $beer)
                        <div class="row mt-2">
                            <div class="col-4">
                                <a href="{{route('product.id', $beer->id)}}"><img src="{{$beer->path}}"
                                                                                  class="card-img-top"
                                                                                  alt="{{$beer->name}}"/></a>
                            </div>
                            <div class="col align-self-center">
                                <x-product :product=$beer></x-product>
                            </div>
                        </div>
                    @endforeach
                    <div class="row mt-2">
                    </div>
                </div>
                @if ($i !== $order->sellerOrders->count() - 1)
                <div class="row mt-4">
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
