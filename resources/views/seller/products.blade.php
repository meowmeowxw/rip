{{-- NOT USED ANYMORE --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row row-cols-2 justify-content-center">
            @foreach ($products as $product)
                @if ($product->active)
                    <x-seller-product :path="$product->path"
                                      :title="$product->name" :id="$product->id"
                                      :name="$product->name" :description="$product->description"
                                      :price="$product->price" :quantity="$product->quantity"
                                      :alcohol="$product->alcohol" :cl="$product->cl">
                    </x-seller-product>
                @endif
            @endforeach
            <x-seller-product-new>
            </x-seller-product-new>
        </div>
    </div>
@endsection
