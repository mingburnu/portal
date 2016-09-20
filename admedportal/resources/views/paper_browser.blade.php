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
                            @if (count($menus) > 0)
                                @foreach ($menus as $menu)
                                    @include('layout.tree', $menu)
                                @endforeach
                            @else
                                @include('layout.tree')
                            @endif
                            </tbody>
                        </table>
                    </div>

                    {!! $menus->render() !!}

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
</body>
</html>

