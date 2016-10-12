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
                                    <th>語言設定</th>
                                    <td>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <th>語言</th>
                                                <th>前端顯示</th>
                                                <th>排序</th>
                                            </tr>
                                            @foreach($languages as $language)
                                                <tr>
                                                    @if($language->id==0)
                                                        <td>繁體中文(必選)</td>
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
                                            前台顯示欄位：如欲顯示則需打勾選。<BR>
                                            排序欄位：數字愈大，順序愈前面。<BR>
                                            排序數字最大而且前台顯示也打勾選的語系即是預設語系。
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02" href="javascript:void(0);"
                                           onclick="document.getElementById('webconfig').submit();">下一步</a>
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
