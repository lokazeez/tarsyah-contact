<div class="form-group row col-md-12 mt-10">
    <label class="col-lg-2 col-form-label text-right @if($required) required @endif">
        {{ isset($item) ? __($item.'.'.$name) : __('admin.'.$name) }}
    </label>
    <div class="col-9">
        <div class="radio-inline">
            @foreach($choices as $choice)
                <label class="radio radio-primary">
                    <input id="{{$name}}" class="type" name="{{ $name }}" {{ $oldValue ? ($oldValue->{$name} == $choice->value ? 'checked' : '') : ((old($name) ?? 1) == $choice->value ? 'checked' : (isset($choice->checked) ? 'checked':'')) }} type="radio" value="{{ $choice->value }}" @if($required) required @endif/> {{ $choice->name }}
                    <span></span>
                </label>
            @endforeach
            @error($name)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
