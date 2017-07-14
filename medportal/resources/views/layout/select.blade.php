@foreach($menus as $menu)
    <?php $mark = "";
    $parent = $menu->parent;

    while ($parent != null) {
        $mark = $mark . '└ ';
        $parent = $parent->parent;
    }
    ?>
    @if (Route::getCurrentRequest()->url()==route('pages.id', ['id' => $menu->id]))
        <option value="{{ $url = route('pages.id', ['id' => $menu->id]) }}" selected>
            {{$mark}}
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
        </option>
    @else
        <option value="{{ $url = route('pages.id', ['id' => $menu->id]) }}">
            {{$mark}}
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
        </option>
    @endif

    @if($menu->children->count()>0)
        @include ('layout.select', ['menus' => $menu->children->sortByDesc('rank_id')])
    @endif
@endforeach