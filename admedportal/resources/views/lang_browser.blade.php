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

                    <!-- 瀏覽 區塊 Begin -->
                    <div class="browser_box">
                        <table width="100%" border="1" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                @foreach($languages as $language)
                                    <th>{{$language->language}}</th>
                                @endforeach
                                <th>功能</th>
                            </tr>
                            <tr>
                                @foreach($languages as $language)
                                    <td>{{$language->home}}</td>
                                @endforeach
                                <td><a class="btn_02" href="">修改</a></td>
                            </tr>
                            <tr>
                                @foreach($languages as $language)
                                    <td>{{$language->location}}</td>
                                @endforeach
                                <td><a class="btn_02" href="">修改</a></td>
                            </tr>
                            <tr>
                                @foreach($languages as $language)
                                    <td>{{$language->query}}</td>
                                @endforeach
                                <td><a class="btn_02" href="">修改</a></td>
                            </tr>
                            <tr>
                                @foreach($languages as $language)
                                    <td>{{$language->newest}}</td>
                                @endforeach
                                <td><a class="btn_02" href="">修改</a></td>
                            </tr>
                            <tr>
                                @foreach($languages as $language)
                                    <td>{{$language->more}}</td>
                                @endforeach
                                <td><a class="btn_02" href="">修改</a></td>
                            </tr>
                            <tr>
                                @foreach($languages as $language)
                                    <td>{{$language->visitor}}</td>
                                @endforeach
                                <td><a class="btn_02" href="">修改</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

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