<div>
    <ul class="links">
        @foreach($routes as $route)
            <li><a href="{{ route($route['route'], $route['params']) }}">{{ $route['name'] }}</a></li>
        @endforeach
    </ul>
</div>
