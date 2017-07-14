<!DOCTYPE html>
<html lang="zh-tw">
<head>
<meta charset="utf-8">
<meta http-equiv="expires" content="0">
<title>@lang('ui.library management backend')</title>
<style type="text/css">


.browser_box{
    margin:0;
    padding:0 0 0 0;
}

.browser_box table{
    border-radius: 0 !important;
    border:1px solid #000;
    background:#fff;
    border-spacing: 0;
    margin-bottom: 20px;
}

.browser_box table th{
    padding:5px 10px;
    text-align:left;
    background:#d4e9e7;
    color:#000;
    font-weight:normal;
    font-family: 'Noto Sans';
}

.browser_box table td{
    padding:10px 10px;
    font-weight:normal;
    font-family: 'Noto Sans';
}

.browser_box table td .browser_img{
    width:130px;
}

</style>
</head>

<body>
<div class="browser_box">
<table width="100%" border="1" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
        <th>@lang('ui.year-month')</th>
        <th>@lang('ui.account')</th>
        <th>@lang('ui.permission')</th>
        <th>@lang('ui.blockade')</th>
        <th>@lang('ui.login times')</th>
        <th>@lang('ui.logout times')</th>
    </tr>
  </thead>
  <tbody>

    @if(count($report) > 0)

        @for($i = 0; $i <count($report); $i++)

        <tr>
            <td>{{ $Year . '-' . $Month }}</td>
            <td>{{ $report[$i]->account_userid }}</td>

            @if( $report[$i]->perm == 1 )
                <td>@lang('ui.administrator')</td>
            @elseif( $report[$i]->perm == 2 )
                <td>@lang('ui.standard user')</td>
            @endif

            @if( $report[$i]->lock == 1 )
                <td>@lang('ui.true')</td>
            @elseif( $report[$i]->lock == 0)
                <td>@lang('ui.false')</td>
            @endif

            <td>{{ $report[$i]->login }}</td>
            <td>{{ $report[$i]->logout }}</td>
        </tr>

        @endfor

    @endif
  </tbody>
</table>
</div>
</body>
</html>
