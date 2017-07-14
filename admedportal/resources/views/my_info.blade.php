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
                    @include('layout.message')
                            <!-- message 區塊 End -->

                    <!-- detail 區塊 Begin -->
                    <div class="detail_box">
                        <form id="my_info_edit" enctype="multipart/form-data" method="POST" action="/my_info/edit">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                <tr>
                                    <th>@lang('ui.account')</th>
                                    <td>{{ $email }}</td>
                                </tr>

                                <tr>

                                    <th>@lang('ui.permission')</th>

                                    @if($perm == 1)
                                        <td>@lang('ui.administrator')</td>
                                    @elseif($perm == 2)
                                        <td>@lang('ui.standard user')</td>
                                    @endif

                                </tr>

                                <tr>
                                    <th>@lang('ui.password')</th>
                                    <td><input class="v_01" type="text" name="password"></td>
                                </tr>

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02"
                                           onClick="document.getElementById('my_info_edit').submit();">@lang('ui.update')</a>
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

    @include('layout.footer')

</div>

<!-- 執行javascript 區塊 Begin -->
@include('layout.javascript')
        <!-- 執行javascript 區塊 End -->

</body>
</html>
