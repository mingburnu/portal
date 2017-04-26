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

                @include('layout.list')

            </ul>
        </div>

        <div class="menu_box_select">
            <select onChange="menu_box_select_chg(this);">
                @if(Route::currentRouteName()=='index')
                    <option value="{{ route('index') }}" selected>{{ $signal[0]->home }}</option>
                @else
                    <option value="{{ route('index') }}">{{ $signal[0]->home }}</option>
                @endif

                @include('layout.select')

            </select>
        </div>
    </div>
</div>