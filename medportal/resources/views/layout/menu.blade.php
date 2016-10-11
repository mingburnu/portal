<div class="menu">
    <div class="innerwrapper">
        <div class="menu_box_list">
            <ul>
                <li><a class="menu_hover" href="{{ route('index') }}">首頁</a></li>

                @if(count($pages) > 0)

                    @for( $i = 0; $i < count($pages); $i++)

                        @if($pages[$i]->type == 1)


                            <li>
                                <a href="{{ $url = route('pages.id', ['id' => $pages[$i]->id]) }}">{{ $pages[$i]->title }}</a>
                            </li>

                        @elseif($pages[$i]->type == 2)

                            <li>
                                <a href="{{ $url = route('pages.id.type', ['id' => $pages[$i]->id, 'type' => $pages[$i]->type ]) }}"
                                   target="_blank">{{ $pages[$i]->title }}</a></li>


                        @endif

                    @endfor

                @endif

            </ul>
        </div>

        <div class="menu_box_select">
            <select onChange="menu_box_select_chg(this);">
                <option value="{{ route('index') }}" selected>首頁</option>

                @if(count($pages) > 0)

                    @for( $i = 0; $i < count($pages); $i++)

                        @if($pages[$i]->type == 1)

                            <option value="{{ $url = route('pages.id', ['id' => $pages[$i]->id]) }}">{{ $pages[$i]->title }}</option>

                        @elseif($pages[$i]->type == 2)

                            <option value="{{ $url = route('pages.id.type', ['id' => $pages[$i]->id, 'type' => $pages[$i]->type ]) }}">{{ $pages[$i]->title }}</option>

                        @endif


                    @endfor

                @endif

            </select>
        </div>
    </div>
</div>