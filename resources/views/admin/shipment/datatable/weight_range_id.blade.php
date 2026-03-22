@if($weightRange)
    <span>
        {{ $weightRange->min_weight }} - {{ $weightRange->max_weight }} Kg
    </span>
@else
    <span>N/A</span>
@endif
