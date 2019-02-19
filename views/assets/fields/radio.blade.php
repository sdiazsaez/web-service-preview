<div class="form-group row">
    <label class="col-sm-5 col-form-label" for="{{ $key }}">{{ $key }}</label>
    <div class="col-auto">
        @foreach($value['options'] as $option)
            <div class="form-check">
                <input class="form-check-input" type="{{ $value['type'] }}"
                       name="{{ $key }}"
                       id="{{ $key }}"
                       value="{{ $option['value'] }}"
                        {{ ($value['value'] == $option['value'])?'checked':'' }}>
                <label class="form-check-label" for="{{$key}}">
                    {{ $option['label'] }}
                </label>
            </div>
        @endforeach
    </div>
</div>
