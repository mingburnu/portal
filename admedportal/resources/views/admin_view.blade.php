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
                                    <th>@lang('ui.account')</th>
                                    <td>{{ $user[0]->email }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.password')</th>
                                    <td>{{ $user[0]->password }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.permission')</th>
                                    @if( $user[0]->perm == 1 )
                                        <td>@lang('ui.administrator')</td>
                                    @elseif( $user[0]->perm == 2)
                                        <td>@lang('ui.standard user')</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>@lang('ui.blockade')</th>
                                    @if( $user[0]->lock == 1 )
                                        <td>@lang('ui.true')</td>
                                    @elseif( $user[0]->lock == 0)
                                        <td>@lang('ui.false')</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>@lang('ui.note')</th>
                                    <td>{{ $user[0]->note }}</td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02" href="javascript:history.go(-1);">@lang('ui.back')</a>
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