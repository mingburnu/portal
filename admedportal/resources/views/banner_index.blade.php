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

                    <div class="func_box">
                        <a class="btn_02" href="{{route('banner.create')}}">新增</a>
                    </div>

                    <!-- 瀏覽 區塊 Begin -->
                    <div class="browser_box">
                        <table width="100%" border="1" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <th>Banner圖片</th>
                                <th>Banner標題</th>
                                <th>連結</th>
                                <th>是否顯示</th>
                                <th>排序<a href="{{route('banner.sort')}}"><i class="{{$direction}}"></i></a></th>
                                <th>建立時間</th>
                                <th>修改時間</th>
                                <th>功能</th>
                            </tr>

                            @foreach($table as  $i=>$row)
                                <tr>
                                    <td>
                                        <img class="browser_img_2" src="{{ asset($row->img) }}">
                                    </td>
                                    <td>{{$row->title}}</td>
                                    <td><a>連結</a></td>
                                    <td>
                                        @if($row->play)
                                            是
                                        @else
                                            否
                                        @endif
                                    </td>
                                    <td>{{$row->rank_id}}</td>
                                    <td>{{ $row->created_at }}</td>
                                    <td>{{ $row->updated_at }}</td>
                                    <td>
                                        {!! Form::open(['route' => ['banner.destroy', $row->id], 'method' => 'delete']) !!}
                                        <a class="btn_03"
                                           onclick="del($(this).parent())">刪除</a>
                                        <a class="btn_02"
                                           href="{{ $url = route('banner.edit', ['id' => $row->id ]) }}">修改</a>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
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