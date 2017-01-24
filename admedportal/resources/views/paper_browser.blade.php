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
                        <a class="btn_02" href="{{ route('paper.add') }}">新增</a>
                    </div>
                    <!-- 功能 區塊 End -->


                    <!-- 瀏覽 區塊 Begin -->
                    <div class="browser_box">
                        <table width="100%" border="1" cellpadding="0" cellspacing="0">
                            <thead>
                            <tr>
                                <th>標題</th>
                                <th>是否顯示</th>
                                <th>排序</th>
                                <th>建立時間</th>
                                <th>修改時間</th>
                                <th>功能</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($menus as $menu)
                                <tr>
                                    <td>
                                        @for($i=0;$i<$menu[2];$i++)
                                            └
                                        @endfor
                                        {{$menu[3]}}
                                    </td>
                                    <td>@if($menu[4])
                                            是
                                        @else
                                            否
                                        @endif
                                    </td>
                                    <td>{{$menu[5]}}</td>
                                    <td>{{$menu[6]}}</td>
                                    <td>{{$menu[7]}}</td>
                                    <td>
                                        <a class="btn_03"
                                           onclick="del('{{ $url = route('paper.browser.id.delete', ['id' => $menu[1] ] ) }}')">刪除</a>
                                        <a class="btn_02"
                                           href="{{ $url = route('paper.edit.id', ['id' => $menu[1] ] )}}">修改</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($totalPage > 1)
                        <ul class="pagination">
                            @if($page==1)
                                <span>«</span>
                            @else
                                <a href="{{ route('paper.browser') }}/?page={{$page-1}}" rel="prev">«</a>
                            @endif

                            @for($p=1;$p<=$totalPage;$p++)
                                @if($page==$p)
                                    <span>{{$p}}</span>
                                @else
                                    <a href="{{ route('paper.browser') }}/?page={{$p}}">{{$p}}</a>
                                @endif
                            @endfor

                            @if($page==$totalPage)
                                <span>»</span>
                            @else
                                <a href="{{ route('paper.browser') }}/?page={{$page+1}}" rel="prev">»</a>
                            @endif
                        </ul>
                        @endif

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
    function del(url) {
        if (confirm('您確認要刪除該筆？')) {
            location.href = url;
        } else {
            //
        }
    }
</script>
</body>
</html>

