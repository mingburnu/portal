@if($webconfig[0]->play)
    <div class="banners">
        <div class="innerwrapper">
            <div class="owl-carousel owl-theme">

                @foreach($banners as $banner)
                    <div class="item">
                        <a href="{{$banner->url}}">
                            @if($banner->upload_option)
                                <img src="{{asset($banner->img)}}">
                            @else
                                <img src="{{$banner->img}}">
                            @endif
                            @if($banner->play)
                                <div class="title">
                                    @if($signal[0]->id=='0')
                                        {{$banner->title}}
                                    @else
                                        <?php
                                        $title_i18n = $banner->title;
                                        foreach ($banner->banner_i18ns as $banner_i18n) {
                                            if ($banner_i18n->language == $signal[0]->id) {
                                                if ($banner_i18n->title != null) {
                                                    $title_i18n = $banner_i18n->title;
                                                }
                                                break;
                                            }
                                        }
                                        ?>
                                        {!! $title_i18n !!}
                                    @endif
                                </div>

                            @endif
                        </a>

                        @if($signal[0]->id=='0')
                            @if(!empty($banner->info))
                                <div class="info">
                                    <div class="info_txt">
                                        {{$banner->info}}
                                    </div>
                                    <a class="info_btn" href="javascript:void(0);" onClick="ShowInfo(this);">
                                        <i class="fa fa-info-circle"></i></a>
                                </div>
                            @endif
                        @else
                            <?php
                            $info_i18n = null;
                            foreach ($banner->banner_i18ns as $banner_i18n) {
                                if ($banner_i18n->language == $signal[0]->id) {
                                    if (!empty($banner_i18n->info)) {
                                        $info_i18n = $banner_i18n->info;
                                    }
                                    break;
                                }
                            }
                            ?>
                            @if(!empty($info_i18n))
                                <div class="info">
                                    <div class="info_txt">
                                        {{$info_i18n}}
                                    </div>
                                    <a class="info_btn" href="javascript:void(0);" onClick="ShowInfo(this);">
                                        <i class="fa fa-info-circle"></i></a>
                                </div>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif