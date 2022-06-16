@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-7">
                <table class="table">
                    <tr>
                    <tr>
                        <th scope="col"> Description</th>
                        <th scope="col"> Star</th>
                        <th scope="col"> Product Or Seller </th>
                    </tr>
                    </thead>
                    <tbody>
                    <style>
                        .link a:link, a:visited {
                            background-color: #f44336;
                            color: white;
                            padding: 15px 25px;
                            text-align: center;
                            text-decoration: none;
                            display: inline-block;
                        }
                        .link_ a:hover, a:active {
                            background-color: red;
                        }
                    </style>
                    @foreach($reviews as $review)
                        <tr>
                            <th><a class="link" href="{{route('customer.review.id', $review['id'])}}">{{$review["description"]}}</a></th>
                            <th>{{$review["star"]}}</th>
                            @if($review["reviewable_type"] === "App\\Models\\Product")
                                <th><a class="link" href='{{route('product.id', $review["reviewable_id"])}}'>{{$review["reviewable_id"]}}</a></th>
                            @else
                                <th><a class="link" href='{{route('seller.id', $review["reviewable_id"])}}'>{{$review["reviewable_id"]}}</a></th>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
