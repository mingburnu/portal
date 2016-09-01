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
                        <a class="btn_02" href="{{ route('books.add') }}">新增</a>
                    </div>
                    <!-- 功能 區塊 End -->


                    <!-- 瀏覽 區塊 Begin -->
                    <div class="browser_box">
                        <table width="100%" border="1" cellpadding="0" cellspacing="0">
                            <tr>
                                <th>書封</th>
                                <th>書名</th>
                                <th>連結</th>
                                <th>是否顯示</th>
                                <th>建立時間</th>
                                <th>修改時間</th>
                                <th>功能</th>
                            </tr>

                            @if(count($book))

                                @for($i = 0; $i < count($book); $i++)

                                    <tr>
                                        <td><img class="browser_img" src="{{ asset($book[$i]->cover) }}"></td>
                                        <td>{{ $book[$i]->book_name_ch }}</td>
                                        <td><a target="_blank" href="{{ $book[$i]->url }}">連結</a></td>

                                        @if($book[$i]->view == 1 )
                                            <td>是</td>
                                        @elseif($book[$i]->view == 0)
                                            <td>否</td>
                                        @endif

                                        <td>{{ $book[$i]->created_at }}</td>
                                        <td>{{ $book[$i]->updated_at }}</td>
                                        <td>
                                            <a class="btn_03"
                                               href="{{ $url = route('books.browser.id.delete', ['id' => $book[$i]->id ] ) }}">刪除</a>
                                            <a class="btn_02"
                                               href="{{ $url = route('books.edit.id', ['id' => $book[$i]->id ]) }}">修改</a>
                                        </td>
                                    </tr>

                                @endfor

                            @endif

                        </table>
                    </div>

                    {!! $book->render() !!}

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
