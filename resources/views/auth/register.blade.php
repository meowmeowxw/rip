@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-6">
                <x-card>
                    <x-slot name="title">
                        {{ __('Register') }}
                    </x-slot>
                    <x-form.form action="{{ route('register') }}" btntext="{{ __('Register') }}"
                                 btnaddclass="btn-block">
                        <x-FormInput name="name" idAndFor="name" :lblName="__('Name')" type="text"
                        inputValue="{{old('name')}}" />
                        <x-FormInput name="email" idAndFor="email" :lblName="__('E-mail Address')" type="email"/>
                        <x-FormInput name="password" idAndFor="password" :lblName="__('Password')" type="password"/>
                        <label for="password-confirm"
                               class="">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control mb-2"
                               name="password_confirmation" required autocomplete="new-password"
                               placeholder="{{__('Confirm Password')}}">
                        <label for=credit_card" class="mb-0">{{__('Credit Card')}}</label>
                        <input id="credit_card" placeholder="{{__('Credit Card')}}" type="text"
                               class="form-control mb-2 @error('credit_card') is-invalid @enderror"
                               name="credit_card" value="{{old('credit_card')}}">
                        @error('credit_card')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <label for=street" class="mb-0">{{__('Street')}}</label>
                        <input id="street" placeholder="{{__('Street')}}" type="text"
                               class="form-control mb-2 @error('street') is-invalid @enderror"
                               name="street" value="{{old('street')}}">
                        @error('street')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <label for=city" class="mb-0">{{__('City')}}</label>
                        <input id="city" placeholder="{{__('City')}}" type="text"
                               class="form-control mb-2 @error('city') is-invalid @enderror"
                               name="city" value="{{old('city')}}">
                        @error('city')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </x-form.form>
                </x-card>
            </div>
        </div>
    </div>
@endsection
