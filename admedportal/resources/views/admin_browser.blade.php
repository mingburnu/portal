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

                    <!-- 功能 區塊 Begin -->
                    <div class="func_box">
                        <a class="btn_02" href="{{ route('admin.add') }}">@lang('ui.add')</a>
                    </div>
                    <!-- 功能 區塊 End -->


                    <!-- 瀏覽 區塊 Begin -->
                    <div class="browser_box">
                        <table width="100%" border="1" cellpadding="0" cellspacing="0">
                            <tr>
                                <th>@lang('ui.account')</th>
                                <th>@lang('ui.permission')</th>
                                <th>@lang('ui.blockade')</th>
                                <th>@lang('ui.note')</th>
                                <th>@lang('ui.created at')</th>
                                <th>@lang('ui.updated at')</th>
                                <th>@lang('ui.action')</th>
                            </tr>

                            @if(count($user))

                                @for($i = 0; $i < count($user); $i++)
                                    <tr>
                                        <td>{{ $user[$i]->email}}</td>

                                        @if($user[$i]->perm == 1)
                                            <td>@lang('ui.administrator')</td>
                                        @elseif($user[$i]->perm == 2)
                                            <td>@lang('ui.standard user')</td>
                                        @endif

                                        @if($user[$i]->lock == 1)
                                            <td>@lang('ui.true')</td>
                                        @elseif($user[$i]->lock == 0)
                                            <td>@lang('ui.false')</td>
                                        @endif

                                        @if($user[$i]->note)
                                            <td>{{ $user[$i]->note }}</td>
                                        @else
                                            <td>&nbsp;</td>
                                        @endif

                                        <td>{{ $user[$i]->created_at }}</td>
                                        <td>{{ $user[$i]->updated_at }}</td>
                                        <td>
                                            <a class="btn_03"
                                               href="{{ $url = route('admin.broweser.id.delete', ['id' => $user[$i]->id ] ) }}">@lang('ui.delete')</a>
                                            <a class="btn_02"
                                               href="{{ $url = route('admin.edit', ['id' => $user[$i]->id ] ) }}">@lang('ui.modify')</a>
                                        </td>
                                    </tr>
                                @endfor

                            @endif

                        </table>
                    </div>

                    <!-- 分頁 區塊 Begin -->
                    @include('layout.pagination',['table'=>$user])
                            <!-- 分頁 區塊 End -->
                    <!-- 瀏覽 區塊 End -->


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
