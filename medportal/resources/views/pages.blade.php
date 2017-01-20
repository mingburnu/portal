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
            {{$signal[0]->location}}：<a href="{{ route('index') }}">{{ $signal[0]->home }}</a> &gt; <a
                    href="{{ $url = route('pages.id', ['id' => $pages_data[0]->id]) }}">
                @if(Cookie::get('language')==0)
                    {{ $pages_data[0]->title }}
                @else
                    <?php
                    $title_i18n = $pages_data[0]->title;
                    ?>
                    @foreach($pages_data[0]['many'] as $pages_data_i18n)
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

            <div class="title">{{ $pages_data[0]->title }}</div>
            <div class="ck_htmlcode">
                {!! $pages_data[0]->content !!}
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
