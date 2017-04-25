<div class="news_home">
    <div class="innerwrapper">
        <div class="news_title">{{$signal[0]->newest}}</div>
        <div class="news_box">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="news_box_list">

                @for($i = 0; $i < count($news); $i++)

                    <tr>
                        <th>{{ explode(" ", $news[$i]->publish_time)[0] }}</th>
                        <td>
                            <a href="{{ $url = route('news.detail.id', ['id' => $news[$i]->id ]) }}">
                                @if(Cookie::get('language')==0)
                                    {{ $news[$i]->title }}
                                @else
                                    <?php
                                    $title_i18n = $news[$i]->title;
                                    ?>
                                    @foreach($news[$i]->news_i18ns as $news_i18n)
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

                @endfor

            </table>
            <div class="news_box_buttom"><a class="btn_01" href="{{ route('news.list') }}">{{$signal[0]->more}}</a></div>
        </div>
    </div>
</div>