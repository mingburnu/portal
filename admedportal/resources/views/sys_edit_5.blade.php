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
                    <div class="menu">

                        <div class="menu_box">
                            <div class="title">平台設定</div>
                            <a class="menu_A" href="{{ route('admin.browser') }}">帳號管理</a>
                            <a class="menu_B" href="{{ route('sys.edit') }}">網站設定</a>
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

                    @if(Session::get('error'))

                        <div class="message_print_errer">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr valign="top">
                                    <td class="message_text"><p>{{ Session::get('error') }}</p></td>
                                    <td class="message_close" valign="middle"><a href="javascript:void(0);"
                                                                                 onClick="message_print_errer_hide();">關閉</a>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    @endif


                    @if(Session::get('success'))

                        <div class="message_print_ok">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr valign="top">
                                    <td class="message_text"><p>{{ Session::get('success') }}</p></td>
                                    <td class="message_close" valign="middle"><a href="javascript:void(0);"
                                                                                 onClick="message_print_ok_hide();">關閉</a>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        @endif

                                <!-- message 區塊 End -->




                        <!-- detail 區塊 Begin -->
                        <div class="detail_box">
                            <div class="steps_box">
                                <span class="title">步驟</span>
                                <span>1</span>
                                <span>2</span>
                                <span>3</span>
                                <span>4</span>
                                <span class="active">5</span>
                            </div>
                            <form id="webconfig" method="POST" enctype="multipart/form-data" action="/sys_edit_5/post">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                    <tr>
                                        <th>系統管理電子信箱(•)</th>
                                        <td><input class="v_01" type="text" name="email"
                                                   value="{{ $webconfig[0]->email }}">{{Session::get('email')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Ico圖</th>
                                        <td><a target="_blank" href="{{ asset('img/favicon.ico') }}">檢視圖檔</a><BR/>
                                            <input type="file" name="ico">

                                            <div class="note_txt">圖檔尺寸大小不限，以128px X 128px為佳。</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>版面配色</th>
                                        <td>
                                            @if( $webconfig[0]->color == "S1")
                                                <label><input type="radio" name="color" value="S1" checked><img
                                                            src="{{ asset('templates/images/style_S1.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                                <label><input type="radio" name="color" value="S2"><img
                                                            src="{{ asset('templates/images/style_S2.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                                <label><input type="radio" name="color" value="S3"><img
                                                            src="{{ asset('templates/images/style_S3.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                                <label><input type="radio" name="color" value="S4"><img
                                                            src="{{ asset('templates/images/style_S4.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                            @elseif( $webconfig[0]->color == "S2")
                                                <label><input type="radio" name="color" value="S1"><img
                                                            src="{{ asset('templates/images/style_S1.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                                <label><input type="radio" name="color" value="S2" checked><img
                                                            src="{{ asset('templates/images/style_S2.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                                <label><input type="radio" name="color" value="S3"><img
                                                            src="{{ asset('templates/images/style_S3.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                                <label><input type="radio" name="color" value="S4"><img
                                                            src="{{ asset('templates/images/style_S4.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                            @elseif( $webconfig[0]->color == "S3")
                                                <label><input type="radio" name="color" value="S1"><img
                                                            src="{{ asset('templates/images/style_S1.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                                <label><input type="radio" name="color" value="S2"><img
                                                            src="{{ asset('templates/images/style_S2.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                                <label><input type="radio" name="color" value="S3" checked><img
                                                            src="{{ asset('templates/images/style_S3.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                                <label><input type="radio" name="color" value="S4"><img
                                                            src="{{ asset('templates/images/style_S4.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                            @elseif( $webconfig[0]->color == "S4")
                                                <label><input type="radio" name="color" value="S1"><img
                                                            src="{{ asset('templates/images/style_S1.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                                <label><input type="radio" name="color" value="S2"><img
                                                            src="{{ asset('templates/images/style_S2.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                                <label><input type="radio" name="color" value="S3"><img
                                                            src="{{ asset('templates/images/style_S3.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                                <label><input type="radio" name="color" value="S4" checked><img
                                                            src="{{ asset('templates/images/style_S4.png') }}"
                                                            width="60" height="35"></label>&nbsp;&nbsp;
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>備註</th>
                                        <td><textarea rows="5" name="note">{{ $webconfig[0]->note }}</textarea></td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <td>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <a class="btn_02" href="/sys_edit_4">上一步</a>
                                            <a class="btn_02" href="javascript:void(0);"
                                               onclick="document.getElementById('webconfig').submit();">完成</a>
                                        </td>
                                    </tr>
                                    </tbody>
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

    <div class="footer">本系統由碩陽數位科技有限公司 版權所有 Copyright &copy; Shou Yang Technology Co., Ltd.</div>

</div>


<!-- 執行javascript 區塊 Begin -->
<script src="{{ asset('templates/jquery-1.11.3.min.js') }}"></script>
<script src="{{ asset('templates/art.js') }}"></script>
<!-- 執行javascript 區塊 End -->
</body>
</html>
