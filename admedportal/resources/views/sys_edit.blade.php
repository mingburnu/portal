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
                            <span>4</span>
                            <span>5</span>
                        </div>
                        <form id="webconfig" method="POST" action="/sys_edit/next">
                            {!! Form::open(['method' => 'POST','route'=>['sys.edit.next']]) !!}
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>@lang('ui.language settings')</th>
                                    <td>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <th>@lang('ui.language')</th>
                                                <th>@lang('ui.frontend display')</th>
                                                <th>@lang('ui.sort')</th>
                                            </tr>
                                            @foreach($languages as $language)
                                                <tr>
                                                    @if($language->id==0)
                                                        <td>{{$language->name}}(@lang('ui.required'))</td>
                                                        <td><input type="checkbox" checked disabled></td>
                                                        <td>{!! Form::text('sort',$language->sort,['class'=>'v_01','style'=>'width:50px;']) !!}</td>
                                                    @else
                                                        <td>{{ $language->name.'('.$language->language.')'}}</td>
                                                        <td>{!! Form::checkbox($language->id.'_display', true , (boolean)$language->display) !!}</td>
                                                        <td>{!! Form::text($language->id.'_sort',$language->sort,['class'=>'v_01','style'=>'width:50px;']) !!}</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </table>
                                        <div class="note_txt">
                                            @lang('ui.frontend display field')<BR>
                                            @lang('ui.sort field')<BR>
                                            @lang('ui.sort tip')
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02" href="javascript:void(0);"
                                           onclick="document.getElementById('webconfig').submit();">@lang('ui.next step')</a>
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
                        <div class="detail_note_content"><span class="required">(&#8226;)</span>@lang('ui.required field')
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
</body>
</html>
