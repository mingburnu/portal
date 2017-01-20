<div class="menu">
    <div class="innerwrapper">
        <div class="menu_box_list">
            <ul>
                <li><a class="menu_hover" href="{{ route('index') }}">首頁</a></li>

                @foreach( $pages as $page)
                    <li>
                        <?php
                        $target = "";
                        if (!$page->type) {
                            $target = "_blank";
                        }
                        ?>
                        <a href="{{ $url = route('pages.id', ['id' => $page->id]) }}" target="{{$target}}">

                            @if(Cookie::get('language')==0)
                                {{ $page->title }}
                            @else
                                <?php
                                $title_i18n = $page->title;
                                ?>
                                @foreach($page['many'] as $page_i18n)
                                    <?php
                                    if ($page_i18n->language == Cookie::get('language') && $page_i18n->title != null) {
                                        $title_i18n = $page_i18n->title;
                                    }
                                    ?>
                                @endforeach
                                {{ $title_i18n }}
                            @endif
                        </a>
                        @foreach($page->children as $child)
                            <ul>
                                <?php
                                $target_child = "";
                                if (!$page->type) {
                                    $target_child = "_blank";
                                }
                                ?>
                                <a href="{{ $url = route('pages.id', ['id' => $page->id]) }}" target="{{$target_child}}">
                                    @if(Cookie::get('language')==0)
                                        {{ $child->title }}
                                    @else
                                        <?php
                                        $child_title_i18n = $child->title;
                                        ?>
                                        @foreach($child['many'] as $child_page_i18n)
                                            <?php
                                            if ($child_page_i18n->language == Cookie::get('language') && $child_page_i18n->title != null) {
                                                $child_title_i18n = $child_page_i18n->title;
                                            }
                                            ?>
                                        @endforeach
                                        {{ $child_title_i18n }}
                                    @endif
                                </a>
                            </ul>
                        @endforeach

                    </li>
                @endforeach
            </ul>
        </div>

        <div class="menu_box_select">
        <select onChange="menu_box_select_chg(this);">
        <option value="{{ route('index') }}" selected>首頁</option>

        @if(count($pages) > 0)

        @for( $i = 0; $i < count($pages); $i++)

        @if($pages[$i]->type)

        <option value="{{ $url = route('pages.id', ['id' => $pages[$i]->id]) }}">{{ $pages[$i]->title }}</option>

        @else

        <option value="{{ $url = route('pages.id', ['id' => $pages[$i]->id, 'type' => $pages[$i]->type ]) }}">{{ $pages[$i]->title }}</option>

        @endif


        @endfor

        @endif

        </select>
        </div>
    </div>
</div>