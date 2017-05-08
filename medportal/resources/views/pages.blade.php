<!DOCTYPE html>
<html lang="zh-tw">
@include('layout.head')
<body>
<div class="wrapper">

    <!-- lang 區塊 Begin -->
    @include('layout.lang')
            <!-- lang 區塊 End -->

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
            {{$signal[0]->location}}：<a href="{{ route('index') }}">{{ $signal[0]->home }}</a> &gt; <a
                    href="{{ $url = route('pages.id', ['id' => $pages_data->id]) }}">
                @if(Cookie::get('language')==0)
                    {{ $pages_data->title }}
                @else
                    <?php
                    $title_i18n = $pages_data->title;
                    ?>
                    @foreach($pages_data->menupage_i18ns as $pages_data_i18n)
                        <?php
                        if ($pages_data_i18n->language == Cookie::get('language') && $pages_data_i18n->title != null) {
                            $title_i18n = $pages_data_i18n->title;
                        }
                        ?>
                    @endforeach
                    {{ $title_i18n }}
                @endif
            </a>
        </div>
    </div>
    <!-- 麵包屑 區塊 End -->

    <!-- 主內容 區塊 Begin -->
    <div class="news_detail">
        <div class="innerwrapper">
            <!-- 內容 區塊 Begin -->
            <div class="title">
                @if(Cookie::get('language')==0)
                    {{ $pages_data->title }}
                @else
                    <?php
                    $title_i18n = $pages_data->title;
                    ?>
                    @foreach($pages_data->menupage_i18ns as $page_i18n)
                        <?php
                        if ($page_i18n->language == Cookie::get('language') && $page_i18n->title != null) {
                            $title_i18n = $page_i18n->title;
                        }
                        ?>
                    @endforeach
                    {{ $title_i18n }}
                @endif
            </div>
            <div class="ck_htmlcode">
                @if(Cookie::get('language')==0)
                    {!! $pages_data->content !!}
                @else
                    <?php
                    $content_i18n = $pages_data->content;
                    ?>
                    @foreach($pages_data->menupage_i18ns as $page_i18n)
                        <?php
                        if ($page_i18n->language == Cookie::get('language') && $page_i18n->content != null) {
                            $content_i18n = $page_i18n->content;
                        }
                        ?>
                    @endforeach
                    {!! $content_i18n !!}
                @endif
            </div>
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
