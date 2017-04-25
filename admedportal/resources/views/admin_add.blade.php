<!DOCTYPE html>
<html lang="zh-tw">
@include('layout.head')
<body>
<div class="wrapper">

    @include('layout.header')

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


                                <!-- detail 區塊 Begin -->
                        <div class="detail_box">
                            <form id="admin_add" method="POST" action="/admin_add/post">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th>帳號(&#8226;)</th>
                                        <td><input class="v_01" type="text" name="email">

                                            <div class="note_txt">格式必須為Mail</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>密碼(&#8226;)</th>
                                        <td><input class="v_02" type="password" name="password"></td>
                                    </tr>
                                    <tr>
                                        <th>權限身份</th>
                                        <td><select name="perm">
                                                <option value="1">最高管理者</option>
                                                <option value="2" selected>一般管理者</option>
                                            </select>

                                            <div class="note_txt">
                                                <div>最高管理者：帳號管理、網站設定、查詢資料庫管理、新書管理、公告管理、網頁管理、我的個人資料</div>
                                                <div>一般管理者：查詢資料庫管理、新書管理、公告管理、網頁管理、我的個人資料</div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>是否封鎖</th>
                                        <td>
                                            <label><input type="radio" name="lock" value="0" checked>否</label>
                                            <label><input type="radio" name="lock" value="1">是</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>備註</th>
                                        <td><textarea rows="5" name="note"></textarea></td>
                                    </tr>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <tr>
                                        <th>&nbsp;</th>
                                        <td>
                                            <a class="btn_02" href="javascript:history.go(-1);">返回</a>
                                            <a class="btn_02" onClick="document.getElementById('admin_add').submit();">送出</a>
                                        </td>
                                    </tr>
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

    @include('layout.footer')

</div>


<!-- 執行javascript 區塊 Begin -->
@include('layout.javascript')
        <!-- 執行javascript 區塊 End -->
</body>
</html>
