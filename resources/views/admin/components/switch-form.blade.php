<div class="form-group row" dir="{{ $locale=='ar' ? 'rtl' : 'ltr' }}">
    <label class="col-xl-2 col-lg-2 col-form-label {{ $locale=='ar' ? 'float-right text-left' : 'text-right' }} @if($required) required @endif">{{ $item ? __($item.'.'.$name) : __('admin.'.$name)}}</label>
    <div class="col-col-lg-9 col-xl-9 col-9">
        <div class="switch switch-primary switch-icon">
            <label>
                <input id="{{$name}}" name="{{ $name }}" {{ $oldValue && $oldValue->{$name} == 1 ? 'checked="checked"' : '' }} type="checkbox" @if($required) required @endif />
                <span></span>
            </label>
            @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
