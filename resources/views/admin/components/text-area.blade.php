<div class="form-group row" dir="{{ $locale=='ar' ? 'rtl' : '' }}">
    <label class="col-xl-2 col-lg-2 col-form-label {{ $locale=='ar' ? 'float-right text-left' : 'text-right' }} @if($required) required @endif" for="{{ $name }}">
        {{ isset($item) ? __($item.'.'.$name) : __('admin.'.$name) }}
    </label>
    <div class="col-lg-9 col-xl-9">
        <textarea name="{{ $name }}{{ $locale ? ':'. $locale : '' }}"
                class="form-control form-control-lg form-control-solid @error($name.':'.$locale) is-invalid @enderror"
                id="{{ $name }}" rows="6"
            {{ $required ? 'required' : '' }} >{{ $oldValue ? (method_exists($class, 'translate') && $oldValue->translate($locale) && $oldValue->translate($locale)->{$valueName} ? $oldValue->translate($locale)->{$valueName} : $oldValue->{$valueName}): old($name.':'.$locale) }}</textarea>
    </div>
    @error($name.':'.$locale)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
