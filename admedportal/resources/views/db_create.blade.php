<!DOCTYPE html>
<html lang="zh-tw">
@include('layout.head')
<body>
<div class="wrapper">

    @include('layout.header')

    <div class="box">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
                <td class="td_1">
                    <!-- menu 區塊 Begin -->
                @include('layout.menu')
                <!-- menu 區塊 End -->
                </td>
                <td class="td_2">
                    <!-- 內容 區塊 Begin -->

                    <!-- message 區塊 Begin -->
                @include('layout.message')
                <!-- message 區塊 End -->


                    <!-- detail 區塊 Begin -->
                    <div class="detail_box">
                        <div class="steps_box">
                            <span class="title">@lang('ui.step')</span>
                            <span class="active">1</span>
                            <span>2</span>
                            <span>3</span>
                        </div>
                        <form id="database_id" method="POST" action="{{route('db.store')}}">
                            {!! Form::open(['method' => 'POST','route'=>['db.store']]) !!}
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>@lang('ui.database name')</th>
                                    <td>
                                        @foreach($languages as $language)
                                            @if($language->id==0)
                                                <h3>{{$language->language}} (&#8226;)</h3>

                                                <div>
                                                    {!! Form::text('database_name',null,['class'=>'v_01']) !!}
                                                </div>
                                            @else
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::text($language->id.'_database_name',null) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.embedded html')</th>
                                    <td>
                                        @foreach($languages as $language)
                                            @if($language->id==0)
                                                <h3>{{$language->language}} (&#8226;)</h3>

                                                <div>
                                                    {!! Form::textarea('syntax',null,['cols'=>'80','rows'=>'10','class'=>'v_01']) !!}
                                                </div>
                                            @else
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::textarea($language->id.'_syntax',null,['cols'=>'80','rows'=>'10']) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.display')</th>
                                    <td>
                                        <label>{!! Form::radio('view',true,['checked'=>true]) !!}@lang('ui.true')</label>
                                        <label>{!! Form::radio('view',false) !!}@lang('ui.false')</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.sort')</th>
                                    <td>
                                        {!! Form::text('rank_id',null,['class'=>'v_00']) !!}
                                        <div class="note_txt">@lang('ui.number order')</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.note')</th>
                                    <td> {!! Form::textarea('note',null,['rows'=>'5']) !!}</td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02"
                                           onClick="step(parseInt($('span.active').html())-1)">@lang('ui.previous step')</a>
                                        <a class="btn_02"
                                           onClick="step(parseInt($('span.active').html())+1)">@lang('ui.next step')</a>
                                        <a class="btn_02"
                                           onClick="document.getElementById('database_id').submit();">@lang('ui.accomplish')</a>
                                    </td>
                                </tr>
                            </table>
                            {!! Form::close() !!}
                        </form>
                    </div>
                    <!-- detail 區塊 End -->

                    <!-- Note 區塊 Begin -->
                    <div class="detail_note">
                        <div class="detail_note_title">Note</div>
                        <div class="detail_note_content"><span
                                    class="required">(&#8226;)</span>@lang('ui.required field')</div>
                    </div>
                    <!-- Note 區塊 End -->

                    <!-- 內容 區塊 End -->
                </td>
            </tr>
        </table>
    </div>

    @include('layout.footer')

</div>

<!-- 執行javascript 區塊 Begin -->
@include('layout.javascript')
<!-- 執行javascript 區塊 End -->
<script>
    init();

    function init() {
        for (var i = 1; i <= 4; i++) {
            $("form table tr:eq(" + i + ")").hide();
        }

        btn0.hide();
        btn2.hide();
    }

    function step(s) {
        var i = 0;

        switch (s) {
            case 1:
                start(s);
                $("form table tr:eq(0)").show();

                for (i = 1; i <= 4; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                btn0.hide();
                btn1.show();
                btn2.hide();
                break;
            case 2:
                if (getCurrentStep() === "1") {
                    var database_name_ch = $("input[name='database_name']").val();
                    if (database_name_ch == null || database_name_ch.trim() === "") {
                        message_show("<p>．@lang('validation.custom.database_name.required',['attribute'=>$languages[0]->language.'-'.Lang::get('ui.database name')])</p>");
                        break;
                    }
                }

                start(s);

                for (i = 0; i <= 4; i++) {
                    var tr = $("form table tr:eq(" + i + ")");

                    switch (i) {
                        case 1:
                            tr.show();
                            break;
                        default:
                            tr.hide();
                    }
                }

                btn0.show();
                btn1.show();
                btn2.hide();
                break;

            case 3:
                var syntax_ch = $("textarea[name='syntax']").val();

                if (syntax_ch == null || syntax_ch.trim() === "") {
                    message_show("<p>．@lang('validation.custom.syntax.required',['attribute'=>$languages[0]->language.'-'.Lang::get('ui.embedded html')])</p>");
                    break;
                }

                start(s);

                for (i = 0; i <= 4; i++) {
                    if (i > 1) {
                        $("form table tr:eq(" + i + ")").show();
                    } else {
                        $("form table tr:eq(" + i + ")").hide();
                    }
                }

                btn0.show();
                btn1.hide();
                btn2.show();
                break;
        }
    }
</script>
</body>
</html>
