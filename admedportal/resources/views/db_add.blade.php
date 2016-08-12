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
<div class="message">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td class="message_text"></td>
    <td class="message_close" valign="middle"><a href="javascript:void(0);" onClick="message_hide();">關閉</a></td>
  </tr>
</table>
</div>
<!-- message 區塊 End -->




<!-- detail 區塊 Begin -->
<div class="detail_box">
<form id="database_id" method="POST" action="/db_add/post">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th>資料庫名稱(&#8226;)</th>
    <td><input class="v_01" type="text" name="database_name"></td>
  </tr>
  <tr>
    <th>嵌入語法(&#8226;)</th>
    <td><textarea class="v_02" cols="80" rows="10" name="syntax"></textarea></td>
  </tr>
  <tr>
    <th>是否顯示</th>
    <td>
      <label><input type="radio" name="view" value="1" checked>是</label>
      <label><input type="radio" name="view" value="0">否</label>
      </td>
  </tr>
  <tr>
    <th>排序</th>
    <td><input type="text" class="v_00" name="rank_id">
    <div class="note_txt">數字愈大，順序愈前面。</div>
    </td>
  </tr>
  <tr>
    <th>備註</th>
    <td><textarea rows="5" name="note"></textarea></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>
    <a class="btn_02" href="javascript:history.go(-1);">返回</a>
    <a class="btn_02" onClick="document.getElementById('database_id').submit();">送出</a>
    </td>
  </tr>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

</table>
</form>
</div>
<!-- detail 區塊 End -->

<!-- Note 區塊 Begin -->
<div class="detail_note">
    <div class="detail_note_title">Note</div>
    <div class="detail_note_content"><span class="required">(&#8226;)</span>為必填欄位</div>
</div>
<!-- Note 區塊 End -->

<!-- 內容 區塊 End -->
    </td>
  </tr>
</table>
</div>

<div class="footer">本系統由碩陽數位科技有限公司 版權所有  Copyright &copy; Shou Yang Technology Co., Ltd.</div>

</div>


<!-- 執行javascript 區塊 Begin -->
<script src="templates/jquery-1.11.3.min.js"></script>
<script src="templates/art.js"></script>
<!-- 執行javascript 區塊 End -->
</body>
</html>
