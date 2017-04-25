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
                    <div class="message">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr valign="top">
                                <td class="message_text"></td>
                                <td class="message_close" valign="middle"><a href="javascript:void(0);"
                                                                             onClick="message_hide();">關閉</a></td>
                            </tr>
                        </table>
                    </div>
                    <!-- message 區塊 End -->


                    <!-- detail 區塊 Begin -->
                    <div class="detail_box">
                        <form>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>帳號</th>
                                    <td>{{ $user[0]->email }}</td>
                                </tr>
                                <tr>
                                    <th>密碼</th>
                                    <td>{{ $user[0]->password }}</td>
                                </tr>
                                <tr>
                                    <th>權限身份</th>
                                    @if( $user[0]->perm == 1 )
                                        <td>最高管理者</td>
                                    @elseif( $user[0]->perm == 2)
                                        <td>一般管理者</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>是否封鎖</th>
                                    @if( $user[0]->lock == 1 )
                                        <td>是</td>
                                    @elseif( $user[0]->lock == 0)
                                        <td>否</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>備註</th>
                                    <td>{{ $user[0]->note }}</td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02" href="javascript:history.go(-1);">返回</a>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <!-- detail 區塊 End -->


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