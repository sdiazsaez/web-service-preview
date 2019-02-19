<div class="form-group row">
    <label class="col-sm-5 col-form-label" for="{{ $key }}">{{ $key }}</label>
    <div class="col-auto">
    <input type="{{ $value['type'] }}"
           id="{{ $key }}"
           name="{{ $key }}"
           class="form-control"
           value="{{ @$value['value'] }}">
    </div>
</div>
