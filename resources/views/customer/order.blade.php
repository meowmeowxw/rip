@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-md-8 col-xl-7">
                <x-order :order="$order"/>
            </div>
        </div>
    </div>
@endsection
