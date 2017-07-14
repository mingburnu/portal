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
                            <span>3</span>
                            <span>4</span>
                            <span class="active">5</span>
                        </div>
                        <form id="webconfig" method="POST" enctype="multipart/form-data"
                              action="{{route('sys.edit.5.post')}}">
                            {!! Form::model($webconfig[0],['method' => 'POST','route'=>['sys.edit.5.post']]) !!}
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <th>@lang('ui.system email')(•)</th>
                                    <td>
                                        {!! Form::text('email',null,['class'=>'v_01']) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.ico image')</th>
                                    <td><a target="_blank" href="{{ asset('img/favicon.ico') }}">@lang('ui.view image')</a><BR/>
                                        {!! Form::file('ico') !!}
                                        <div class="note_txt">@lang('ui.better image size',['width'=>'128','height'=>'128'])</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.layout color')</th>
                                    <td>
                                        @for($i=1;$i<=7;$i++)
                                            <label>
                                                {!! Form::radio('color','S'.$i) !!}
                                                <img src="{{ asset('templates/images/style_S'.$i.'.png') }}"
                                                     width="60" height="35"></label>&nbsp;&nbsp;
                                        @endfor
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.banner display')</th>
                                    <td>
                                        <label>{!! Form::radio('play',true) !!}@lang('ui.true')</label>
                                        <label>{!! Form::radio('play',false) !!}@lang('ui.false')</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.book display')</th>
                                    <td>
                                        <label>{!! Form::radio('exhibition',true) !!}@lang('ui.true')</label>
                                        <label>{!! Form::radio('exhibition',false) !!}@lang('ui.false')</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.note')</th>
                                    <td>
                                        {!! Form::textarea('note',null,['rows'=>'5']) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02" href="{{route('sys.edit.4')}}">@lang('ui.previous step')</a>
                                        <a class="btn_02" href="javascript:void(0);"
                                           onclick="document.getElementById('webconfig').submit();">@lang('ui.accomplish')</a>
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
                        <div class="detail_note_content"><span class="required">(&#8226;)</span>@lang('ui.required field')</div>
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
</body>
</html>
