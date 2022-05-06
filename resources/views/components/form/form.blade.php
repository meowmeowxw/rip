{{--
needs of $action to work (a route) and $btntext
if it's needed of $enctype, $id
--}}

<form id="{{$id ?? ''}}" method="POST" action="{{$action}}" enctype="{{$enctype ?? ''}}">
    @csrf
    {{$slot}}
    <button type="submit" class="btn btn-primary {{$btnaddclass ?? ''}}">
        {{$btntext}}
    </button>
    @isset($inputvalue)
        <input id="{{$inputid ?? ''}}" value="{{$inputvalue}}" name="{{$name ?? 'id'}}" type="hidden" >
    @endisset
</form>
