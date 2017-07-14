@foreach($menus as $menu)
    <li>
        <?php
        $target = "";
        if (!boolval($menu->type)) {
            $target = "_blank";
        }
        ?>

        @if (Route::getCurrentRequest()->url()==route('pages.id', ['id' => $menu->id]))
            <a class="menu_hover" href="{{ $url = route('pages.id', ['id' => $menu->id]) }}" target="{{$target}}">
                @if($signal[0]->id=='0')
                    {{ $menu->title }}
                @else
                    <?php
                    $title_i18n = $menu->title;
                    foreach ($menu->menupage_i18ns as $menu_i18n) {
                        if ($menu_i18n->language == $signal[0]->id) {
                            if ($menu_i18n->title != null) {
                                $title_i18n = $menu_i18n->title;
                            }
                            break;
                        }
                    }
                    ?>
                    {{ $title_i18n }}
                @endif
            </a>
        @else
            <a href="{{ $url = route('pages.id', ['id' => $menu->id]) }}" target="{{$target}}">
                @if($signal[0]->id=='0')
                    {{ $menu->title }}
                @else
                    <?php
                    $title_i18n = $menu->title;
                    foreach ($menu->menupage_i18ns as $menu_i18n) {
                        if ($menu_i18n->language == $signal[0]->id) {
                            if ($menu_i18n->title != null) {
                                $title_i18n = $menu_i18n->title;
                            }
                            break;
                        }
                    }
                    ?>
                    {{ $title_i18n }}
                @endif
            </a>
        @endif

        @if($menu->children->count()>0)
            <ul>
                @include ('layout.list', ['menus' => $menu->children->sortByDesc('rank_id')])
            </ul>
        @endif
    </li>
@endforeach