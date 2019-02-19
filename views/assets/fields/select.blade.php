<div class="form-group row">
    <label class="col-sm-5 col-form-label" for="{{ $key }}">{{ $key }}</label>
    <div class="col-auto">
        <select class="form-control" style="width: 100%;" id="{{ $key }}" name="{{ $key }}">
            @foreach($value['options'] as $option)
                @if(is_array($option))
                    <option value="{{$option[$value['keys']['value']]}}" {{ ($option[$value['keys']['value']] == $value['value'])?'selected':'' }}>
                        {{ $option[$value['keys']['label']] }}
                    </option>
                    @else
                <option {{ ($option == $value['value'])?'selected':'' }}>{{ $option }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>
