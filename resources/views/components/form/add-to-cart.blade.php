<x-form.form id="add_to_cart" action="{{route('customer.cart')}}"
             btntext="{{__('Add to cart')}}" btnaddclass="btn-lg btn-block"
             inputid="id" inputvalue="{{$product->id}}">


    <x-FormInput name="quantity" idAndFor="quantityNew" inputValue="1" min="1"
                 :lblName="__('Quantity')" type="number"/>

    <div class="row row-cols-3 justify-content-center m-1">
        <button id="btn-minus" type="button" class="col btn btn-danger " >
            -
        </button>
        <button id="btn-plus" type="button" class="col btn btn-info">
            +
        </button>
    </div>

</x-form.form>
