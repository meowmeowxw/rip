@extends('layouts.app')

@section('content')
    <div class="container py-2">
        <div class="row justify-content-center">
            <div class="col text-center">
                <div class="jumbotron">
                    <h3 class="display-4 text-center text-uppercase border-bottom">{{$seller->company}}</h3>
                    <p class="lead">
                    </p>
                </div>
                <div class="row row-cols-md-2 justify-content-center">
                    @foreach($products as $product)
                        <x-product-square :product=$product/>
                    @endforeach
                </div>
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
                @if($can_review)
                    <x-form.form action="{{ route('customer.update-review') }}" btntext="{{ __('Send Review') }}"
                                 btnaddclass="btn-block"
                                 inputid="id" inputvalue="{{$seller->id}}">
                        <x-FormInput name="description" idAndFor="description" :lblName="__('Description')" type="text"
                                     inputValue="{{old('description')}}" />
                        <x-FormInput name="star" idAndFor="star" :lblName="__('Star')" type="number"/>
                        <input type="hidden" id="reviewable_type" name="reviewable_type" value="App\Models\Seller">
                    </x-form.form>
                @endif
                <x-paginator>
                    {!! $products->links() !!}
                </x-paginator>
            </div>
        </div>
    </div>
@endsection
