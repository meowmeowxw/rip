@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-6">
                <x-card>
                    <x-slot name="title">
                        {{ __('Register Seller') }}
                    </x-slot>
                    <x-form.form method="POST" action="{{route('seller.register')}}" btntext="{{__('Register')}}"
                                 btnaddclass="btn-block">
                        <x-FormInput name="name" idAndFor="name" :lblName="__('Name')" type="text"
                                     inputValue="{{old('name')}}"/>
                        <x-FormInput name="email" idAndFor="email" :lblName="__('E-mail Address')" type="email"/>
                        <x-FormInput name="password" idAndFor="password" :lblName="__('Password')" type="password"/>
                        <label for="password-confirm"
                               class="">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control mb-2"
                               name="password_confirmation" required autocomplete="new-password"
                               placeholder="{{__('Confirm Password')}}">
                        <x-formInput name="company" idAndFor="company" :lblName="__('Company Name')" type="text"
                                     inputValue="{{old('company')}}"/>
                        <x-formInput name="description" idAndFor="description" :lblName="__('Company Description')" type="text"
                                     inputValue="{{old('description')}}"/>
                    </x-form.form>
                </x-card>
            </div>
        </div>
    </div>
@endsection
