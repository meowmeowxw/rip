@extends('layouts.app')
@section('styles')
@endsection
@section('content')
    <div class="container py-2" id="dashboard">
        <div class="row justify-content-center">
            <div class="col text-center">
                <div class="pb-2 my-2 page-header border-bottom">
                    <h3 class="font-weight-bold">{{__('The latest beers')}}</h3>
                </div>

                <div class="d-flex flex-row p-2 ">
                    <x-product-vertical :product=$latest[0] class="d-block"/>
                    <x-product-vertical :product=$latest[1] class="d-none d-md-block"/>
                    <x-product-vertical :product=$latest[2] class="d-none d-lg-block"/>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row justify-content-center">
            <div id="all" class="text-center">
                <p class="h3 font-weight-bold">{{__('All Beers')}}</p>
                <small>{{__('or select a category')}}</small>
                <div id="categories" class="d-flex flex-row justify-content-center m-1">
                    @foreach($categories as $category)
                        <div class="btn-group">
                            <a class="btn-lg btn-success m-1"
                               href="{{route('category.id', ['id' => $category->id])}}">  {{ $category->name }}  </a>
                        </div>
                    @endforeach

                    {{--
                    <nav class="nav nav-pills nav-justified bg-dark rounded shadow-sm">
                        @foreach($categories as $category)
                            @if($loop->first)
                                <a class="nav-link selectcategory active" href="#">{{__('All')}}</a>
                            @endif
                            <a class="nav-link selectcategory" href="#">{{$category->name}}</a>
                        @endforeach
                    </nav>
                    --}}
                </div>

                <div id="products" class="container mt-2">
                    <div class="row justify-content-center">

                        {{--
                        <a href="{{route('category.id', ['id' => $category->id])}}" class="text-dark">
                            <h4 class="d-inline text-uppercase bg-warning">
                                -<strong>{{$category->name}}</strong>-
                            </h4>
                        </a>
                        --}}

                        @foreach($products as $product)
                            <x-product-square :product=$product/>
                        @endforeach

                    </div>
                </div>

                <div id="pagination" class="d-inline-block mt-3">
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

{{--

<div id="myBtnContainer">
  <button class="btn active" onclick="filterSelection('all')"> Show all</button>
  <button class="btn" onclick="filterSelection('cars')"> Cars</button>
  <button class="btn" onclick="filterSelection('animals')"> Animals</button>
  <button class="btn" onclick="filterSelection('fruits')"> Fruits</button>
  <button class="btn" onclick="filterSelection('colors')"> Colors</button>
</div>

<div class="container">
  <div class="filterDiv cars">BMW</div>
  <div class="filterDiv colors fruits">Orange</div>
  <div class="filterDiv cars">Volvo</div>
  <div class="filterDiv colors">Red</div>
</div>

<script>
filterSelection("all")
function filterSelection(c) {
  var x, i;
  x = document.getElementsByClassName("filterDiv");
  if (c == "all") c = "";
  for (i = 0; i < x.length; i++) {
    w3RemoveClass(x[i], "show");
    if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
  }
}

function w3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function w3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);
    }
  }
  element.className = arr1.join(" ");
}

// Add active class to the current button (highlight it)
var btnContainer = document.getElementById("myBtnContainer");
var btns = btnContainer.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function(){
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}
</script>

--}}
