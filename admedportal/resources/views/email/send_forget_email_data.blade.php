<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $library_name[0]->site_name }}　@lang('ui.password email')</title>
</head>

<body>
<p style="font-size:15px;">@lang('ui.dear user')<BR/>
    @lang('ui.your account and password')<BR/><BR/>
    @lang('ui.account')：{{ $email }}<BR/>
    @lang('ui.password')：{{ $password }}<BR/>
</p>

<p>{{ $library_name[0]->site_name }} @lang('ui.please use')</p>

<div style="background:#eee; font-size:12px; margin:10px 0; padding:10px;">
    ※@lang('ui.system sends email automatically')<br/>
    ※@lang('ui.contact us through phone or email')
</div>

<div align="center" style="font-size:12px;">@lang('ui.footer copyright') Copyright ©Shou Yang Technology Co., Ltd.</div>
</body>
</html>

