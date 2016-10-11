<div class="lang">
    <div class="innerwrapper">
        {!! Form::open(['method' => 'POST','route'=>['locale']]) !!}
        {!! Form::select('lang_id',$languages,Cookie::get('language'),array('onchange'=>'change_lang()')) !!}
        {!! Form::close() !!}
    </div>
</div>