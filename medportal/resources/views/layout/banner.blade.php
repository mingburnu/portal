@if($webconfig[0]->play)
    <div class="banners">
        <div class="innerwrapper">
            <div class="owl-carousel owl-theme">

                @foreach($banners as $banner)
                    <div class="item">
                        <a href="{{$banner->url}}">
                            <img src="{{$banner->img}}">
                            @if($banner->play)
                                <div class="title">
                                    @if(Cookie::get('language')==0)
                                        {{$banner->title}}
                                    @else
                                        <?php
                                        $title_i18n = $banner->title;
                                        ?>
                                        @foreach($banner->banner_i18ns as $banner_i18n)
                                            <?php
                                            if ($banner_i18n->language == Cookie::get('language') && $banner_i18n->title != null) {
                                                $title_i18n = $banner_i18n->title;
                                            }
                                            ?>
                                        @endforeach
                                        {!! $title_i18n !!}
                                    @endif
                                </div>

                            @endif
                        </a>

                        @if(Cookie::get('language')==0 || Cookie::get('language')==null)
                            @if(!empty($banner->info))
                                <div class="info">
                                    <div class="info_txt">
                                        {{$banner->info}}
                                    </div>
                                    <a class="info_btn" href="javascript:void(0);" onClick="ShowInfo(this);"><i
                                                class="fa fa-info-circle"></i></a>
                                </div>
                            @endif
                        @else
                            @foreach($banner->banner_i18ns as $banner_i18n)
                                @if(Cookie::get('language')==$banner_i18n->language && !empty($banner_i18n->info))
                                    <div class="info">
                                        <div class="info_txt">
                                            {{$banner_i18n->info}}
                                        </div>
                                        <a class="info_btn" href="javascript:void(0);" onClick="ShowInfo(this);"><i
                                                    class="fa fa-info-circle"></i></a>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif