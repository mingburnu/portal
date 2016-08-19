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
                            <span class="title">步驟</span>
                            <span>1</span>
                            <span>2</span>
                            <span>3</span>
                            <span>4</span>
                            <span class="active">5</span>
                        </div>
                        <form id="webconfig" method="POST" enctype="multipart/form-data" action="/sys_edit_5/post">
                            {!! Form::model($webconfig[0],['method' => 'POST','route'=>['sys.edit.5.post']]) !!}
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <th>系統管理電子信箱(•)</th>
                                    <td>
                                        {!! Form::text('email',null,['class'=>'v_01']) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ico圖</th>
                                    <td><a target="_blank" href="{{ asset('img/favicon.ico') }}">檢視圖檔</a><BR/>
                                        {!! Form::file('ico') !!}
                                        <div class="note_txt">圖檔尺寸大小不限，以128px X 128px為佳。</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>版面配色</th>
                                    <td><label>
                                            {!! Form::radio('color','S1') !!}
                                            <img src="{{ asset('templates/images/style_S1.png') }}"
                                                 width="60" height="35"></label>&nbsp;&nbsp;
                                        <label>{!! Form::radio('color','S2') !!}
                                            <img src="{{ asset('templates/images/style_S2.png') }}"
                                                 width="60" height="35"></label>&nbsp;&nbsp;
                                        <label>{!! Form::radio('color','S3') !!}
                                            <img src="{{ asset('templates/images/style_S3.png') }}"
                                                 width="60" height="35"></label>&nbsp;&nbsp;
                                        <label>{!! Form::radio('color','S4') !!}
                                            <img src="{{ asset('templates/images/style_S4.png') }}"
                                                 width="60" height="35"></label>&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>備註</th>
                                    <td>
                                        {!! Form::textarea('note',null,['rows'=>'5']) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02" href="/sys_edit_4">上一步</a>
                                        <a class="btn_02" href="javascript:void(0);"
                                           onclick="document.getElementById('webconfig').submit();">完成</a>
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
                        <div class="detail_note_content"><span class="required">(&#8226;)</span>為必填欄位</div>
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
