@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-6">
                <x-card>
                    <x-slot name="title">
                        {{ __('Login') }}
                    </x-slot>
                    <x-form.form action="{{ route('login') }}" btntext="{{ __('Login') }}" btnaddclass="btn-block">
                        <x-FormInput name="email" idAndFor="email" :lblName="__('E-mail Address')" type="email" />
                        <x-FormInput name="password" idAndFor="password" :lblName="__('Password')" type="password" />
                    </x-form.form>
                </x-card>
            </div>
        </div>
    </div>
@endsection
