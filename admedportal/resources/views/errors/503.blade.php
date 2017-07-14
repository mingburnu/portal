<!DOCTYPE html>
<html lang="zh-tw">
<head>
<meta charset="utf-8">
<meta http-equiv="expires" content="0">
<title>圖書館管理後台</title>
<link rel="stylesheet" href="{{ asset('templates/art.css') }}">
</head>

<body>
<!-- message 區塊 Begin -->
<div class="pager_404" align="center">
<table border="0" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td>
    <div><img src="{{ asset('templates/images/404.png') }}"></div>
    <div class="txt_01">
@lang('ui.not found')<BR />
@lang('ui.link error or forbidden')<BR />
@lang('ui.go back or contact customer support')<BR />
    </div>
    
    <div class="txt_02">
@lang('ui.customer support center')<BR />
<a href="http://www.customer-support.com.tw" target="_blank">http://www.customer-support.com.tw</a><BR />
@lang('ui.customer support phone') 02-82280288 ext. 3015<BR />
@lang('ui.customer support email') services@customer-support.com.tw
    </div>
    <div><a class="btn_04" href="javascript:history.go(-1);">@lang('ui.go back previous page')</a></div>
    </td>
  </tr>
</table>
</div>
<!-- message 區塊 End -->

</body>
</html>
