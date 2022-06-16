@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/product.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('js/btn-product.js') }}" defer></script>
    @if ($errors->any())
        @if (Auth::user()->is_seller())
            <script>
                window.addEventListener('load', function () {
                    $('#modalEdit').modal('toggle');
                });
            </script>
        @endif
    @endif

@endsection

@section('content')
    {{--
    <li>{{$product->name}}</li>
    <li>{{$seller->company}}</li>
    <li>{{$category->name}}</li>
    --}}
    <div class="container pt-3">
        <div class="col-12 col-md-12 col-xl-9 mx-auto">
            <div id="name-product" class="my-3 page-header">
                <p class="h1 text-break text-center">
                    <strong>
                        {{$product->name}}
                    </strong>
                </p>
            </div>
            <div class="my-3 text-center">
                <p class="h3 border-bottom">
                    <a class="text-dark"
                       href="{{route('seller.id', $seller->id)}}"> {{__('Company:')}} {{$seller->company}}</a>
                </p>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-md-5 ">
                    <div class="product-img">
                        <img src="{{$product->path}}" class="" alt="Beer {{$product->id ?? '0'}}"/>
                    </div>
                </div>

                <div class="col-12 col-md-7">
                    <div class="col-12">
                        <div class="row justify-content-center m-1">
                            <p class="h4">
                                {{$product->price}} €
                            </p>
                        </div>
                        <div class="row justify-content-center m-1">
                            <p class="h4">
                                @if($product->isAvailable())
                                    ( {{$product->quantity}} {{__('in stock')}} )
                                @else
                                    ({{__('Not in stock')}})
                                @endif
                            </p>
                        </div>

                        <div class="row justify-content-center mt-1">
                            <div class="col-12">
                                <table id="details" class="table table-striped text-center ">
                                    <caption class="h4 mb-0 pb-0">{{__('Details')}}:</caption>
                                    <tr>
                                        <th>{{__('Category')}}</th>
                                        <td>
                                            <a href="{{route('category.id', $category->id)}}" class="link">
                                                {{$category->name}}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Format')}}</th>
                                        <td>{{$product->cl}} cl</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Alcohol')}}</th>
                                        <td>{{$product->alcohol}} %</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="col-12 my-3">

                        @guest
                            <p class="text-danger "><a href="{{route('login')}}"
                                                       class="link">{{__('Login needed to buy')}}</a></p>
                        @else
                            @if (!Auth::user()->is_seller())
                                <form id="add_to_cart" action="{{route('customer.cart')}}" method="POST"
                                      class="form-inline justify-content-center">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-12 col-md-5 mb-0">

                                            <label for="quantityCart"
                                                   class="sr-only visually-hidden">{{__('Quantity')}}</label>
                                            <input id="quantityCart" placeholder="{{__('Quantity')}}"
                                                   type="number"
                                                   class="form-control w-100 @error('quantity') is-invalid @enderror"
                                                   required="" name="quantity" value="1" min="1">
                                            @error('quantity')
                                            <span class="small invalid-feedback"
                                                  role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="form-group btn-group col-12 col-md-7">
                                            <button id="btn-minus" type="button" class=" btn btn-danger">
                                                -
                                            </button>
                                            <button id="btn-plus" type="button" class="btn btn-info">
                                                +
                                            </button>
                                            <button type="submit" class="btn btn-primary ">
                                                {{__('Add to cart')}}
                                            </button>
                                        </div>


                                        <input id="id" value="{{$product->id}}" name="id" type="hidden">
                                    </div>
                                </form>
                            @else
                                @can('edit-product', $product)
                                    <div class="row">
                                        <!-- Button trigger modal -->
                                        <div class="col">
                                            <button id="modal-edit" type="button" class="btn btn-primary"
                                                    data-toggle="modal"
                                                    data-target="#modalEdit">
                                                {{__('Edit')}}
                                            </button>
                                        </div>
                                        <div class="col text-right">
                                            <button id="modal-delete" type="button" class="btn btn-primary"
                                                    data-toggle="modal"
                                                    data-target="#modalDelete">
                                                {{__('Delete')}}
                                            </button>
                                        </div>
                                    </div>
                                @endcan
                            @endif
                        @endguest
                    </div>
                </div>
            </div>

            <div class="col-12 jumbotron p-3">
                <h4 class="border-bottom text-center">
                    {{__('Description')}}:
                </h4>
                <p class="text-break ">{{$product->description}}</p>
            </div>

        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete-product">{{__('Delete Product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form id="delete" method="POST" action="{{route('seller.product.delete')}}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            {{ __('Delete') }}
                        </button>
                        <input id="product_id_delete" value="{{$product->id}}" name="id" type="hidden">
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-product">{{__('Edit Product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit" method="POST" action="{{route('seller.product.edit')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div id="div-name" class="col">
                                <label for="name">{{__('Name')}}</label>
                                <input id="name" placeholder="{{__('Name')}}" type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       required="" name="name" value="{{$product->name}}">

                                @error('name')
                                <span class="invalid-feedback"
                                      role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div id="div-price" class="col">
                                <label for="price">{{__('Price')}}</label>
                                <input id="price" placeholder="{{__('Price')}}" type="number"
                                       step="0.01" required="" name="price" value="{{$product->price}}"
                                       class="form-control @error('price') is-invalid @enderror">

                                @error('price')
                                <span class="invalid-feedback"
                                      role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div id="div-quantity" class="col">
                                <label for="quantity">{{__('Quantity')}}</label>
                                <input id="quantity" placeholder="{{__('Quantity')}}" type="number"
                                       step="1" required="" name="quantity" value="{{$product->quantity}}"
                                       class="form-control @error('quantity') is-invalid @enderror">

                                @error('quantity')
                                <span class="invalid-feedback"
                                      role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div id="div-alcohol" class="col">
                                <label for="alcohol">{{__('Alcohol')}}</label>
                                <input id="alcohol" placeholder="{{__('Alcohol')}}" type="number"
                                       step="0.01" required="" name="alcohol" value="{{$product->alcohol}}"
                                       class="form-control @error('alcohol') is-invalid @enderror">

                                @error('alcohol')
                                <span class="invalid-feedback"
                                      role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div id="div-cl" class="col">
                                <label for="cl">{{__('Cl')}}</label>
                                <input id="cl" placeholder="{{__('Cl')}}" type="number"
                                       step="1" required="" name="cl" value="{{$product->cl}}"
                                       class="form-control @error('cl') is-invalid @enderror">

                                @error('cl')
                                <span class="invalid-feedback"
                                      role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div id="div-description" class="col">
                                <label for="description">{{__('Description')}}</label>
                                <textarea id="description" placeholder="{{__('Description')}}" type="text"
                                          class="form-control @error('description') is-invalid @enderror"
                                          required="" name="description" rows="5">{{$product->description}}</textarea>

                                @error('description')
                                <span class="invalid-feedback"
                                      role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            {{__('Save')}}
                        </button>
                        <input id="product_id_edit" value="{{$product->id}}" name="id" type="hidden">
                    </div>
                </form>
            </div>
        </div>
    </div>


   @if($can_review)
    <x-form.form action="{{ route('product.set-review') }}" btntext="{{ __('Send Review') }}"
                 btnaddclass="btn-block"
                 inputid="product_id" inputvalue="{{$product->id}}">
        <x-FormInput name="description" idAndFor="description" :lblName="__('Description')" type="text"
                     inputValue="{{old('description')}}" />
        <x-FormInput name="star" idAndFor="start" :lblName="__('Star')" type="number"/>
    </x-form.form>
   @endif

    <div class="row justify-content-center">
    <div class="col text-center">
        <h4 class="display-4 text-center">
            Reviews
        </h4>
    <table class="table">
        <tr>
        <tr>
            <th scope="col"> Description</th>
            <th scope="col"> Star</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reviews as $review)
            <tr>
                <th>{{$review["description"]}}</th>
                <th>{{$review["star"]}}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    </div>

@endsection
