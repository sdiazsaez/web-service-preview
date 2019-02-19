<section>
    @if(array_has($itemValue, ['type', 'tag']))
        @includeFirst([
            'larangular.web-service-preview::assets.fields.'.@$itemValue['type'],
            'larangular.web-service-preview::assets.fields.'.@$itemValue['tag']
        ], [
        'key' => $itemKey,
        'value' => $itemValue
        ])
    @else
        <div class="card">
            <div class="card-block">
                <h4 class="card-title">{{$itemKey}}</h4>
                <!--
                <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                -->
                @foreach($itemValue as $key => $value)
                    @include('larangular.web-service-preview::assets.form.group', [
                        'itemKey' => $key,
                        'itemValue' => $value
                    ])
                @endforeach
            </div>
        </div>
    @endif
</section>
