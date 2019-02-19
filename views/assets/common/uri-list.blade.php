<div>
    <ul class="links">
        @foreach($data['entries'] as $item)
            <li>
                <a href="{{ route(
                                $data['route']['name'],
                                array_merge($data['route']['params'], [$item[$data['key']]]) ) }}">
                    @if(is_array($data['label']))
                        @foreach($data['label'] as $label)
                            {{ array_get($item, $label) }}
                        @endforeach
                    @else
                        {{ array_get($item, $data['label']) }}
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>
