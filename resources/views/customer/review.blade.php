@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-7">
                <x-form.form action="{{ route('customer.update-review') }}" btntext="{{ __('Send Review') }}"
                             btnaddclass="btn-block"
                             inputid="id" inputvalue="{{$review['reviewable_id']}}">
                    <x-FormInput name="description" idAndFor="description" :lblName="__('Description')" type="text"
                                 inputValue="{{$review['description']}}" />
                    <x-FormInput name="star" idAndFor="star" :lblName="__('Star')" type="number" inputValue="{{$review['star']}}"/>
                    @if($review["reviewable_type"] === "App\\Models\\Product")
                    <input type="hidden" id="reviewable_type" name="reviewable_type" value="App\Models\Product">
                    @else
                    <input type="hidden" id="reviewable_type" name="reviewable_type" value="App\Models\Seller">
                    @endif

                </x-form.form>
            </div>
        </div>
    </div>
@endsection
