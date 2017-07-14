<div class="footer">
    <div class="innerwrapper">
        <span class="counter">
            {!! $signal[0]->visitor !!} ：{{ sprintf("%08d", $totalc) }}
        </span>
        @if($webconfig_i18n!=null && $webconfig_i18n[0]->copyright!=null)
            {!! $webconfig_i18n[0]->copyright !!}
        @else
            {!! $webconfig[0]->copyright !!}
        @endif
    </div>
</div>
