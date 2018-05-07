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
                        </div>
                        <form id="ad_id" method="POST" action="{{route('ad.update',['id'=>$ad->id])}}"
                              enctype="multipart/form-data">
                            {!! Form::model($ad,['method' => 'PATCH','route'=>['ad.update',$ad->id]]) !!}
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>@lang('ui.ad title')</th>
                                    <td>
                                        @foreach($languages as $language)
                                            @if($language->id==0)
                                                <h3>{{$language->language}} (&#8226;)</h3>

                                                <div>
                                                    {!! Form::text('title',$ad->title,['cols'=>'80','rows'=>'10','class'=>'v_01']) !!}
                                                </div>
                                            @else
                                                <?php
                                                $i18n_title = null;
                                                foreach ($ad->ad_i18ns as $i18n_ad) {
                                                    if ($language->id == $i18n_ad->language) {
                                                        $i18n_title = $i18n_ad->title;
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::text('ad_i18ns['.$language->id.'][title]',$i18n_title,['cols'=>'80','rows'=>'10','class'=>'v_01']) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.ad image')(&#8226;)</th>
                                    <td>
                                        <div>
                                            @lang('ui.select type')：
                                            <label>{!! Form::radio('upload_option',true,true,['onclick'=>'chgShowField("group_02","pic");']) !!}
                                                @lang('ui.upload image')</label>
                                            <label>{!! Form::radio('upload_option',false,false,['onclick'=>'chgShowField("group_02","url");']) !!}
                                                @lang('ui.image url')</label>
                                        </div>

                                        <div class="group_02 pic">@lang('ui.upload image')
                                            ：{!! Form::file('upload_file',['class'=>'v_01','accept'=>'image/*']) !!}</div>
                                        <div class="group_02 url" style="display:none;">
                                            @lang('ui.image url')
                                            ： {!! Form::text('img',null,['class'=>'v_01']) !!}</div>
                                        <div class="note_txt">@lang('ui.recommended image size',['width'=>'640','height'=>'250'])</div>
                                        <div class="note_txt">@lang('ui.max upload size')</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.link')</th>
                                    <td>{!! Form::text('url',null) !!}

                                        <div class="note_txt">@lang('ui.url format')</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.advertisement start time')(•)</th>
                                    <td>
                                        {!! Form::text('publish_day',null,array('id'=>'datepicker','class'=>'v_03','style'=>'width:180px;')) !!}
                                        {!! Form::select('publish_hh', $hours) !!} @lang('ui.hour')
                                        {!! Form::select('publish_ii', $minuteSeconds) !!} @lang('ui.minute')
                                        {!! Form::select('publish_ss', $minuteSeconds) !!} @lang('ui.seconds')
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.advertisement end time')(•)</th>
                                    <td>
                                        <label>{!! Form::radio('forever',true,['checked'=>true]) !!}@lang('ui.forever')</label>
                                        <label>
                                            {!! Form::radio('forever',false) !!}
                                            {!! Form::text('end_day',null,array('id'=>'datepicker_2','class'=>'v_04','style'=>'width:180px;')) !!}
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
                                    <td>{!! Form::textarea('note',$ad->note,['rows'=>'5']) !!}</td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02"
                                           onClick="step(parseInt($('span.active').html())-1)">@lang('ui.previous step')</a>
                                        <a class="btn_02"
                                           onClick="step(parseInt($('span.active').html())+1)">@lang('ui.next step')</a>
                                        <a class="btn_02"
                                           onClick="submit()">@lang('ui.accomplish')</a>
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
                        <div class="detail_note_content">
                            <span class="required">(&#8226;)</span>@lang('ui.required field')
                        </div>
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
        for (var i = 1; i <= 6; i++) {
            $("form table tr:eq(" + i + ")").hide();
        }

        var value = $("input[name='upload_option']:checked").val();
        var option = value != null && value.trim() !== "" && value !== "0" && value !== 0;

        if (option) {
            chgShowField("group_02", "pic");
        } else {
            chgShowField("group_02", "url");
        }

        btn0.hide();
        btn2.hide();

        $("#datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

        $("#datepicker_2").datepicker({
            dateFormat: "yy-mm-dd"
        });
    }

    function step(s) {
        var i = 0;

        switch (s) {
            case 1:
                start(s);
                $("form table tr:eq(0)").show();

                for (i = 1; i <= 6; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                btn0.hide();
                btn1.show();
                btn2.hide();
                break;

            case 2:
                var ad_title_ch = $("input[name='title']").val();

                if (ad_title_ch == null || ad_title_ch.trim() === "") {
                    message_show("<p>．@lang('validation.custom.title.required',['attribute'=>$languages[0]->language.'-'.Lang::get('ui.ad title')])</p>");
                    break;
                }

                start(s);

                for (i = 0; i <= 6; i++) {
                    if (i !== 0) {
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

    function submit() {
        var msg = "";
        var value = $("input[name='upload_option']:checked").val();
        var option = value != null && value.trim() !== "" && value !== "0" && value !== 0;
        var db_option = "{{$ad->upload_option}}" === "1";
        var input = document.getElementsByName('upload_file')[0].files[0];
        var upload_file = $("input[name='upload_file']");
        var img = $('input[name="img"]');
        var url = $('input[name="url"]');

        if (db_option && option) {
            if (upload_file.val() != null && upload_file.val() !== "") {
                if (window.FileReader && window.Blob) {
                    if (input != null && input.size > 1024 * 1024) {
                        msg = msg.concat("<p>．@lang('validation.custom.upload_file.max',['attribute'=>Lang::get('ui.ad image')])</p>");
                    }
                }
            }
        } else if (db_option && !option) {
            if (img.val() == null || img.val().trim() === "") {
                msg = msg.concat("<p>．@lang('validation.custom.img.required')</p>");
            } else {
                if (!img.val().match(/^http([s]?):\/\/.*/)) {
                    msg = msg.concat("<p>．@lang('validation.custom.img.url')</p>");
                }
            }
        } else if (!db_option && option) {
            if (upload_file.val() == null || upload_file.val() === "") {
                msg = msg.concat("<p>．@lang('validation.custom.upload_file.required',['attribute'=>Lang::get('ui.ad image')])</p>");
            } else {
                if (window.FileReader && window.Blob) {
                    if (input != null && input.size > 1024 * 1024) {
                        msg = msg.concat("<p>．@lang('validation.custom.upload_file.max',['attribute'=>Lang::get('ui.ad image')])</p>");
                    }
                }
            }
        } else {
            if (img.val() == null || img.val().trim() === "") {
                msg = msg.concat("<p>．@lang('validation.custom.img.required')</p>");
            } else {
                if (!img.val().match(/^http([s]?):\/\/.*/)) {
                    msg = msg.concat("<p>．@lang('validation.custom.img.url')</p>");
                }
            }
        }

        if (url.val() != null && url.val().trim() !== "") {
            if (!url.val().match(/^http([s]?):\/\/.*/)) {
                msg = msg.concat("<p>．@lang('validation.custom.url.url',['attribute'=>Lang::get('ui.link')])</p>");
            }
        }

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
        var is_no_end = forever != null && forever.trim() !== "" && forever !== "0" && forever !== 0;

        if (publish_day == null || publish_day.trim() === "") {
            msg = msg + "<p>．@lang('validation.custom.publish_day.required')</p>";
        } else {
            if (publish_day.match(dayRegEx) == null) {
                msg = msg + "<p>．@lang('validation.custom.publish_day.date_format')</p>";
            } else {
                var publishDate = new Date(publish_day);

                if (isNaN(publishDate)) {
                    msg = msg + "<p>．@lang('validation.custom.publish_day.date_format')</p>";
                }
            }
        }

        if (publish_hh == null || publish_ii == null || publish_ss == null || publish_hh === "" || publish_ii === "" || publish_ss === "") {
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

                if (isNaN(publishTime)) {
                    msg = msg + "<p>．@lang('validation.custom.publish_hh.date_format')</p>"
                        + "<p>．@lang('validation.custom.publish_ii.date_format')</p>"
                        + "<p>．@lang('validation.custom.publish_ss.date_format')</p>";
                }
            }
        }

        if (!is_no_end) {
            if (end_day == null || end_day.trim() === "") {
                msg = msg + "<p>．@lang('validation.custom.end_day.required')</p>";
            } else {
                if (end_day.match(dayRegEx) == null) {
                    msg = msg + "<p>．@lang('validation.custom.end_day.date_format')</p>";
                } else {
                    var endDate = new Date(end_day);

                    if (isNaN(endDate)) {
                        msg = msg + "<p>．@lang('validation.custom.end_day.date_format')</p>";
                    }
                }
            }

            if (end_hh == null || end_ii == null || end_ss == null || end_hh === "" || end_ii === "" || end_ss === "") {
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

                    if (isNaN(endTime)) {
                        msg = msg + "<p>．@lang('validation.custom.end_hh.date_format')</p>"
                            + "<p>．@lang('validation.custom.end_ii.date_format')</p>"
                            + "<p>．@lang('validation.custom.end_ss.date_format')</p>";
                    }
                }
            }

            if (msg === "") {
                var begin = new Date(publish_day + " " + publish_hh + ":" + publish_ii + ":" + publish_ss);
                var after = new Date(end_day + " " + end_hh + ":" + end_ii + ":" + end_ss);

                if (begin.getTime() >= after.getTime()) {
                    msg = msg + "<p>．@lang('validation.custom.end_time.after')</p>";
                }
            }
        }

        if (msg !== "") {
            message_show(msg);
        } else {
            document.getElementById('ad_id').submit();
        }
    }
</script>
</body>
</html>