{{--<div>--}}
{{--{!! $queryDb[0]->syntax !!}--}}
{{--</div>--}}
<div class="search">
    <div class="search_db">
        <div class="innerwrapper">
            <div class="search_db_l">
                <span class="search_db_title">查詢資料庫：</span>
                <span class="search_db_list">
                    @foreach($queryDb as $db)
                        <label><input type="radio" name="search_db_radio" value="{{ $db->id }}"
                                      onClick="SearchBox_show('{{ $db->id }}')">
                            @if(Cookie::get('language')==0)
                                {{ $db->database_name }}
                            @else
                                <?php
                                $name_i18n = $db->database_name;
                                ?>
                                @foreach($db['many'] as $db_i18n)
                                    <?php
                                    if ($db_i18n->language == Cookie::get('language') && $db_i18n->database_name != null) {
                                        $name_i18n = $db_i18n->database_name;
                                    }
                                    ?>
                                @endforeach
                                {{ $name_i18n }}
                            @endif
                        </label>
                    @endforeach
                </span>
            </div>

            <div class="search_db_s">
                <span class="search_db_title">查詢資料庫：</span>
                <span class="search_db_list">
                    {{--<select onChange="SearchBox_show(this.value)">--}}
                    {{--<option value="{{ $queryDb[0]->rank_id }}">{{ $queryDb[0]->database_name }}</option>--}}
                    {{--</select>--}}
                </span>
            </div>
        </div>
    </div>

    <div class="search_box" style="display: block;">
        <div class="innerwrapper">
            @if(count($queryDb) > 0)
                @for($i = 0; $i < count($queryDb); $i++ )
                    <div class="search_box_in search_box_in_{{ $queryDb[$i]->id }}">
                        @if(Cookie::get('language')==0)
                            {!! $queryDb[$i]->syntax !!}
                        @else
                            <?php
                            $syntax_i18n = $queryDb[$i]->syntax;
                            ?>
                            @foreach($queryDb[$i]['many'] as $db_i18n)
                                <?php
                                if ($db_i18n->language == Cookie::get('language') && $db_i18n->syntax != null) {
                                    $syntax_i18n = $db_i18n->syntax;
                                }
                                ?>
                            @endforeach
                            {!! $syntax_i18n !!}
                        @endif
                    </div>
                @endfor
            @endif
        </div>
    </div>
</div>
<div>
</div>