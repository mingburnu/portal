<div class="menu">
    <div class="innerwrapper">
        <div class="menu_box_list">
            <ul>
                <li>
                    @if(Route::currentRouteName()=='index')
                        <a class="menu_hover" href="{{ route('index') }}">
                            {{ $signal[0]->home }}
                        </a>
                    @else
                        <a href="{{ route('index') }}">
                            {{ $signal[0]->home }}
                        </a>
                    @endif
                </li>

                @foreach( $pages as $page)
                    <li>
                        <?php
                        $target = "";
                        if (!$page->type) {
                            $target = "_blank";
                        }
                        ?>

                        @if(Route::getCurrentRequest()->url()==route('pages.id', ['id' => $page->id]))
                            <a class="menu_hover" href="{{ $url = route('pages.id', ['id' => $page->id]) }}"
                               target="{{$target}}">

                                @if(Cookie::get('language')==0)
                                    {{ $page->title }}
                                @else
                                    <?php
                                    $title_i18n = $page->title;
                                    ?>
                                    @foreach($page->menupage_i18ns as $page_i18n)
                                        <?php
                                        if ($page_i18n->language == Cookie::get('language') && $page_i18n->title != null) {
                                            $title_i18n = $page_i18n->title;
                                        }
                                        ?>
                                    @endforeach
                                    {{ $title_i18n }}
                                @endif
                            </a>
                        @else
                            <a href="{{ $url = route('pages.id', ['id' => $page->id]) }}" target="{{$target}}">

                                @if(Cookie::get('language')==0)
                                    {{ $page->title }}
                                @else
                                    <?php
                                    $title_i18n = $page->title;
                                    ?>
                                    @foreach($page->menupage_i18ns as $page_i18n)
                                        <?php
                                        if ($page_i18n->language == Cookie::get('language') && $page_i18n->title != null) {
                                            $title_i18n = $page_i18n->title;
                                        }
                                        ?>
                                    @endforeach
                                    {{ $title_i18n }}
                                @endif
                            </a>
                        @endif

                        <ul>
                            @foreach($page->children as $child)
                                <li>
                                    <?php
                                    $target_child = "";
                                    if (!$child->type) {
                                        $target_child = "_blank";
                                    }
                                    ?>

                                    @if(Route::getCurrentRequest()->url()==route('pages.id', ['id' => $child->id]))
                                        <a class="menu_hover"
                                           href="{{ $url = route('pages.id', ['id' => $child->id]) }}"
                                           target="{{$target_child}}">
                                            @if(Cookie::get('language')==0)
                                                {{ $child->title }}
                                            @else
                                                <?php
                                                $child_title_i18n = $child->title;
                                                ?>
                                                @foreach($child->menupage_i18ns as $child_page_i18n)
                                                    <?php
                                                    if ($child_page_i18n->language == Cookie::get('language') && $child_page_i18n->title != null) {
                                                        $child_title_i18n = $child_page_i18n->title;
                                                    }
                                                    ?>
                                                @endforeach
                                                {{ $child_title_i18n }}
                                            @endif
                                        </a>
                                    @else
                                        <a href="{{ $url = route('pages.id', ['id' => $child->id]) }}"
                                           target="{{$target_child}}">
                                            @if(Cookie::get('language')==0)
                                                {{ $child->title }}
                                            @else
                                                <?php
                                                $child_title_i18n = $child->title;
                                                ?>
                                                @foreach($child->menupage_i18ns as $child_page_i18n)
                                                    <?php
                                                    if ($child_page_i18n->language == Cookie::get('language') && $child_page_i18n->title != null) {
                                                        $child_title_i18n = $child_page_i18n->title;
                                                    }
                                                    ?>
                                                @endforeach
                                                {{ $child_title_i18n }}
                                            @endif
                                        </a>
                                    @endif

                                </li>
                            @endforeach
                        </ul>
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