@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header text-center">
            <h3>{{__('Total Profit')}}: {{$totalProfit}} &euro;</h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-7">
                @foreach ($sellerOrders as $sellerOrder)
                    <div class="card mt-3" id="customer-order.{{$sellerOrder->order}}">
                        <a titlte="{{__('Order details')}}" href="{{route('seller.order.id', $sellerOrder->id)}}">
                            <div class="card-header d-flex flex-row">
                                <div class="mr-auto">{{__('Order ID')}}: <strong>{{$sellerOrder->id}}</strong></div>
                                <div class="ml-auto">{{__('Profit')}}: <strong>{{$sellerOrder->profit}} &euro;</strong></div>
                        </div>
                        </a>
                        <div class="card-body">
                            <div class="card-text">
                                @foreach ($sellerOrder->products as $product)
                                    <div class="row mt-2">
                                        <div class="col-4">
                                            <a href="{{route('product.id', $product->id)}}"><img src="{{$product->path}}"
                                                                                              class="card-img-top"
                                                                                              alt="{{$product->name}}"/></a>
                                        </div>
                                        <div class="col align-self-center">
                                            <x-product :product=$product></x-product>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer text-muted text-center">
                            <h5>{{__('Current status')}}:
                                <x-status :status="$sellerOrder->status->name"></x-status>
                            </h5>
                            <a class="btn btn-primary" href="{{route('seller.order.id', $sellerOrder->id)}}">{{__('Details')}}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <x-paginator>
            {!! $sellerOrders->links() !!}
        </x-paginator>
@endsection
