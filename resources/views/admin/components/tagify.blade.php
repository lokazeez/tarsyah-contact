<div class="form-group row" dir="{{ $locale=='ar' ? 'rtl' : 'ltr' }}">
    <label
        class="col-xl-2 col-lg-2 col-form-label col-sm-12 {{ $locale=='ar' ? 'float-right text-left' : 'text-right' }} @if($required) required @endif">
        {{ isset($item) ? __($item.'.'.$name) : __('admin.'.$name) }}
    </label>
    <div class="col-lg-9 col-xl-9 col-sm-12">
        <input id="tagify" class="form-control tagify @error($name) is-invalid @enderror"
               name="{{$name}}[]"
               placeholder="{{__('admin.enter')}} {{ isset($item) ? __($item.'.'.$name) : __('admin.'.$name)}}"
               value="{{ $oldValue ? (method_exists($class, 'translate') && $oldValue && $oldValue->{$valueName} ? $oldValue->{$valueName}: $oldValue->{$valueName}): (old($name)) }}"
               autofocus="" data-blacklist='.NET,PHP' @if($required) required @endif  />
        <div class="mt-3">
            <a href="javascript:;" id="kt_tagify_1_remove" class="btn btn-sm btn-light-primary font-weight-bold">Remove
                tags</a>
        </div>
        @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
