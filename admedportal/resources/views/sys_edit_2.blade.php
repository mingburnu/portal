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
                            <span class="active">2</span>
                            <span>3</span>
                            <span>4</span>
                            <span>5</span>
                        </div>

                        <form id="webconfig" method="POST" action="/sys_edit_2/next">
                            {!! Form::model($webconfig[0],['method' => 'POST','route'=>['sys.edit.2.next']]) !!}
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <th>網站名稱</th>
                                    <td>
                                        <h3>繁體中文 (•)</h3>

                                        <div>
                                            {!! Form::text('site_name_ch',null,['class'=>'v_01']) !!}
                                        </div>
                                        <h3>简体中文</h3>

                                        <div>
                                            {!! Form::text('site_name_cn',null,['class'=>'v_01']) !!}
                                        </div>
                                        <h3>English</h3>

                                        <div>
                                            {!! Form::text('site_name_en',null,['class'=>'v_01']) !!}
                                        </div>
                                        <h3>日本語</h3>

                                        <div>
                                            {!! Form::text('site_name_jp',null,['class'=>'v_01']) !!}
                                        </div>
                                        <h3>한국어</h3>

                                        <div>
                                            {!! Form::text('site_name_kr',null,['class'=>'v_01']) !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02" href="/sys_edit">上一步</a>
                                        <a class="btn_02" href="javascript:void(0);"
                                           onclick="document.getElementById('webconfig').submit();">下一步</a>
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
