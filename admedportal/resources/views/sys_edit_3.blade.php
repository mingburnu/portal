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
                            <span>1</span>
                            <span>2</span>
                            <span class="active">3</span>
                            <span>4</span>
                            <span>5</span>
                        </div>
                        <form id="webconfig" method="POST" enctype="multipart/form-data" action="/sys_edit_3/next">
                            {!! Form::open(['method' => 'POST','route'=>['sys.edit.3.next']]) !!}
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <th>@lang('ui.logo image')</th>
                                    <td>
                                        @foreach($languages as $language)
                                            <h3>{{$language->language}}</h3>

                                            <div>
                                                @if($language->id==0)
                                                    <a target="_blank"
                                                       href="{{ asset('img/logo.png') }}">@lang('ui.view image')</a>
                                                    <BR/>
                                                    {!! Form::file('logo',['accept'=>'image/*'])!!}
                                                @else
                                                    <a target="_blank"
                                                       href="{{ asset('img/logo_'.$language->id.'.png') }}">@lang('ui.view image')</a>
                                                    <BR/>
                                                    {!! Form::file($language->id.'_logo',['accept'=>'image/*'])!!}
                                                @endif
                                            </div>
                                        @endforeach

                                        <div class="note_txt">@lang('ui.better image size',['width'=>'900','height'=>'130'])</div>
                                        <div class="note_txt">@lang('ui.max upload size')</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02" href="/sys_edit_2">@lang('ui.previous step')</a>
                                        <a class="btn_02" href="javascript:void(0);"
                                           onclick="submit()">@lang('ui.next step')</a>
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
    function submit() {
        var msg = "";
            @foreach($languages as $language)
                @if ($language->id ==0)
                    var input = document.getElementsByName('logo')[0].files[0];
                        if (input != null && input.size > 1024 * 1024) {
                            msg = msg.concat("<p>．@lang('validation.custom.logo.max',['attribute'=>$language->language.'-'.\Lang::get('ui.logo image')])</p>");
                        }
                @else
                    var input_{{$language->id}}    = document.getElementsByName('{{$language->id}}_logo')[0].files[0];
                        if (input_{{$language->id}} != null && input_{{$language->id}}.size > 1024 * 1024) {
                            msg = msg.concat("<p>．@lang('validation.custom.logo.max',['attribute'=>$language->language.'-'.\Lang::get('ui.logo image')])</p>");
                    }
                @endif
            @endforeach

        if (msg != "") {
            message_show(msg);
        } else {
            document.getElementById('webconfig').submit();
        }
    }

    function isImage() {
        var URL = window.URL || window.webkitURL;
        var input = document.getElementsByName('logo');
        var file = input[0].files[0];

        if (file) {
            var image = new Image();
            image.onload = function () {
                alert(true);
            };

            image.src = URL.createObjectURL(file);
        }

    }
</script>
</body>
</html>
