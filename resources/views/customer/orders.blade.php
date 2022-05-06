@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-7">
                @isset($orders)
                    @foreach ($orders as $order)
                        <x-order :order="$order"/>
                    @endforeach
                @else
                    <div class="alert alert-warning text-center" role="alert">
                        <p class="h5">{{__('No Order')}}</p>
                    </div>
                @endisset
            </div>
        </div>
        @isset($orders)
            <x-paginator>
                {!! $orders->links() !!}
            </x-paginator>
        @endisset
    </div>
@endsection
