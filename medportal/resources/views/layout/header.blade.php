<div class="header">
    <div class="innerwrapper">
        <div class="logo"><a href="{{ route('index') }}">
                @if($webconfig_i18n!=null)
                    <img src="{{ asset('img/'.$webconfig_i18n[0]->logo).'?v='.uniqid() }}">
                @else
                    <img src="{{ asset('img/'.$webconfig[0]->logo).'?v='.uniqid() }}">
                @endif
            </a></div>
    </div>
</div>