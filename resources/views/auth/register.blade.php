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
                        <label for=card_number" class="mb-0">{{__('Credit Card Number')}}</label>
                        <input id="card_number" placeholder="{{__('Credit Card')}}" type="text"
                               class="form-control mb-2 @error('card_number') is-invalid @enderror"
                               name="card_number" value="{{old('card_number')}}">
                        @error('card_number')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <label for=expire" class="mb-0">{{__('Credit Card Expire Date')}}</label>
                        <input id="expire" placeholder="{{__('Credit Card Expire Date')}}" type="date"
                               class="form-control mb-2 @error('expire') is-invalid @enderror"
                               name="expire" value="{{old('expire')}}">
                        @error('expire')
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
                        <label for=cap" class="mb-0">{{__('CAP')}}</label>
                        <input id="cap" placeholder="{{__('CAP')}}" type="text"
                               class="form-control mb-2 @error('cap') is-invalid @enderror"
                               name="cap" value="{{old('cap')}}">
                        @error('cap')
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
