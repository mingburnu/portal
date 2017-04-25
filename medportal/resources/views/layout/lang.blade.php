<?php
$languages = DB::table('languages')->where('display', true)->orderBy('sort', 'desc')->lists('language', 'id');
?>
<div class="lang">
    <div class="innerwrapper">
        {!! Form::open(['method' => 'POST','route'=>['locale']]) !!}
        @if(Cookie::get('language')!=null)
            {!! Form::select('lang_id',$languages,Cookie::get('language'),array('onchange'=>'change_lang()')) !!}
        @else
            {!! Form::select('lang_id',$languages,0,array('onchange'=>'change_lang()')) !!}
        @endif
        {!! Form::close() !!}
    </div>
</div>
<script>
    function change_lang() {
        var url = $('div.lang').children().children().attr('action');
        var data = $('div.lang').children().children().serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (result) {
                loadI18n();
            }
        });
    }

    function loadI18n() {
        window.location.href = location.href;
    }

</script>