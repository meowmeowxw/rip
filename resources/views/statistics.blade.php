@extends('layouts.app')

@section('content')
    <div class="container py-2">
        <div class="row justify-content-center">
            <div class="col text-center">
                <div class="jumbotron py-4">
                    <h3 class="display-4 text-center text-uppercase border-bottom">Statistics</h3>
                    <p class="lead">
                    </p>
                </div>
                <h5 class="display-5 text-center">
                    Customers Who Received More Orders
                </h5>
                <div class="row row-cols-md-2 justify-content-center" id="customerswhoreceivedmore">
                </div>
                <br>
                <h5 class="display-5 text-center">
                    Sellers Who Sold More Beers
                </h5>
                <div class="row row-cols-md-2 justify-content-center" id="sellerswhosoldmore">
                </div>
                <br>
                <h5 class="display-5 text-center">
                    Customers Who Purchased More
                </h5>
                <div class="row row-cols-md-2 justify-content-center" id="customerswhopurchasedmore">
                </div>
                <br>
                <h5 class="display-5 text-center">
                    Most Selled Beers
                </h5>
                <div class="row row-cols-md-2 justify-content-center" id="mostselledbeers">
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="{{ asset('js/json-to-table.js') }}" defer></script>
<script defer>
    fetch("{{route('statistics.customerswhoreceivedmore')}}")
        .then(response => response.json())
        .then(data => {
            let text = json_to_table(data);
            document.getElementById("customerswhoreceivedmore").innerHTML = text;
        });
    fetch("{{route('statistics.sellerswhosoldmore')}}")
        .then(response => response.json())
        .then(data => {
            let text = json_to_table(data);
            document.getElementById("sellerswhosoldmore").innerHTML = text;
        });
    fetch("{{route('statistics.customerswhopurchasedmore')}}")
        .then(response => response.json())
        .then(data => {
            let text = json_to_table(data);
            document.getElementById("customerswhopurchasedmore").innerHTML = text;
        });
    fetch("{{route('statistics.mostselledbeers')}}")
        .then(response => response.json())
        .then(data => {
            let text = json_to_table(data);
            document.getElementById("mostselledbeers").innerHTML = text;
        });
</script>

