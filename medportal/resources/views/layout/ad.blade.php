@if($webconfig[0]->list_ad)
    <div class="ad">
        <div class="innerwrapper">
            <div class="ad_box">
                @foreach($ads as $ad)
                    <div class="item">
                        @if($ad->url==null)
                            <a target="_blank">
                                @if($ad->upload_option)
                                    <img src="{{asset($ad->img)}}">
                                @else
                                    <img src="{{$ad->img}}">
                                @endif
                            </a>
                        @else
                            <a target="_blank" href="{{$ad->url}}">
                                @if($ad->upload_option)
                                    <img src="{{asset($ad->img)}}">
                                @else
                                    <img src="{{$ad->img}}">
                                @endif
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif