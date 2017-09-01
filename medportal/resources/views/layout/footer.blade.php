<div class="footer">
    <div class="innerwrapper">
        @if($webconfig[0]->count_visitors)
            <span class="counter">
                {!! $signal[0]->visitor !!} ：{{ sprintf("%08d", $totalc) }}
            </span>
        @endif

        @if($webconfig_i18n!=null && $webconfig_i18n[0]->copyright!=null)
            {!! $webconfig_i18n[0]->copyright !!}
        @else
            {!! $webconfig[0]->copyright !!}
        @endif
    </div>
</div>
