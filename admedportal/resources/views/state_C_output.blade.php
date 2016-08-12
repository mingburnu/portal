<!DOCTYPE html>
<html lang="zh-tw">
<head>
<meta charset="utf-8">
<meta http-equiv="expires" content="0">
<title>圖書館管理後台</title>
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
        <th>年-月</th>
        <th>網頁名稱</th>
        <th>是否顯示</th>
        <th>進入次數</th>
    </tr>
  </thead>  
  <tbody>  
    
    @if(count($report) > 0)

        @for($i = 0; $i <count($report); $i++)

        <tr>

            <td>{{ $Year . '-' . $Month }}</td>
            <td>{{ $report[$i]->title }}</td>

            @if( $report[$i]->view == 1 )
                <td>是</td>
            @elseif( $report[$i]->view == 0 )
                <td>否</td>
            @endif

            <td>{{ $report[$i]->view_times }}</td>

        </tr>
    
        @endfor           

    @endif

  </tbody> 
</table>
</div>
</body>
</html>
