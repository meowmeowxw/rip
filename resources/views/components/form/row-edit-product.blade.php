<div class="row justify-content-center align-items-center flex-grow-1">

    <button class="btn btn-primary m-1" type="button" data-toggle="collapse"
            data-target="#collapse{{$product->id ?? ''}}"
            aria-expanded="false" aria-controls="collapseButton">
        {{__('Edit')}}
    </button>
    <x-form.form id="delete" action="{{route('seller.product.delete')}}"
                 btntext="{{ __('Delete') }}"
                 inputid="product_id_delete" inputvalue="{{$product->id}}"
                 btnaddclass="m-1" ></x-form.form>
</div>
<div class="collapse" id="collapse{{$product->id ?? ''}}">
    <div class="card card-body justify-content-center m-1">
        <x-form.form action="{{route('product.id', ['id' => $product->id])}}"
                     btntext="{{ __('Save') }}"
                     inputid="product_id" inputvalue="{{$product->id}}">

            <x-FormInput name="name" idAndFor="name{{$product->id}}" :lblName="__('Name')"
                         :inputValue="$product->name"
                         type="text" errormessage="try" errorname="tt" ></x-FormInput>
            <x-FormInput name="description" idAndFor="description{{$product->id}}"
                         :lblName="__('Description')"
                         :inputValue="$product->description" type="text" ></x-FormInput>
            <x-FormInput name="price" idAndFor="price{{$product->id}}" :lblName="__('Price')"
                         :inputValue="$product->price"
                         type="number" step="0.01" ></x-FormInput>
            <x-FormInput name="quantity" idAndFor="quantity{{$product->id}}"
                         :lblName="__('Quantity')"
                         :inputValue="$product->quantity" type="number" ></x-FormInput>
        </x-form.form>
    </div>
</div>
