<!DOCTYPE html>
<html lang="zh-tw">
@include('layout.head')
<body>
<div class="wrapper">
    <!-- message 區塊 Begin -->
    @include('layout.message')
            <!-- message 區塊 End -->


    <!-- 登入 區塊 Begin -->
    <div class="login">
        <form id="demo" method="POST" action="/auth/login">
            <table width="300" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr valign="middle">
                    <th colspan="2"><img src="{{ asset('templates/images/login_header.png') }}" width="300" height="45">
                    </th>
                </tr>
                <tr valign="middle">
                    <td align="right">@lang('ui.your account')</td>
                    <td align="left"><input class="v_username" name="email" type="text"></td>
                </tr>
                <tr valign="middle">
                    <td align="right">@lang('ui.your password')</td>
                    <td align="left"><input class="v_password" name="password" type="password"></td>
                </tr>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <tr valign="middle">
                    <td colspan="2">
                        <div class="login_bottom">
                            <a class="btn_01"
                               onclick="document.getElementById('demo').submit();"><span>@lang('ui.login')</span></a>
                            <a class="btn_01" href="{{ route('forget') }}"><span>@lang('ui.forget password')
                                    ?</span></a>
                        </div>
                    </td>
                </tr>
            </table>
        </form>

        <div class="login_footer">@lang('ui.footer copyright')<BR/>Copyright &copy; Shou Yang Technology Co., Ltd.</div>

    </div>

    <!-- 登入 區塊 End -->

</div>


<!-- 執行javascript 區塊 Begin -->
@include('layout.javascript')
        <!-- 執行javascript 區塊 End -->
</body>
</html>
