<div class="footer">
    <div class="innerwrapper">
        <span class="counter">網站訪客人數：{{ sprintf("%08d", $totalc) }}</span>
        @if(Cookie::get('language')==0)
            {!! $webconfig[0]->copyright !!}
        @else
            @if($webconfig_i18n[0]->copyright != null)
                {!! $webconfig_i18n[0]->copyright !!}
            @else
                {!! $webconfig[0]->copyright !!}
            @endif
        @endif
    </div>
</div>
