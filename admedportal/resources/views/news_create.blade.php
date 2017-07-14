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
                        <form id="news_add" method="POST" action="{{route('news.store')}}">
                            {!! Form::open(['method' => 'POST','route'=>['news.store']]) !!}
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <th>@lang('ui.title')</th>
                                    <td>
                                        @foreach($languages as $language)
                                            @if($language->id==0)
                                                <h3>{{$language->language}} (&#8226;)</h3>

                                                <div>
                                                    {!! Form::text('title',null) !!}
                                                </div>
                                            @else
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::text('news_i18ns['.$language->id.'][title]',null) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.content')</th>
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
                                                        {!! Form::textarea('news_i18ns['.$language->id.'][content]',null,['id'=>'editor'.$language->id,'cols'=>'80','rows'=>'10']) !!}
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
                                <tr>
                                    <th>@lang('ui.published start time')(•)</th>
                                    <td>
                                        {!! Form::text('publish_day',null,array('id'=>'datepicker','class'=>'v_01','style'=>'width:180px;')) !!}
                                        {!! Form::select('publish_hh', $hours) !!} @lang('ui.hour')
                                        {!! Form::select('publish_ii', $minuteSeconds) !!} @lang('ui.minute')
                                        {!! Form::select('publish_ss', $minuteSeconds) !!} @lang('ui.seconds')
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.published end time')(•)</th>
                                    <td>
                                        <label>{!! Form::radio('forever',true,['checked'=>true]) !!}@lang('ui.forever')</label>
                                        <label>
                                            {!! Form::radio('forever',false) !!}
                                            {!! Form::text('end_day',null,array('id'=>'datepicker_2','class'=>'v_02','style'=>'width:180px;')) !!}
                                            {!! Form::select('end_hh', $hours) !!} @lang('ui.hour')
                                            {!! Form::select('end_ii', $minuteSeconds) !!} @lang('ui.minute')
                                            {!! Form::select('end_ss', $minuteSeconds) !!} @lang('ui.seconds')
                                        </label>
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
                                </tbody>
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
        for (var i = 1; i <= 5; i++) {
            $("form table tr:eq(" + i + ")").hide();
        }

        $("a.btn_02:eq(0)").hide();
        $("a.btn_02:eq(2)").hide();

        @foreach($languages as $language)
        CKEDITOR.replace("{{'editor'.$language->id}}", lang());
        @endforeach

        //
        $(".accordion_01").accordion({heightStyle: "content"});

        $("#datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

        $("#datepicker_2").datepicker({
            dateFormat: "yy-mm-dd"
        });
    }

    function step(i) {
        switch (i) {
            case 1 :
                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                $("form table tr:eq(0)").show();
                for (var i = 1; i <= 5; i++) {
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
                        message_show("<p>．@lang('validation.custom.title.required',['attribute'=>$languages[0]->language.'-'.Lang::get('ui.title')])</p>");
                        break;
                    }
                }

                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                for (var i = 0; i <= 5; i++) {
                    if (i != 1) {
                        $("form table tr:eq(" + i + ")").hide();
                    } else {
                        $("form table tr:eq(" + i + ")").show();
                    }
                }

                message_hide();
                $("a.btn_02:eq(0)").show();
                $("a.btn_02:eq(1)").show();
                $("a.btn_02:eq(2)").hide();
                break;

            case 3:
                if ($("span.active").html() == "2") {
                    if (CKEDITOR.instances.editor0.getData().length == 0) {
                        message_show("<p>．@lang('validation.custom.content.required',['attribute'=>$languages[0]->language.'-'.Lang::get('ui.content')])</p>");
                        break;
                    }
                }

                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                for (var i = 0; i <= 1; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                for (var i = 2; i <= 5; i++) {
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
        var msg = "";
        var publish_day = $("input[name='publish_day']").val();
        var publish_hh = $("select[name='publish_hh']").val();
        var publish_ii = $("select[name='publish_ii']").val();
        var publish_ss = $("select[name='publish_ss']").val();
        var end_day = $("input[name='end_day']").val();
        var end_hh = $("select[name='end_hh']").val();
        var end_ii = $("select[name='end_ii']").val();
        var end_ss = $("select[name='end_ss']").val();
        var dayRegEx = /^\d{4}-\d{2}-\d{2}$/;
        var timeRegEx = /^\d{2}$/;

        var forever = $("input[name='forever']:checked").val();
        var is_no_end = forever != null && forever.trim() != "" && forever != "0" && forever != 0;

        if (publish_day == null || publish_day.trim() == "") {
            msg = msg + "<p>．@lang('validation.custom.publish_day.required')</p>";
        } else {
            if (publish_day.match(dayRegEx) == null) {
                msg = msg + "<p>．@lang('validation.custom.publish_day.date_format')</p>";
            } else {
                var publishDate = new Date(publish_day.match(dayRegEx));
                if (Object.prototype.toString.call(publishDate) === "[object Date]") {
                    if (isNaN(publishDate)) {
                        msg = msg + "<p>．@lang('validation.custom.publish_day.date_format')</p>";
                    }
                }
            }
        }

        if (publish_hh == null || publish_ii == null || publish_ss == null || publish_hh == "" || publish_ii == "" || publish_ss == "") {
            msg = msg + "<p>．@lang('validation.custom.publish_hh.date_format')</p>"
                    + "<p>．@lang('validation.custom.publish_ii.date_format')</p>"
                    + "<p>．@lang('validation.custom.publish_ss.date_format')</p>";
            message_show(msg);
        } else {
            if (publish_hh.match(timeRegEx) == null || publish_ii.match(timeRegEx) == null || publish_ss.match(timeRegEx) == null) {
                msg = msg + "<p>．@lang('validation.custom.publish_hh.date_format')</p>"
                        + "<p>．@lang('validation.custom.publish_ii.date_format')</p>"
                        + "<p>．@lang('validation.custom.publish_ss.date_format')</p>";
            } else {
                var publishTime = new Date(1970, 0, 1, publish_hh, publish_ii, publish_ss, 0);
                if (Object.prototype.toString.call(publishTime) === "[object Date]") {
                    if (isNaN(publishTime)) {
                        msg = msg + "<p>．@lang('validation.custom.publish_hh.date_format')</p>"
                                + "<p>．@lang('validation.custom.publish_ii.date_format')</p>"
                                + "<p>．@lang('validation.custom.publish_ss.date_format')</p>";
                    }
                }
            }

            if (!is_no_end) {
                if (end_day == null || end_day.trim() == "") {
                    msg = msg + "<p>．@lang('validation.custom.end_day.required')</p>";
                } else {
                    if (end_day.match(dayRegEx) == null) {
                        msg = msg + "<p>．@lang('validation.custom.end_day.date_format')</p>";
                    } else {
                        var endDate = new Date(end_day.match(dayRegEx));
                        if (Object.prototype.toString.call(endDate) === "[object Date]") {
                            if (isNaN(endDate)) {
                                msg = msg + "<p>．@lang('validation.custom.end_day.date_format')</p>";
                            }
                        }
                    }
                }

                if (end_hh == null || end_ii == null || end_ss == null || end_hh == "" || end_ii == "" || end_ss == "") {
                    msg = msg + "<p>．@lang('validation.custom.end_hh.date_format')</p>"
                            + "<p>．@lang('validation.custom.end_ii.date_format')</p>"
                            + "<p>．@lang('validation.custom.end_ss.date_format')</p>";
                } else {
                    if (end_hh.match(timeRegEx) == null || end_ii.match(timeRegEx) == null || end_ss.match(timeRegEx) == null) {
                        msg = msg + "<p>．@lang('validation.custom.end_hh.date_format')</p>"
                                + "<p>．@lang('validation.custom.end_ii.date_format')</p>"
                                + "<p>．@lang('validation.custom.end_ss.date_format')</p>";
                    } else {
                        var endTime = new Date(1970, 0, 1, end_hh, end_ii, end_ss, 0);
                        if (Object.prototype.toString.call(endTime) === "[object Date]") {
                            if (isNaN(endTime)) {
                                msg = msg + "<p>．@lang('validation.custom.end_hh.date_format')</p>"
                                        + "<p>．@lang('validation.custom.end_ii.date_format')</p>"
                                        + "<p>．@lang('validation.custom.end_ss.date_format')</p>";
                            }
                        }
                    }
                }

                if (msg == "") {
                    var begin = new Date(publish_day + " " + publish_hh + ":" + publish_ii + ":" + publish_ss);
                    var after = new Date(end_day + " " + end_hh + ":" + end_ii + ":" + end_ss);

                    if (begin.getTime() >= after.getTime()) {
                        msg = msg + "<p>．@lang('validation.custom.end_time.after')</p>";
                    }
                }
            }

            if (msg != "") {
                message_show(msg);
            } else {
                document.getElementById('news_add').submit();
            }
        }
    }
</script>
</body>
</html>
