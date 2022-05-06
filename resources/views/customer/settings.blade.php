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
                        {{__('Customer settings')}}
                    </x-slot>
                    <x-form.form action="{{route('customer.settings')}}" btntext="{{ __('Save') }}"
                                 btnaddclass="btn-block"
                                 inputid="type-customer" name="type" inputvalue="customer">
                        <x-FormInput name="credit_card" idAndFor="credit_card" :lblName="__('Credit Card')"
                                     inputValue="{{$customer->credit_card}}" type="text"/>
                        <x-FormInput name="street" idAndFor="street" :lblName="__('Street Address')"
                                     inputValue="{{$customer->street}}" type="text"/>
                        <x-FormInput name="city" idAndFor="city" :lblName="__('City')"
                                     inputValue="{{$customer->city}}" type="text"/>
                    </x-form.form>
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
