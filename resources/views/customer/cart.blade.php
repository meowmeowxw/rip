@extends('layouts.app')

@section('styles')
    <style>
        input[type=number] {
            width: 90px;
            padding: 5px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        const proceed = ["{{__('Proceed')}}", "^"];
        let i = 0;

        function computePrice(id, data) {
            if (data.hasOwnProperty('new_price')) {
                $(`#quantity${id}`).attr("class", "");
                $(`#error${id}`).hide();
                $(`#total-price${id}`).html("{{__('Total')}}: " + data.new_price.toFixed(2) + "&euro;");
                let tot = parseFloat($('#total-price').text());
                tot -= data.old_price;
                tot += data.new_price;
                $('#total-price').text(tot.toFixed(2));
            } else {
                $(`#quantity${id}`).attr("class", "form-control mb-2 is-invalid");
                $(`#error${id}`).html("<strong>" + data.error + "</strong>");
                $(`#error${id}`).show();
            }
        }

        window.addEventListener('load', function () {
            let selector = [];
            @isset($finalOrder)
            @php
                $selectors = [];
                foreach ($finalOrder as $fo) {
                    $product = $fo["product"];
                    $selectors[] = $product->id;
                }
            @endphp
            $("#proceed").click(function () {
                i = (i + 1) % 2;
                $(this).text(proceed[i]);
            });
            @foreach ($selectors as $selector)
            $("{{'#error'.$selector}}").hide();
            $("{{'#quantity'.$selector}}").on("change keyup", function () {
                let val = parseInt($(this)[0].value);
                if (val && val >= 1) {
                    $.ajax({
                        url: `${baseUrl}customer/cart/update`,
                        type: "POST",
                        data: {"id": {{$selector}}, "quantity": val},
                        success: function (data) {
                            if (data !== '') {
                                computePrice({{$selector}}, data);
                            }
                        }
                    })
                }
            });
            @endforeach
            @endisset
        })
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @isset($finalOrder)
                    <div class="card mt-3" id="customer-cart">
                        <div class="card-header">
                            {{__('Total price')}}: <label id="total-price">{{ $total_price }}</label>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                @foreach ($finalOrder as $fo)
                                    @php
                                        $product = $fo["product"];
                                    @endphp
                                    <div class="container border">
                                        <div class="row mt-2 mb-2">
                                            <div class="col-3">
                                                <a href="{{route('product.id', $product->id)}}"><img
                                                        src="{{$product->path}}"
                                                        class="card-img-top"
                                                        alt="{{$product->name}}"/></a>
                                            </div>
                                            <div class="col col-4 align-self-center">
                                                <div class="row">
                                                    <a title="{{'Product detail'}}" class="text-break"
                                                       href="{{route('product.id', $product->id)}}"><strong>{{ $product->name }}</strong></a>
                                                </div>
                                                <div class="row">
                                                    <form id="{{'delete'.$product->id}}"
                                                          action="{{route('customer.cart.delete-product')}}"
                                                          method="POST">
                                                        @csrf
                                                        <input id="{{'product'.$product->id}}" value="{{$product->id}}"
                                                               name="id"
                                                               type="hidden">
                                                    </form>
                                                    <a href="#"
                                                       onclick="document.getElementById('{{"delete".$product->id}}').submit();">{{__('Delete')}}</a>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex row justify-content-center mb-2">
                                                    <input id="{{'product'.$product->id}}" value="{{$product->id}}"
                                                           name="id"
                                                           type="hidden">
                                                    <input id="{{'quantity'.$product->id}}" type="number" min="1"
                                                           name="quantity"
                                                           class="@error('quantity'.$product->id) form-control is-invalid @enderror"
                                                           value="{{$fo["ordered_quantity"]}}"/>
                                                    <span id="{{'error'.$product->id}}" class="invalid-feedback"
                                                          role="alert">
                                                        @error('quantity'.$product->id)
                                                            <strong>{{$message}}</strong>
                                                        @enderror
                                                    </span>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <label id="{{'single-price'.$product->id}}">
                                                        {{__('Price')}}: {{ $fo["single_price"] }} &euro;
                                                    </label>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <label id="{{'total-price'.$product->id}}">
                                                        {{__('Total')}}: {{ $fo["total_price"] }} &euro;
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                                <div class="row mt-4">
                                    <div class="col">
                                        <button class="btn btn-primary btn-block" type="button" data-toggle="collapse"
                                                data-target="#collapse" aria-expanded="false"
                                                id="proceed"
                                                aria-controls="collapseButton">
                                            {{__('Proceed')}}
                                        </button>
                                    </div>
                                </div>
                                <div class="collapse" id="collapse">
                                    <div class="row mt-4">
                                        <div class="col">
                                            <x-form.form action="{{route('customer.cart.buy')}}"
                                                         btntext="{{ __('Buy') }}"
                                                         btnaddclass="btn-block">
                                                <x-FormInput name="credit_card" idAndFor="credit_card"
                                                             :lblName="__('Credit Card')"
                                                             inputValue="{{Auth::user()->customer->credit_card}}"
                                                             type="text"/>
                                                <x-FormInput name="street" idAndFor="street"
                                                             :lblName="__('Street Address')"
                                                             inputValue="{{Auth::user()->customer->street}}"
                                                             type="text"/>
                                                <x-FormInput name="city" idAndFor="city" :lblName="__('City')"
                                                             inputValue="{{Auth::user()->customer->city}}" type="text"/>
                                            </x-form.form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            @else
                <div class="alert alert-warning text-center" role="alert">
                    <p class="h5">{{__('The cart is empty')}}</p>
                </div>
            @endisset
        </div>
    </div>
    </div>
@endsection

