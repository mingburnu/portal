<!DOCTYPE html>
<html lang="zh-tw">
@include('layout.head')
<body>
<div class="wrapper">

    <!-- header 區塊 Begin -->
    @include('layout.header')
            <!-- header 區塊 End -->


    <!-- search 區塊 Begin -->
    @include('layout.search')
            <!-- search 區塊 End -->


    <!-- Menu 區塊 Begin -->
    @include('layout.menu')
            <!-- Menu 區塊 End -->

    <!-- 麵包屑 區塊 Begin -->
    <div class="crumbs">
        <div class="innerwrapper">
            目前位置：<a href="{{ route('index') }}">首頁</a> &gt; <a href="{{ route('news.list') }}">訊息列表</a>
        </div>
    </div>
    <!-- 麵包屑 區塊 End -->

    <!-- 主內容 區塊 Begin -->
    <div class="news_list">
        <div class="innerwrapper">
            <!-- 內容 區塊 Begin -->


            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="news_box_list">

                @if(count($news))

                    @for($i = 0; $i < count($news); $i++)

                        <tr>
                            <?php list($newt1, $newt2) = explode(" ", $news[$i]->publish_time); ?>
                            <th>{{ $newt1 }}</th>
                            <td>
                                <a href="{{ $url = route('news.detail.id', ['id' => $news[$i]->id ]) }}">
                                    @if(Cookie::get('language')==0)
                                        {{ $news[$i]->title }}
                                    @else
                                        <?php
                                        $title_i18n = $news[$i]->title;
                                        ?>
                                        @foreach($news[$i]['many'] as $news_i18n)
                                            <?php
                                            if ($news_i18n->language == Cookie::get('language') && $news_i18n->title != null) {
                                                $title_i18n = $news_i18n->title;
                                            }
                                            ?>
                                        @endforeach
                                        {{ $title_i18n }}
                                    @endif
                                </a>
                            </td>
                        </tr>

                    @endfor

                @endif

            </table>


            <!-- 內容 區塊 End -->
        </div>
    </div>
    <!-- 主內容 區塊 End -->


    <!-- footer 區塊 Begin -->
    @include('layout.footer')
            <!-- footer 區塊 End -->

</div>


<!-- 執行javascript 區塊 Begin -->
@include('layout.init')
<!-- 執行javascript 區塊 End -->
</body>
</html>
