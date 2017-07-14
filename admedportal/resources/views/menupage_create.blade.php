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
                        <form id="paper_add" method="POST" action="{{route('menupage.store')}}">
                            {!! Form::open(['method' => 'POST','route'=>['menupage.store']]) !!}
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>@lang('ui.menu name')(&#8226;)</th>
                                    <td>
                                        @foreach($languages as $language)
                                            @if($language->id==0)
                                                <h3>{{$language->language}} (&#8226;)</h3>

                                                <div>
                                                    {!! Form::text('title',null,['class'=>'v_01']) !!}
                                                </div>
                                            @else
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::text('menupage_i18ns['.$language->id.'][title]',null) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.type')</th>
                                    <td>
                                        <label>
                                            {!! Form::radio('type',true,true,['onclick'=>'chgShowField("url","txt");']) !!}
                                            @lang('ui.webpage content')
                                        </label>
                                        <label>
                                            {!! Form::radio('type',false,false,['onclick'=>'chgShowField("txt","url");']) !!}
                                            @lang('ui.link')
                                        </label>
                                    </td>
                                </tr>
                                <tr class="txt">
                                    <th>@lang('ui.webpage content')</th>
                                    <td>
                                        <div class="accordion_01">
                                            @foreach($languages as $language)
                                                @if($language->id==0)
                                                    <h3>{{$language->language}} (&#8226;)</h3>

                                                    <div>
                                                        {!! Form::textarea('content',null,['id'=>'editor'.$language->id,'cols'=>'80','rows'=>'10']) !!}
                                                    </div>
                                                @else
                                                    <h3>{{$language->language}}</h3>

                                                    <div>
                                                        {!! Form::textarea('menupage_i18ns['.$language->id.'][content]', null,['id'=>'editor'.$language->id,'cols'=>'80','rows'=>'10']) !!}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="note_txt">
                                            @lang('ui.caution'):<BR/>
                                            ▲@lang('ui.link text color')<BR/>
                                            ▲@lang('ui.recommended image width')<BR/>
                                            ▲@lang('ui.recommended image center')<BR/>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="url" style="">
                                    <th>@lang('ui.link')</th>
                                    <td>
                                        @foreach($languages as $language)
                                            @if($language->id==0)
                                                <h3>{{$language->language}} (&#8226;)</h3>

                                                <div>
                                                    {!! Form::text('url',null) !!}
                                                </div>
                                            @else
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::text('menupage_i18ns['.$language->id.'][url]',null) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.position')</th>
                                    <td>
                                        {!! Form::select('parent_id',$select) !!}
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
                                    <td>{!! Form::textarea('note',null,['rows'=>'5']) !!}</td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02"
                                           onClick="step(parseInt($('span.active').html())-1)">@lang('ui.previous step')</a>
                                        <a class="btn_02"
                                           onClick="step(parseInt($('span.active').html())+1)">@lang('ui.next step')</a>
                                        <a class="btn_02"
                                           onClick="submit();">@lang('ui.accomplish')</a>
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
        for (var i = 1; i <= 7; i++) {
            $("form table tr:eq(" + i + ")").hide();
        }

        $("a.btn_02:eq(0)").hide();
        $("a.btn_02:eq(2)").hide();

        @foreach($languages as $language)
        CKEDITOR.replace("{{'editor'.$language->id}}", lang());
        @endforeach

        $(".accordion_01").accordion({heightStyle: "content"});

        $("#datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });
    }

    function step(i) {
        switch (i) {
            case 1 :
                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                $("form table tr:eq(0)").show();
                for (var i = 1; i <= 7; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                $("div.message").hide();
                $("a.btn_02:eq(0)").hide();
                $("a.btn_02:eq(1)").show();
                $("a.btn_02:eq(2)").hide();
                break;
            case 2 :
                if ($("span.active").html() == "1") {
                    var title_ch = $("input[name='title']").val()
                    if (title_ch == null || title_ch.trim() == "") {
                        message_show("<p>．@lang('validation.custom.title.required',['attribute' => Lang::get('ui.menu name')])</p>");
                        break;
                    }
                }

                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                $("form table tr:eq(0)").hide();
                $("form table tr:eq(1)").show();
                for (var i = 4; i <= 7; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                var value = $("input[name='type']:checked").val();
                var option = value != null && value.trim() != "" && value != "0" && value != 0;
                if (option) {
                    chgShowField("url", "txt");
                } else {
                    chgShowField("txt", "url");
                }

                message_hide();
                $("a.btn_02:eq(0)").show();
                $("a.btn_02:eq(1)").show();
                $("a.btn_02:eq(2)").hide();
                break;

            case 3:
                if ($("span.active").html() == "2") {
                    var msg = "";
                    var value = $("input[name='type']:checked").val();
                    var option = value != null && value.trim() != "" && value != "0" && value != 0;

                    if (option) {
                        var content_ch = $("iframe.cke_wysiwyg_frame.cke_reset").contents().find("body").text();
                        if (CKEDITOR.instances.editor0.getData().length == 0) {
                            msg = msg.concat("<p>．@lang('validation.custom.content.required',['attribute'=>$languages[0]->language . \Lang::get('ui.webpage content')])</p>");
                        }
                    } else {
                    @foreach ($languages as $language)
                        @if ($language->id ==0)
                            var url_ch = $("input[name='url']").val();
                            if (url_ch == null || url_ch.trim() == "") {
                                msg = msg.concat("<p>．@lang('validation.custom.url.required',['attribute' => $language->language.'-'.Lang::get('ui.link')])</p>");
                            } else {
                                if (!url_ch.match(/^http([s]?):\/\/.*/)) {
                                    msg = msg.concat("<p>．@lang('validation.custom.url.url',['attribute' => $language->language.'-'.Lang::get('ui.link')])</p>");
                                }
                            }
                        @else
                            var url_{{$language->id}} = $("input[name='menupage_i18ns[{{$language->id}}][url]']").val();
                            if (url_{{$language->id}} != null && url_{{$language->id}}.trim() != "") {
                                if (!url_{{$language->id}}.match(/^http([s]?):\/\/.*/)) {
                                    msg = msg.concat("<p>．@lang('validation.custom.url.url',['attribute' => $language->language.'-'.Lang::get('ui.link')])</p>");
                                }
                            }
                        @endif
                    @endforeach
                    }
                }

                if (msg != "") {
                    message_show(msg);
                    break;
                }

                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                for (var i = 0; i <= 3; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                for (var i = 4; i <= 7; i++) {
                    $("form table tr:eq(" + i + ")").show();
                }

                message_hide();
                $("a.btn_02:eq(0)").show();
                $("a.btn_02:eq(1)").hide();
                $("a.btn_02:eq(2)").show();
                break;
        }
    }

    function submit() {
        document.getElementById('paper_add').submit();
    }
</script>
</body>
</html>