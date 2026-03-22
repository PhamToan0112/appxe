@if(is_array($service_type))
    @foreach ($service_type as $type)
        <li class="nav item">{{ $type }}</li>
    @endforeach
@else
    {{ $service_type }}
@endif
