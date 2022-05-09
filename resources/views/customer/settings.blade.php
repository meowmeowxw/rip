@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <x-card>
                    <x-slot name="title">
                        {{__('User settings')}}
                    </x-slot>
                    <x-form.form action="{{route('customer.settings')}}" btntext="{{ __('Save') }}"
                                 btnaddclass="btn-block"
                                 inputid="type-user" name="type" inputvalue="user">
                        <x-FormInput name="name" idAndFor="name" :lblName="__('Name')"
                                     inputValue="{{Auth::user()->name}}" type="text"/>
                        <x-FormInput name="email" idAndFor="email" :lblName="__('Email')"
                                     inputValue="{{Auth::user()->email}}" type="text"/>
                    </x-form.form>
                </x-card>
                <x-card>
                    <x-slot name="title">
                        {{__('Payment Info')}}
                    </x-slot>
                    <x-form.form action="{{route('customer.settings')}}" btntext="{{ __('Save') }}"
                                 btnaddclass="btn-block"
                                 inputid="payment-info" name="type" inputvalue="payment-info">
                        <x-FormInput name="card_number" idAndFor="card_number" :lblName="__('Credit Card Number')"
                                     inputValue="{{$customer->paymentInfo->card_number}}" type="text"/>
                        <x-FormInput name="expire" idAndFor="expire" :lblName="__('Expire Date')"
                                     inputValue="{{$customer->paymentInfo->expire}}" type="date"/>
                    </x-form.form>
                </x-card>
                <x-card>
                    @foreach($customer->shippingInfos as $shippingInfo)
                        <x-slot name="title">
                            {{__('Shipping Info')}}
                        </x-slot>
                        <x-form.form action="{{route('customer.settings')}}" btntext="{{ __('Save') }}"
                                     btnaddclass="btn-block"
                                     inputid="type-shipping" name="type" inputvalue="shipping-info">
                            <x-FormInput name="street" idAndFor="street" :lblName="__('Street')"
                                         inputValue="{{$shippingInfo->street ?? ''}}" type="text"/>
                            <x-FormInput name="city" idAndFor="city" :lblName="__('City')"
                                         inputValue="{{$shippingInfo->city ?? ''}}" type="text"/>
                            <x-FormInput name="cap" idAndFor="cap" :lblName="__('CAP')"
                                         inputValue="{{$shippingInfo->cap ?? ''}}" type="text"/>
                            <input id="{{'id'.$shippingInfo->id}}" value="{{$shippingInfo->id}}"
                                   name="id"
                                   type="hidden">
                        </x-form.form>
                    @endforeach
                </x-card>
                <x-card>
                    <x-slot name="title">
                        {{__('Change password')}}
                    </x-slot>
                    <x-form.form action="{{route('password.change')}}" btntext="{{ __('Save') }}"
                                 btnaddclass="btn-block">
                        <x-FormInput name="password" idAndFor="password" :lblName="__('Old Password')" type="password"/>
                        <x-FormInput name="new_password" idAndFor="new_password" :lblName="__('New Password')"
                                     type="password"/>
                        <x-FormInput name="new_password_confirmation" idAndFor="new_password_confirmation"
                                     :lblName="__('Confirm New Password')" type="password"/>
                    </x-form.form>
                </x-card>
            </div>
        </div>
    </div>
@endsection
