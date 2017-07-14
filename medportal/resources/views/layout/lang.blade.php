<div class="lang">
    <div class="innerwrapper">
        {!! Form::open(['method' => 'POST','route'=>['locale']]) !!}
        {!! Form::select('lang_id',$languages,$signal[0]->id,array('onchange'=>'change_lang()')) !!}
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