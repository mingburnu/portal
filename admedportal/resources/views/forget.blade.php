<!DOCTYPE html>
<html lang="zh-tw">
@include('layout.head')

<body>
<div class="wrapper">
<!-- message 區塊 Begin -->
@include('layout.message')
<!-- message 區塊 End -->

<!-- forget 區塊 Begin -->

<div class="forget">
<form id="forget" method="POST" action="/forget/post">
<table width="300" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr valign="middle">
    <th colspan="2"><img src="{{ asset('templates/images/login_header.png') }}" width="300" height="45"></th>
  </tr>
  <tr valign="middle">
    <td align="right">@lang('ui.your email')</td>
    <td align="left"><input class="v_email" type="text" name="email"></td>
  </tr>

  <input type="hidden" name="_token" value="{{ csrf_token() }}">  

  <tr valign="middle">
    <td colspan="2">
        <div class="forget_bottom">
        <a class="btn_01" onClick="document.getElementById('forget').submit();"><span>@lang('ui.submit')</span></a>
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
