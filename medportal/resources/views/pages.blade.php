<!DOCTYPE html>
<html lang="zh-tw">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="expires" content="0">
<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1">
<title>{{ $webconfig[0]->site_name }}</title>
<link rel="icon" href="{{ asset('img/favicon.ico') }}">
<link rel="stylesheet" href="{{ asset('templates/art_' . $webconfig[0]->color . '_l.css') }}">
<link rel="stylesheet" href="{{ asset('templates/art_' . $webconfig[0]->color . '_s.css') }}" media="only screen and (max-width:640px)">
</head>

<body>
<div class="wrapper">

<!-- header 區塊 Begin -->
<div class="header">
    <div class="innerwrapper">
        <div class="logo"><a href="{{ route('index') }}"><img src="{{ asset('img/logo.png') }}"></a></div>
    </div>
</div>
<!-- header 區塊 End -->


<!-- search 區塊 Begin -->
<div class="search">
    <div class="search_db">
        <div class="innerwrapper">
            <div class="search_db_l">
                <span class="search_db_title">查詢資料庫：</span>
                <span class="search_db_list">

                @if(count($querydatabase) > 0 )

                    @for( $i = 0; $i < count($querydatabase); $i++)

                        <label><input type="radio" name="search_db_radio" value="{{ $querydatabase[$i]->rank_id }}" onClick="SearchBox_show('{{ $querydatabase[$i]->rank_id }}')">{{ $querydatabase[$i]->database_name }}</label>

                    @endfor

                @endif

                </span>
            </div>
            
            <div class="search_db_s">
                <span class="search_db_title">查詢資料庫：</span>
                <span class="search_db_list">
<select onChange="SearchBox_show(this.value)">
    <option value="0">請選擇...</option>

    @if(count($querydatabase) > 0)

        @for($i = 0; $i < count($querydatabase); $i++)

            <option value="{{ $querydatabase[$i]->rank_id }}">{{ $querydatabase[$i]->database_name }}</option>

        @endfor

    @endif

</select>
                </span>
            </div>
            
        </div>
    </div>
    
    <div class="search_box">
        <div class="innerwrapper">

            @if(count($querydatabase) > 0)

                @for($i = 0; $i < count($querydatabase); $i++ )

                    <div class="search_box_in search_box_in_{{ $querydatabase[$i]->rank_id }}">
                    {!! $querydatabase[$i]->syntax !!}
                    </div>

                @endfor

            @endif

        </div>
    </div>
</div>
<!-- search 區塊 End -->


<!-- Menu 區塊 Begin -->
<div class="menu">
    <div class="innerwrapper">
        <div class="menu_box_list">
        <ul>

            <li><a href="{{ route('index') }}">首頁</a></li>

            @if(count($pages) > 0)

                @for( $i = 0; $i < count($pages); $i++)

                    @if($pages[$i]->type == 1)


                        @if($pages[$i]->id == $newid)

                            <li><a class="menu_hover" href="{{ $url = route('pages.id', ['id' => $pages[$i]->id]) }}">{{ $pages[$i]->title }}</a></li>
                    
                        @else

                            <li><a href="{{ $url = route('pages.id', ['id' => $pages[$i]->id]) }}">{{ $pages[$i]->title }}</a></li>
                
                        @endif

                    @elseif($pages[$i]->type == 2)

                        <li><a href="{{ $url = route('pages.id.type', ['id' => $pages[$i]->id, 'type' => $pages[$i]->type ]) }}" target="_blank">{{ $pages[$i]->title }}</a></li>

                    @endif

                @endfor

            @endif

        </ul>
        </div>
        
        <div class="menu_box_select">
<select onChange="menu_box_select_chg(this);">

    <option value="{{ route('index') }}">首頁</option>

    @if(count($pages) > 0)

        @for( $i = 0; $i < count($pages); $i++)

            @if($pages[$i]->type == 1)

                @if($pages[$i]->id == $newid)

                    <option value="{{ $url = route('pages.id', ['id' => $pages[$i]->id]) }}" selected>{{ $pages[$i]->title }}</option>

                @else

                    <option value="{{ $url = route('pages.id', ['id' => $pages[$i]->id]) }}">{{ $pages[$i]->title }}</option>

                @endif

            @elseif($pages[$i]->type == 2)

                
                <option value="{{ $url = route('pages.id.type', ['id' => $pages[$i]->id, 'type' => $pages[$i]->type ]) }}">{{ $pages[$i]->title }}</option>

            @endif

        @endfor

    @endif


</select>
        </div>
    </div>
</div>
<!-- Menu 區塊 End -->

<!-- 麵包屑 區塊 Begin -->

<div class="crumbs">
    <div class="innerwrapper">
目前位置：<a href="{{ route('index') }}">首頁</a> &gt; <a href="{{ $url = route('pages.id', ['id' => $pages_data[0]->id]) }}">{{ $pages_data[0]->title }}</a> 
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
<div class="footer">
    <div class="innerwrapper">
    <span class="counter">網站訪客人數：{{ sprintf("%08d", $totalc) }}</span>
    {!! $webconfig[0]->copyright !!}
    </div>
</div>

</div>


<!-- 執行javascript 區塊 Begin -->
<script src="{{ asset('templates/jquery-1.11.3.min.js') }}"></script>
<script src="{{ asset('templates/matchMedia.js') }}"></script>
<script src="{{ asset('templates/art.js') }}"></script>
<script>
$(document).ready(function() {
    //SearchBox 初始化

    var data = [];

    @if(count($querydatabase) > 0 )

        @for($i = 0; $i < count($querydatabase); $i++)
            data.push(['search_box_in_{{ $querydatabase[$i]->rank_id }}']);
        @endfor

    @endif

    SearchBox_init(data);
    

});

//cssom
$(window).bind('load', function() { 
    SearchBox_show('load');
});
</script>
<!-- 執行javascript 區塊 End -->
</body>
</html>
