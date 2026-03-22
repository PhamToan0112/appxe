@if(isset($orderIssue) && $orderIssue->count() > 0)
    @php
        $count = 0;
    @endphp
    @foreach($orderIssue as $item)
        <div class="d-flex flex-column">
            {{ ++$count}}. {{ $item->description }}
        </div>
    @endforeach
@else
    <div>N/A</div>
@endif
