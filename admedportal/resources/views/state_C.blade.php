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

                    <!-- 功能 區塊 Begin -->

                    <form id="state_C" method="POST" action="/state_C/post">

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

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a class="btn_02" onClick="document.getElementById('state_C').submit();">@lang('ui.query')</a>

                        </div>
                        <!-- 功能 區塊 End -->


                        <!-- 瀏覽 區塊 Begin -->
                        <div class="browser_box">
                            <table width="100%" border="1" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>@lang('ui.year-month')</th>
                                    <th>@lang('ui.webpage name')</th>
                                    <th>@lang('ui.display')</th>
                                    <th>@lang('ui.click times')</th>
                                </tr>

                                @if(count($report) > 0 )

                                    @for($i = 0; $i < count($report); $i++)

                                        <tr>

                                            <td>{{ $Year . '-' . $Month }}</td>
                                            <td>{{ $report[$i]->title }}</td>

                                            @if( $report[$i]->view == 1 )
                                                <td>@lang('ui.true')</td>
                                            @elseif( $report[$i]->view == 0 )
                                                <td>@lang('ui.false')</td>
                                            @endif

                                            <td>{{ $report[$i]->view_times }}</td>

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
                            <a class="btn_02" href="{{ url('/state_C_output/' . $Year . '/' . $Month) }}">PDF @lang('ui.export')</a>
                            <a class="btn_02" href="{{ url('/state_C_output_csv/' . $Year . '/' . $Month) }}">CSV @lang('ui.export')</a>
                        </div>
                        @endif

                                <!-- 功能 區塊 End -->

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
