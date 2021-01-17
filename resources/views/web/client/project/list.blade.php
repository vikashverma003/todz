<ul class="list-inline">
    @foreach($skills as $s)
<li name="{{$s->id}}" data-id="{{$s->id}}" data-name="{{$s->name}}" class="full-width pb-2 skill-list"> {{$s->name}}</li>
   @endforeach
</ul>        