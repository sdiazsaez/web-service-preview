<form method="post" action="{{ $form['action'] }}">
    <div class="col-auto">
        <button type="submit" class="btn btn-primary mb-2">Submit</button>
    </div>
    @csrf
    @foreach($form['fields'] as $key => $value)
        @includeFirst([
            'larangular.web-service-preview::assets.fields.'.@$value['type'],
            'larangular.web-service-preview::assets.fields.'.@$value['tag']
        ], compact('key', 'value'))
    @endforeach

    <div class="col-auto">
        <button type="submit" class="btn btn-primary mb-2">Submit</button>
    </div>
</form>
