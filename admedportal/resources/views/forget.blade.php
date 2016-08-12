<!DOCTYPE html>
<html lang="zh-tw">
<head>
<meta charset="utf-8">
<meta http-equiv="expires" content="0">
<title>圖書館管理後台</title>
<link rel="stylesheet" href="{{ asset('templates/art.css') }}">
</head>

<body>
<div class="wrapper">
<!-- message 區塊 Begin -->
<div class="message">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td class="message_text"></td>
    <td class="message_close" valign="middle"><a href="javascript:void(0);" onClick="message_hide();">關閉</a></td>
  </tr>
</table>
</div>
<!-- message 區塊 End -->

<!-- forget 區塊 Begin -->

<div class="forget">
<form id="forget" method="POST" action="/forget/post">
<table width="300" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr valign="middle">
    <th colspan="2"><img src="{{ asset('templates/images/login_header.png') }}" width="300" height="45"></th>
  </tr>
  <tr valign="middle">
    <td align="right">您的電子信箱</td>
    <td align="left"><input class="v_email" type="text" name="email"></td>
  </tr>

  <input type="hidden" name="_token" value="{{ csrf_token() }}">  

  <tr valign="middle">
    <td colspan="2">
        <div class="forget_bottom">
        <a class="btn_01" onClick="document.getElementById('forget').submit();"><span>送出</span></a>
        <a class="btn_01" href="{{ route('login.index') }}"><span>返回登入頁</span></a>
        </div>
    </td>
    </tr>
</table>
</form>

<div class="login_footer">本系統由碩陽數位科技有限公司 版權所有<BR />Copyright &copy; Shou Yang Technology Co., Ltd.</div>

</div>

<!-- forget 區塊 End -->

</div>


<!-- 執行javascript 區塊 Begin -->
<script src="{{ asset('templates/jquery-1.11.3.min.js') }}"></script>
<script src="{{ asset('templates/art.js') }}"></script>
<!-- 執行javascript 區塊 End -->
</body>
</html>
