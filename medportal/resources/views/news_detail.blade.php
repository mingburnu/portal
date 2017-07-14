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
            {{$signal[0]->location}}：<a href="{{ route('index') }}">{{$signal[0]->home}}</a> &gt; <a
                    href="{{ route('news.list') }}">{{$signal[0]->board}}</a>
        </div>
    </div>
    <!-- 麵包屑 區塊 End -->

    <!-- 主內容 區塊 Begin -->
    <div class="news_detail">
        <div class="innerwrapper">
            <!-- 內容 區塊 Begin -->

            <div class="title">
                @if($signal[0]->id=='0')
                    {{ $news->title }}
                @else
                    <?php
                    $title_i18n = $news->title;
                    foreach ($news->news_i18ns as $news_i18n) {
                        if ($news_i18n->language == $signal[0]->id) {
                            if ($news_i18n->title != null) {
                                $title_i18n = $news_i18n->title;
                            }
                            break;
                        }
                    }
                    ?>
                    {{ $title_i18n }}
                @endif
            </div>
            <div class="ck_htmlcode">
                @if($signal[0]->id=='0')
                    {!! $news->content !!}
                @else
                    <?php
                    $content_i18n = $news->content;
                    foreach ($news->news_i18ns as $news_i18n) {
                        if ($news_i18n->language == $signal[0]->id) {
                            if ($news_i18n->content != null) {
                                $content_i18n = $news_i18n->content;
                            }
                            break;
                        }
                    }
                    ?>
                    {!! $content_i18n !!}
                @endif
            </div>
            <!-- 內容 區塊 End -->
        </div>
    </div>
    <!-- 主內容 區塊 End -->

    <!-- lang 區塊 Begin -->
    @include('layout.lang')
            <!-- lang 區塊 End -->

    <!-- footer 區塊 Begin -->
    @include('layout.footer')
            <!-- footer 區塊 End -->
</div>


<!-- 執行javascript 區塊 Begin -->
@include('layout.init')
        <!-- 執行javascript 區塊 End -->
</body>
</html>
