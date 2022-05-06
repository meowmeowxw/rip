@isset($status)
    @switch($status)
        @case('delivered')
            <span title="{{__('Status')}}" class="badge badge-pill badge-primary"> {{$status}} </span>
            @break
        @case('shipped')
            <span title="{{__('Status')}}" class="badge badge-pill badge-secondary"> {{$status}} </span>
            @break
        @case('confirmed')
            <span title="{{__('Status')}}" class="badge badge-pill badge-success"> {{$status}} </span>
            @break
        @case('waiting')
            <span title="{{__('Status')}}" class="badge badge-pill badge-danger"> {{$status}} </span>
            @break
    @endswitch
@endisset
