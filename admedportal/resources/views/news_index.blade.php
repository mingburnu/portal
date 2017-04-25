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

                    <!-- 功能 區塊 Begin -->
                    <div class="func_box">
                        <a class="btn_02" href="{{ route('news.create') }}">新增</a>
                    </div>
                    <!-- 功能 區塊 End -->


                    <!-- 瀏覽 區塊 Begin -->
                    <div class="browser_box">
                        <table width="100%" border="1" cellpadding="0" cellspacing="0">
                            <tr>
                                <th>公告時間</th>
                                <th>標題</th>
                                <th>是否顯示</th>
                                <th>功能</th>
                            </tr>

                            @foreach($table as  $i=>$row)
                                <tr>
                                    <td>{{ $row->publish_time }}</td>
                                    <td>{{ $row->title }}</td>

                                    @if( $row->view)
                                        <td>是</td>
                                    @else
                                        <td>否</td>
                                    @endif

                                    <td>
                                        {!! Form::open(['route' => ['news.destroy', $row->id], 'method' => 'delete']) !!}
                                        <a class="btn_03"
                                           onclick="del($(this).parent())">刪除</a>
                                        <a class="btn_02"
                                           href="{{ $url = route('news.edit', ['id' => $row->id ] )}}">修改</a>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>

                            @endforeach

                        </table>
                    </div>

                    <!-- 分頁 區塊 Begin -->
                    @include('layout.pagination')
                            <!-- 分頁 區塊 End -->
                    <!-- 瀏覽 區塊 End -->


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
    function del(form) {
        if (confirm('您確認要刪除該筆？')) {
            form.submit();
        } else {
            //
        }
    }
</script>
</body>
</html>
