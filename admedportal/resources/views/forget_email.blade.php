<!DOCTYPE html>
<html lang="zh-tw">
@include('layout.head')

<body>
<div class="wrapper">
<!-- message 區塊 Begin -->
@include('layout.message')
<!-- message 區塊 End -->

<!-- forget 區塊 Begin -->

<div class="login_msg">
<form>
<table width="300" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr valign="middle">
    <th><img src="{{ asset('templates/images/login_header.png') }}" width="300" height="45"></th>
  </tr>
  <tr>
    <td><p>@lang('ui.your email') {{ $email }}<BR />@lang('ui.system send password email')</p></td>
  </tr>
  <tr valign="middle">
    <td>
        <div class="login_msg_bottom">
        <a class="btn_01" href="{{ route('login.index') }}"><span>@lang('ui.back login')</span></a>
        </div>
    </td>
    </tr>
</table>
</form>

<div class="login_footer">@lang('ui.footer copyright')<BR />Copyright &copy; Shou Yang Technology Co., Ltd.</div>

</div>

<!-- forget 區塊 End -->

</div>


<!-- 執行javascript 區塊 Begin -->
@include('layout.javascript')
<!-- 執行javascript 區塊 End -->
</body>
</html>
