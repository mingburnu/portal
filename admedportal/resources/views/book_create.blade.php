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
                        <form id="book_id" method="POST" action="{{route('book.store')}}" enctype="multipart/form-data">
                            {!! Form::open(['method' => 'POST','route'=>['book.store']]) !!}

                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>@lang('ui.book name')</th>
                                    <td>
                                        @foreach($languages as $language)
                                            @if($language->id==0)
                                                <h3>{{$language->language}} (&#8226;)</h3>

                                                <div>
                                                    {!! Form::text('book_name',null,['class'=>'v_01']) !!}
                                                </div>
                                            @else
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::text('book_i18ns['.$language->id.'][book_name]',null) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.book cover')(&#8226;)</th>
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
                                            ： {!! Form::text('cover',null,['class'=>'v_02']) !!}</div>
                                        <div class="note_txt">@lang('ui.frontend automatic resize')</div>
                                        <div class="note_txt">@lang('ui.max upload size')</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.link')(&#8226;)</th>
                                    <td>{!! Form::text('url',null,['class'=>'v_03']) !!}

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
        var option = value != null && value.trim() !== "" && value !== "0" && value !== 0;
        if (option) {
            chgShowField("group_02", "pic");
        } else {
            chgShowField("group_02", "url");
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

                for (i = 1; i <= 5; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                btn0.hide();
                btn1.show();
                btn2.hide();
                break;

            case 2:
                var book_name_ch = $("input[name='book_name']").val();

                if (book_name_ch == null || book_name_ch.trim() === "") {
                    message_show("<p>．@lang('validation.custom.book_name.required',['attribute'=>$languages[0]->language.'-'.Lang::get('ui.book name')])</p>");
                    break;
                }

                start(s);

                for (i = 0; i <= 5; i++) {
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
        var input = document.getElementsByName('upload_file')[0].files[0];
        var upload_file = $("input[name='upload_file']");
        var cover = $('input[name="cover"]');
        var url = $('input[name="url"]');

        if (option) {
            if (upload_file.val() == null || upload_file.val() === "") {
                msg = msg.concat("<p>．@lang('validation.custom.upload_file.required',['attribute'=>Lang::get('ui.book cover')])</p>");
            } else {
                if (window.FileReader && window.Blob) {
                    if (input != null && input.size > 1024 * 1024) {
                        msg = msg.concat("<p>．@lang('validation.custom.upload_file.max',['attribute'=>Lang::get('ui.book cover')])</p>");
                    }
                }
            }

        } else {
            if (cover.val() == null || cover.val().trim() === "") {
                msg = msg.concat("<p>．@lang('validation.custom.cover.required')</p>");
            } else {
                if (!cover.val().match(/^http([s]?):\/\/.*/)) {
                    msg = msg.concat("<p>．@lang('validation.custom.cover.url')</p>");
                }
            }
        }

        if (url.val() == null || url.val().trim() === "") {
            msg = msg.concat("<p>．@lang('validation.custom.url.required',['attribute'=>Lang::get('ui.link')])</p>");
        } else {
            if (!url.val().match(/^http([s]?):\/\/.*/)) {
                msg = msg.concat("<p>．@lang('validation.custom.url.url',['attribute'=>Lang::get('ui.link')])</p>");
            }
        }

        if (msg !== "") {
            message_show(msg);
        } else {
            document.getElementById('book_id').submit();
        }
    }
</script>
</body>
</html>