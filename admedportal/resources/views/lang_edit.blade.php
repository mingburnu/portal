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
                        <form id="lang_edit" method="POST" action="/lang_edit/{{$label}}">
                            {!! Form::model($row,['method' => 'PATCH','route'=>['lang.edit.post',$label]]) !!}
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                @foreach($languages as $i=>$language)
                                    <tr>
                                        @if($language->id==0)
                                            <th>{{$language->language}} (&#8226;)</th>
                                        @else
                                            <th>{{$language->language}}</th>
                                        @endif
                                        <td>
                                            {!! Form::text($i.'_title',$row[$i]) !!}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>最後修改時間</th>
                                    <td>
                                        @if(sizeof($record)!=0)
                                            {{$record[0]->updated_at}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02" href="javascript:void(0);" onclick="form_submit();">更新</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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

<script>
    function form_submit() {
        document.getElementById('lang_edit').submit();
    }
</script>
</body>
</html>