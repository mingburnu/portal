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

                    @if(Session::get('success'))

                        <div class="message_print_ok">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr valign="top">
                                    <td class="message_text"><p>{{ Session::get('success') }}</p></td>
                                    <td class="message_close" valign="middle"><a href="javascript:void(0);"
                                                                                 onClick="message_print_ok_hide();">關閉</a>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    @endif

                    @if(Session::get('error'))

                        <div class="message_print_errer">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr valign="top">
                                    <td class="message_text"><p>{{ Session::get('error') }}</p></td>
                                    <td class="message_close" valign="middle"><a href="javascript:void(0);"
                                                                                 onClick="message_print_errer_hide();">關閉</a>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        @endif

                                <!-- message 區塊 End -->

                        <!-- 功能 區塊 Begin -->
                        <div class="func_box">
                            <a class="btn_02" href="{{ route('admin.add') }}">新增</a>
                        </div>
                        <!-- 功能 區塊 End -->


                        <!-- 瀏覽 區塊 Begin -->
                        <div class="browser_box">
                            <table width="100%" border="1" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>帳號</th>
                                    <th>權限身份</th>
                                    <th>是否封鎖</th>
                                    <th>備註</th>
                                    <th>建立時間</th>
                                    <th>修改時間</th>
                                    <th>功能</th>
                                </tr>

                                @if(count($user))

                                    @for($i = 0; $i < count($user); $i++)
                                        <tr>
                                            <td>{{ $user[$i]->email}}</td>

                                            @if($user[$i]->perm == 1)
                                                <td>最高管理者</td>
                                            @elseif($user[$i]->perm == 2)
                                                <td>一般管理者</td>
                                            @endif

                                            @if($user[$i]->lock == 1)
                                                <td>是</td>
                                            @elseif($user[$i]->lock == 0)
                                                <td>否</td>
                                            @endif

                                            @if($user[$i]->note)
                                                <td>{{ $user[$i]->note }}</td>
                                            @else
                                                <td>&nbsp;</td>
                                            @endif

                                            <td>{{ $user[$i]->created_at }}</td>
                                            <td>{{ $user[$i]->updated_at }}</td>
                                            <td>
                                                <a class="btn_03"
                                                   href="{{ $url = route('admin.broweser.id.delete', ['id' => $user[$i]->id ] ) }}">刪除</a>
                                                <a class="btn_02"
                                                   href="{{ $url = route('admin.edit', ['id' => $user[$i]->id ] ) }}">修改</a>
                                            </td>
                                        </tr>
                                    @endfor

                                @endif

                            </table>
                        </div>

                        <!-- 分頁 區塊 Begin -->
                        @include('layout.pagination',['table'=>$user])
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
</body>
</html>
