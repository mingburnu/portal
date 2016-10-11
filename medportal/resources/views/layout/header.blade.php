<div class="header">
    <div class="innerwrapper">
        <div class="logo"><a href="{{ route('index') }}">
                @if(Cookie::get('language')==0)
                    <img src="{{ asset('img/'.$webconfig[0]->logo) }}">
                @else
                    <img src="{{ asset('img/'.$webconfig_i18n[0]->logo) }}">
                @endif
            </a></div>
    </div>
</div>