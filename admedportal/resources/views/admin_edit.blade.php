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
                        <form id="admin_edit" method="POST" action="/admin_edit/edit">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>@lang('ui.account')(&#8226;)</th>
                                    <td>{{ $user[0]->email }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.password')(&#8226;)</th>
                                    <td><input class="v_02" type="password" name="password" value=""></td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.permission')</th>
                                    <td><select name="perm">
                                            @if( $user[0]->perm == 1 )
                                                <option value="1" selected>@lang('ui.administrator')</option>
                                                <option value="2">@lang('ui.standard user')</option>
                                            @elseif( $user[0]->perm == 2)
                                                <option value="2" selected>@lang('ui.standard user')</option>
                                            @endif
                                        </select>

                                        <div class="note_txt">
                                            <div>@lang('ui.administrator operated list')</div>
                                            <div>@lang('ui.standard user operated list')</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.blockade')</th>
                                    <td>
                                        @if( $user[0]->lock == 1)
                                            <label><input type="radio" name="lock" value="1" checked>@lang('ui.true')</label>
                                            <label><input type="radio" name="lock" value="0">@lang('ui.false')</label>
                                        @elseif( $user[0]->lock == 0)
                                            <label><input type="radio" name="lock" value="0" checked>@lang('ui.false')</label>
                                            <label><input type="radio" name="lock" value="1">@lang('ui.true')</label>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('ui.note')</th>
                                    <td><textarea rows="5" name="note">{{ $user[0]->note }}</textarea></td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02" href="javascript:history.go(-1);">@lang('ui.back')</a>
                                        <a class="btn_02"
                                           onClick="document.getElementById('admin_edit').submit();">@lang('ui.submit')</a>
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $user[0]->id }}">
                        </form>
                    </div>
                    <!-- detail 區塊 End -->

                    <!-- Note 區塊 Begin -->
                    <div class="detail_note">
                        <div class="detail_note_title">Note</div>
                        <div class="detail_note_content"><span class="required">(&#8226;)</span>@lang('ui.required field')</div>
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
