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
                        <form id="book_id" method="POST" action="{{route('book.update',['id'=>$book->id])}}"
                              enctype="multipart/form-data">
                            {!! Form::model($book,['method' => 'PATCH','route'=>['book.update',$book->id]]) !!}

                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>@lang('ui.book name')</th>
                                    <td>
                                        @foreach($languages as $language)
                                            @if($language->id==0)
                                                <h3>{{$language->language}} (&#8226;)</h3>

                                                <div>
                                                    {!! Form::text('book_name',$book->book_name,['cols'=>'80','rows'=>'10','class'=>'v_01']) !!}
                                                </div>
                                            @else
                                                <?php
                                                $i18n_bkName = null;
                                                foreach ($book->book_i18ns as $i18n_bk) {
                                                    if ($language->id == $i18n_bk->language) {
                                                        $i18n_bkName = $i18n_bk->book_name;
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::text('book_i18ns['.$language->id.'][book_name]',$i18n_bkName,['cols'=>'80','rows'=>'10','class'=>'v_01']) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.book cover')(&#8226;)</th>
                                    <td>
                                        <img class="bookcover" src="{{ asset($book->cover) }}"><BR/>

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
                                            @lang('ui.image url')： {!! Form::text('cover',null) !!}</div>
                                        <div class="note_txt">@lang('ui.frontend automatic resize')</div>
                                        <div class="note_txt">@lang('ui.max upload size')</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.link')(&#8226;)</th>
                                    <td>{!! Form::text('url',null) !!}

                                        <div class="note_txt">@lang('ui.url format')：</div>
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
                                    <td>{!! Form::text('rand_id',null,['class'=>'v_00']) !!}

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
        for (var i = 1; i <= 5; i++) {
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
                for (var i = 1; i <= 5; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                $("div.message").hide();
                $("a.btn_02:eq(0)").hide();
                $("a.btn_02:eq(1)").show();
                $("a.btn_02:eq(2)").hide();
                break;

            case 2:
                if ($("span.active").html() == "1") {
                    var book_name_ch = $("input[name='book_name']").val()
                    if (book_name_ch == null || book_name_ch.trim() == "") {
                        message_show("<p>．@lang('validation.custom.book_name.required',['attribute'=>$languages[0]->language.'-'.Lang::get('ui.book name')])</p>");
                        break;
                    }
                }

                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                for (var i = 0; i <= 0; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                for (var i = 1; i <= 5; i++) {
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
        var db_option = "{{$book->upload_option}}" == "1";

        if (db_option && option) {
            if ($("input[name='upload_file']").val() != null && $("input[name='upload_file']").val() != "") {
                if (window.FileReader && window.Blob) {
                    var input = document.getElementsByName('upload_file')[0].files[0];
                    if (input != null && input.size > 1024 * 1024) {
                        msg = msg.concat("<p>．@lang('validation.custom.upload_file.max',['attribute'=>Lang::get('ui.book cover')])</p>");
                    }
                }
            }
        } else if (db_option && !option) {
            if ($('input[name="cover"]').val() == null || $('input[name="cover"]').val().trim() == "") {
                msg = msg.concat("<p>．@lang('validation.custom.cover.required')</p>");
            } else {
                if (!$('input[name="cover"]').val().match(/^http([s]?):\/\/.*/)) {
                    msg = msg.concat("<p>．@lang('validation.custom.cover.url')</p>");
                }
            }
        } else if (!db_option && option) {
            if ($("input[name='upload_file']").val() == null || $("input[name='upload_file']").val() == "") {
                msg = msg.concat("<p>．@lang('validation.custom.upload_file.required',['attribute'=>Lang::get('ui.book cover')])</p>");
            } else {
                if (window.FileReader && window.Blob) {
                    var input = document.getElementsByName('upload_file')[0].files[0];
                    if (input != null && input.size > 1024 * 1024) {
                        msg = msg.concat("<p>．@lang('validation.custom.upload_file.max',['attribute'=>Lang::get('ui.book cover')])</p>");
                    }
                }
            }
        } else {
            if ($('input[name="cover"]').val() == null || $('input[name="cover"]').val().trim() == "") {
                msg = msg.concat("<p>．@lang('validation.custom.cover.required')</p>");
            } else {
                if (!$('input[name="cover"]').val().match(/^http([s]?):\/\/.*/)) {
                    msg = msg.concat("<p>．@lang('validation.custom.cover.url')</p>");
                }
            }
        }

        if ($('input[name="url"]').val() == null || $('input[name="url"]').val().trim() == "") {
            msg = msg.concat("<p>．@lang('validation.custom.url.required',['attribute'=>Lang::get('ui.link')])</p>");
        } else {
            if (!$('input[name="url"]').val().match(/^http([s]?):\/\/.*/)) {
                msg = msg.concat("<p>．@lang('validation.custom.url.url',['attribute'=>Lang::get('ui.link')])</p>");
            }
        }

        if (msg != "") {
            message_show(msg);
        } else {
            document.getElementById('book_id').submit();
        }
    }
</script>
</body>
</html>