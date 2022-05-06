<x-form.form-div>
    <label for="{{ $attributes->get('idAndFor') }}" class="mb-0">{{ $attributes->get('lblValue') }}</label>
    <div class="custom-file mb-2">
        <input id="{{ $attributes->get('idAndFor') }}" name="{{ $attributes->get('name') }}" type="file"
               accept="image/*"
               class="custom-file-input" required>
        <label for="{{ $attributes->get('idAndFor') }}"
               class="custom-file-label">{{ $attributes->get('lblValue') }}</label>
    </div>
</x-form.form-div>

{{--
Dobbiamo scegliere tra quello sopra e quello sotto pero se scegli commenta non cancellare please

<x-form.form-div>
    <label for="{{ $attributes->get('idAndFor') }}" class="mb-0">{{ $attributes->get('lblValue') }}</label>
    <input id="{{ $attributes->get('idAndFor') }}" type="file" class="form-control-file" accept="image/*"
           @error('logo') is-invalid @enderror name="{{ $attributes->get('name') }}" value=""/>
</x-form.form-div>
--}}
