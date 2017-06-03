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
                    href="{{ route('news.list') }}">{{$signal[0]->board}}</a>
        </div>
    </div>
    <!-- 麵包屑 區塊 End -->

    <!-- 主內容 區塊 Begin -->
    <div class="news_list">
        <div class="innerwrapper">
            <!-- 內容 區塊 Begin -->


            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="news_box_list">

                @foreach($news as $data)

                    <tr>
                        <?php list($newt1, $newt2) = explode(" ", $data->publish_time); ?>
                        <th>{{ $newt1 }}</th>
                        <td>
                            <a href="{{ $url = route('news.detail.id', ['id' => $data->id ]) }}">
                                @if(Cookie::get('language')==0)
                                    {{ $data->title }}
                                @else
                                    <?php
                                    $title_i18n = $data->title;
                                    ?>
                                    @foreach($data->news_i18ns as $news_i18n)
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

                @endforeach

            </table>


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
