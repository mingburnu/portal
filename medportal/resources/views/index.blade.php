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
            {{$signal[0]->location}}：<a href="{{ route('index') }}"> {{ $signal[0]->home }}</a>
        </div>
    </div>
    <!-- 麵包屑 區塊 End -->

    <!-- Banner 區塊 Begin -->
@if($webconfig[0]->play)
    @include('layout.banner')
@endif
<!-- Banner 區塊 End -->

    <div class="main_contents">
        <!-- News 區塊 Begin -->
    @include('layout.news')
    <!-- News 區塊 End -->

        <!-- Books 區塊 Begin -->
    @if($webconfig[0]->exhibition)
        @include('layout.books')
    @endif
    <!-- Books 區塊 End -->

        <!-- Ad 區塊 Begin -->
    @include('layout.ad')
    <!-- Ad 區塊 End -->
    </div>

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
