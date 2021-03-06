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
                <td width="170" style="background:#ed6c44;"><img src="{{ asset('templates/images/logo.png') }}"
                                                                 width="170" height="60"></td>
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
                    @include('layout.menu')
                            <!-- menu 區塊 End -->
                </td>
                <td class="td_2">
                    <!-- 內容 區塊 Begin -->

                    <!-- message 區塊 Begin -->
                    <div class="message">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr valign="top">
                                <td class="message_text"></td>
                                <td class="message_close" valign="middle"><a href="javascript:void(0);"
                                                                             onClick="message_hide();">關閉</a></td>
                            </tr>
                        </table>
                    </div>
                    <!-- message 區塊 End -->

                    <!-- 功能 區塊 Begin -->

                    <form id="state_D" method="POST" action="/state_D/post">

                        <div class="func_box">
                            @lang('ui.year')
                            <select name="Year">

                                @for($i = 2015; $i< 2020; $i++)

                                    @if($i == $Year)
                                        <option value="{{ $i }}" selected>{{ $i }}</option>
                                    @else
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endif

                                @endfor

                            </select>
                            &nbsp;&nbsp;
                            @lang('ui.month')
                            <select name="Month">

                                @for($i = 1; $i < 13; $i++)

                                    @if($i == $Month)

                                        @if($i < 10 )
                                            <option value="0{{ $i }}" selected>{{ $i }}</option>
                                        @else
                                            <option value="{{ $i }}" selected>{{ $i }}</option>
                                        @endif
                                    @else

                                        @if($i < 10)
                                            <option value="0{{ $i }}">{{ $i }}</option>
                                        @else
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endif
                                    @endif

                                @endfor

                            </select>
                            &nbsp;&nbsp;
                            資料庫
                            <select name="querydatabase">

                                @if(count($db_data) > 0 )

                                    <option value="all">不限</option>

                                    @for($i = 0; $i < count($db_data); $i++)

                                        <option value="{{ $db_data[$i]->database_name }}">{{ $db_data[$i]->database_name }}</option>

                                    @endfor

                                @endif

                            </select>
                            <span>(僅顯示排行前100的資料)</span>
                            &nbsp;&nbsp;

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn_02" onClick="document.getElementById('state_D').submit();">@lang('ui.query')</a>


                        </div>

                        <!-- 功能 區塊 End -->


                        <!-- 瀏覽 區塊 Begin -->
                        <div class="browser_box">
                            <table width="100%" border="1" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>@lang('ui.year-month')</th>
                                    <th>排名</th>
                                    <th>關鍵字名稱</th>
                                    <th>資料庫查詢</th>
                                    <th>查詢次數</th>
                                </tr>

                                @if(count($report) > 0)

                                    @for($i = 0; $i < count($report); $i++)

                                        <tr>
                                            <td>{{ $Year . '-' . $Month }}</td>
                                            <td>{{ $report[$i]->rank_id }}</td>
                                            <td>{{ $report[$i]->keyword }}</td>
                                            <td>{{ $report[$i]->database_name }}</td>
                                            <td>{{ $report[$i]->query_times }}</td>
                                        </tr>

                                    @endfor
                                @endif

                            </table>
                        </div>

                    </form>
                    <!-- 瀏覽 區塊 End -->


                    <!-- 功能 區塊 Begin -->

                    @if(count($report) > 0 )
                        <div class="func_box">
                            <a class="btn_02" href="{{ url('/state_D_output/' . $Year . '/' . $Month . '/' . $q_b) }}">@lang('ui.export')</a>
                        </div>
                        @endif

                                <!-- 功能 區塊 End -->



                        <!-- 內容 區塊 End -->
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">本系統由碩陽數位科技有限公司 版權所有 Copyright &copy; Shou Yang Technology Co., Ltd.</div>

</div>


<!-- 執行javascript 區塊 Begin -->
<script src="{{ asset('templates/jquery-1.11.3.min.js') }}"></script>
<script src="{{ asset('templates/art.js') }}"></script>
<!-- 執行javascript 區塊 End -->
</body>
</html>
