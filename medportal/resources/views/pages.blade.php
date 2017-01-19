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
            目前位置：<a href="{{ route('index') }}">首頁</a> &gt; <a
                    href="{{ $url = route('pages.id', ['id' => $pages_data[0]->id]) }}">{{ $pages_data[0]->title }}</a>
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
