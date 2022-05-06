<x-form.form-div>
    <label for="{{ $attributes->get('idAndFor') }}" class="mb-0">{{ $attributes->get('lblValue') }}</label>
    <select class="form-control mb-2" id="{{ $attributes->get('idAndFor') }}" name="{{ $attributes->get('name') }}">
        <?php
        $categories = \App\Models\Category::all();
        ?>
        @foreach ($categories as $category)
            <option>{{$category->name}}</option>
        @endforeach
    </select>
</x-form.form-div>
