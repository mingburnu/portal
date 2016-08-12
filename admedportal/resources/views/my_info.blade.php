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

<div class="header">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="middle">
    <td width="170" style="background:#ed6c44;"><img src="{{ asset('templates/images/logo.png') }}" width="170" height="60"></td>
    <td align="right">
    <div class="header_func"><span>
    <a href="{{ route('my.info') }}">我的個人資訊</a>
    <a href="{{ route('logout.process') }}">登出</a>
    </span></div>
    </td>
  </tr>
</table>
</div>

<div class="box">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td class="td_1">
<!-- menu 區塊 Begin -->
<div class="menu">

<div class="menu_box">
<div class="title">平台設定</div>
@if(Auth::user()->perm == 1)
    <a class="menu_A" href="{{ route('admin.browser') }}">帳號管理</a>
    <a class="menu_B" href="{{ route('sys.edit') }}">網站設定</a>
@endif
<a class="menu_C" href="{{ route('db.browser') }}">查詢資料庫管理</a>
<a class="menu_D" href="{{ route('books.browser') }}">書籍管理</a>
<a class="menu_E" href="{{ route('news.browser') }}">公告管理</a>
<a class="menu_F" href="{{ route('paper.browser') }}">網頁管理</a>
</div>

<div class="menu_box">
<div class="title">統計資訊</div>
<a class="menu_list" href="{{ route('state.A') }}">後台登入次數統計</a>
<a class="menu_list" href="{{ route('state.C') }}">各網頁登入次數統計</a>
</div>

</div>
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
    <td class="message_close" valign="middle"><a href="javascript:void(0);" onClick="message_print_ok_hide();">關閉</a></td>
  </tr>
</table>
</div>

@endif

<!-- message 區塊 End -->

<!-- detail 區塊 Begin -->
<div class="detail_box">
<form id="my_info_edit" enctype="multipart/form-data" method="POST" action="/my_info/edit">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

    <tr>
        <th>帳號</th>
        <td>{{ $email }}</td>
    </tr>

    <tr>

        <th>權限身份</th>

        @if($perm == 1)
            <td>最高管理者</td>
        @elseif($perm == 2)
            <td>一般管理者</td>
        @endif

    </tr>

    <tr>
        <th>密碼</th>
        <td><input class="v_01" type="text" name="password"></td>
    </tr>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

  <tr>
    <th>&nbsp;</th>
    <td>
    <a class="btn_02" onClick="document.getElementById('my_info_edit').submit();">更新</a>
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

<div class="footer">本系統由碩陽數位科技有限公司 版權所有  Copyright &copy; Shou Yang Technology Co., Ltd.</div>

</div>


<!-- 執行javascript 區塊 Begin -->
<script src="{{ asset('templates/jquery-1.11.3.min.js') }}"></script>
<script src="{{ asset('templates/art.js') }}"></script>
<!-- 執行javascript 區塊 End -->
</body>
</html>
