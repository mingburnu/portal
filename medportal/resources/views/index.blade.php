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
            {{$signal[0]->location}}：<a href="{{ route('index') }}"> {{ $signal[0]->home }}</a>
        </div>
    </div>
    <!-- 麵包屑 區塊 End -->

    <!-- Books 區塊 Begin -->
    @include('layout.books')
            <!-- Books 區塊 End -->


    <!-- News 區塊 Begin -->
    @include('layout.news')
            <!-- News 區塊 End -->


    <!-- footer 區塊 Begin -->
    @include('layout.footer')
            <!-- footer 區塊 End -->

</div>

<!-- 執行javascript 區塊 Begin -->
@include('layout.init')
<script>
    function change_lang() {
        var url = $('div.lang').children().children().attr('action');
        var data = $('div.lang').children().children().serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (result) {
                loadI18n();
            }
        });
    }

    function loadI18n() {
        window.location.href = location.href;
    }

</script>
<!-- 執行javascript 區塊 End -->
</body>
</html>
