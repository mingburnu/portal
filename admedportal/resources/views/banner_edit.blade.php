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
                        <form id="banner_id" method="POST" action="{{route('banner.update',['id'=>$banner->id])}}"
                              enctype="multipart/form-data">
                            {!! Form::model($banner,['method' => 'PATCH','route'=>['banner.update',$banner->id]]) !!}
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>@lang('ui.banner title')</th>
                                    <td>
                                        @foreach($languages as $language)
                                            @if($language->id==0)
                                                <h3>{{$language->language}} (&#8226;)</h3>

                                                <div>
                                                    {!! Form::text('title',$banner->title,['cols'=>'80','rows'=>'10','class'=>'v_01']) !!}
                                                </div>
                                            @else
                                                <?php
                                                $i18n_title = null;
                                                foreach ($banner->banner_i18ns as $i18n_banner) {
                                                    if ($language->id == $i18n_banner->language) {
                                                        $i18n_title = $i18n_banner->title;
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::text('banner_i18ns['.$language->id.'][title]',$i18n_title,['cols'=>'80','rows'=>'10','class'=>'v_01']) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.banner image')@lang('ui.display')</th>
                                    <td>
                                        <label>{!! Form::radio('play',true,['checked'=>true]) !!}@lang('ui.true')</label>
                                        <label>{!! Form::radio('play',false) !!}@lang('ui.false')</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.banner content')</th>
                                    <td>
                                        @foreach($languages as $language)
                                            @if($language->id==0)
                                                <h3>{{$language->language}} </h3>

                                                <div>
                                                    {!! Form::text('info',$banner->info,['cols'=>'80','rows'=>'10','class'=>'v_01']) !!}
                                                </div>
                                            @else
                                                <?php
                                                $i18n_info = null;
                                                foreach ($banner->banner_i18ns as $i18n_banner) {
                                                    if ($language->id == $i18n_banner->language) {
                                                        $i18n_info = $i18n_banner->info;
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::text('banner_i18ns['.$language->id.'][info]',$i18n_info,['cols'=>'80','rows'=>'10','class'=>'v_01']) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.banner image')(&#8226;)</th>
                                    <td>
                                        <img class="banner_img" src="{{ asset($banner->img) }}"><BR/>

                                        <div>
                                            @lang('ui.select type')：
                                            <label>{!! Form::radio('upload_option',true,true,['onclick'=>'chgShowField("group_02","pic");']) !!}
                                                @lang('ui.upload image')</label>
                                            <label>{!! Form::radio('upload_option',false,false,['onclick'=>'chgShowField("group_02","url");']) !!}
                                                @lang('ui.image url')</label>
                                        </div>

                                        <div class="group_02 pic">@lang('ui.upload image')
                                            ：{!! Form::file('upload_file',['accept'=>'image/*']) !!}</div>
                                        <div class="group_02 url" style="display:none;">
                                            @lang('ui.image url')： {!! Form::text('img',null) !!}</div>
                                        <div class="note_txt">@lang('ui.recommended image size',['width'=>'1300','height'=>'400'])</div>
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
                                    <th>@lang('ui.display')</th>
                                    <td>
                                        <label>{!! Form::radio('view',true,['checked'=>true]) !!}@lang('ui.true')</label>
                                        <label>{!! Form::radio('view',false) !!}@lang('ui.false')</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.sort')</th>
                                    <td>{!! Form::text('rank_id',null,['class'=>'v_00']) !!}
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
        for (var i = 2; i <= 7; i++) {
            $("form table tr:eq(" + i + ")").hide();
        }

        var value = $("input[name='upload_option']:checked").val();
        var option = value != null && value.trim() != "" && value != "0" && value != 0;
        if (option) {
            chgShowField("group_02", "pic");
        } else {
            chgShowField("group_02", "url");
        }

        $("a.btn_02:eq(0)").hide();
        $("a.btn_02:eq(2)").hide();
    }

    function step(i) {
        switch (i) {
            case 1 :
                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                $("form table tr:eq(0)").show();
                $("form table tr:eq(1)").show();
                for (var i = 2; i <= 7; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                $("div.message").hide();
                $("a.btn_02:eq(0)").hide();
                $("a.btn_02:eq(1)").show();
                $("a.btn_02:eq(2)").hide();
                break;

            case 2:
                if ($("span.active").html() == "1") {
                    var banner_title_ch = $("input[name='title']").val()
                    if (banner_title_ch == null || banner_title_ch.trim() == "") {
                        message_show("<p>．@lang('validation.custom.title.required',['attribute'=>$languages[0]->language.'-'.Lang::get('ui.banner title')])</p>");
                        break;
                    }
                }

                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                for (var i = 0; i <= 7; i++) {
                    if (i != 2) {
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
                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                for (var i = 0; i <= 2; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                for (var i = 3; i <= 7; i++) {
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
        var value = $("input[name='upload_option']:checked").val();
        var option = value != null && value.trim() != "" && value != "0" && value != 0;
        var db_option = "{{$banner->upload_option}}" == "1";

        if (db_option && option) {
            if ($("input[name='upload_file']").val() != null && $("input[name='upload_file']").val() != "") {
                if (window.FileReader && window.Blob) {
                    var input = document.getElementsByName('upload_file')[0].files[0];
                    if (input != null && input.size > 1024 * 1024) {
                        msg = msg.concat("<p>．@lang('validation.custom.upload_file.max',['attribute'=>Lang::get('ui.banner image')])</p>");
                    }
                }
            }

        } else if (db_option && !option) {
            if ($('input[name="img"]').val() == null || $('input[name="img"]').val().trim() == "") {
                msg = msg.concat("<p>．@lang('validation.custom.img.required')</p>");
            } else {
                if (!$('input[name="img"]').val().match(/^http([s]?):\/\/.*/)) {
                    msg = msg.concat("<p>．@lang('validation.custom.img.url')</p>");
                }
            }
        } else if (!db_option && option) {
            if ($("input[name='upload_file']").val() == null || $("input[name='upload_file']").val() == "") {
                msg = msg.concat("<p>．@lang('validation.custom.upload_file.required',['attribute'=>Lang::get('ui.banner image')])</p>");
            } else {
                if (window.FileReader && window.Blob) {
                    var input = document.getElementsByName('upload_file')[0].files[0];
                    if (input != null && input.size > 1024 * 1024) {
                        msg = msg.concat("<p>．@lang('validation.custom.upload_file.max',['attribute'=>Lang::get('ui.banner image')])</p>");
                    }
                }
            }
        } else {
            if ($('input[name="img"]').val() == null || $('input[name="img"]').val().trim() == "") {
                msg = msg.concat("<p>．@lang('validation.custom.img.required')</p>");
            } else {
                if (!$('input[name="img"]').val().match(/^http([s]?):\/\/.*/)) {
                    msg = msg.concat("<p>．@lang('validation.custom.img.url')</p>");
                }
            }
        }

        if ($('input[name="url"]').val() != null && $('input[name="url"]').val().trim() != "") {
            if (!$('input[name="url"]').val().match(/^http([s]?):\/\/.*/)) {
                msg = msg.concat("<p>．@lang('validation.custom.url.url',['attribute'=>Lang::get('ui.link')])</p>");
            }
        }

        if (msg != "") {
            message_show(msg);
        } else {
            document.getElementById('banner_id').submit();
        }
    }
</script>
</body>
</html>