<div class="alphabet-bar mb-4 text-center">

@foreach(range('A','Z') as $char)
    <a href="{{ request()->fullUrlWithQuery(['alpha'=>$char]) }}"
       class="alphabet-btn {{ request('alpha') == $char ? 'active' : '' }}">
        {{ $char }}
    </a>
@endforeach

<a href="{{ url()->current() }}" class="alphabet-btn reset">
    All
</a>

</div>