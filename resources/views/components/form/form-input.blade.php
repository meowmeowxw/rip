<x-form.form-div>
    <label for="{{$idAndFor}}" class="mb-0">{{$lblName}}</label>
    <input id="{{$idAndFor}}" placeholder="{{$lblName}}" type="{{$type}}"
           class="form-control mb-2 @error($name) is-invalid @enderror"
          {{--
          {{$attributes->merge(['class' => 'form-control mb-2']) }}
          --}}
           required="" name="{{$name}}" value="{{$inputValue ?? ''}}" {{$attributes  ?? ''}}>

    @error($name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</x-form.form-div>

{{--
<form method="POST" action="f">
@csrf
<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
    <div class="col-md-6">
        <input id="name" type="text" class="form-control" @error('name') is-invalid @enderror name="name" value="{{$name}}"/>
    </div>
</div>
<div class="form-group row">
    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
    <div class="col-md-6">
        <input id="description" type="text" class="form-control" @error('description') is-invalid @enderror name="description" value="{{$description}}"/>
    </div>
</div>
<div class="form-group row">
    <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}</label>
    <div class="col-md-6">
        <input id="price" type="text" class="form-control" @error('price') is-invalid @enderror name="price" value="{{$price}}"/>
    </div>
</div>
<div class="form-group row">
    <label for="quantity" class="col-md-4 col-form-label text-md-right">{{ __('Quantity') }}</label>
    <div class="col-md-6">
        <input id="quantity" type="text" class="form-control" @error('quantity') is-invalid @enderror name="quantity" value="{{$quantity}}"/>
    </div>
</div>
<div class="form-group row mb-0">
    <div class="col text-center">
        <button type="submit" class="btn btn-primary">
            {{ __('Save') }}
        </button>
    </div>
</div>
<input {{ $attributes->merge(['id' => 'product_id', 'name' => 'id', 'type' => 'hidden', 'value' => $id]) }} />
</form>
--}}
