@if($webconfig[0]->list_db)
    <div class="search">
        <div class="search_db">
            <div class="innerwrapper">
                <div class="search_db_l">
                    <span class="search_db_title">{{$signal[0]->query}}：</span>
                    <span class="search_db_list">
                    @foreach($queryDb as $db)
                            <label><input type="radio" name="search_db_radio" value="{{ $db->id }}"
                                          onClick="SearchBox_show('{{ $db->id }}')">
                                @if($signal[0]->id=='0')
                                    {{ $db->database_name }}
                                @else
                                    <?php
                                    $name_i18n = $db->database_name;
                                    foreach ($db->db_i18ns as $db_i18n) {
                                        if ($db_i18n->language == $signal[0]->id) {
                                            if ($db_i18n->database_name != null) {
                                                $name_i18n = $db_i18n->database_name;
                                            }
                                            break;
                                        }
                                    }
                                    ?>
                                    {{ $name_i18n }}
                                @endif
                        </label>
                        @endforeach
                </span>
                </div>

                <div class="search_db_s">
                    <span class="search_db_title">{{$signal[0]->query}}：</span>
                    <span class="search_db_list">
                    <select onchange="SearchBox_show(this.value)">
                        @foreach($queryDb as $db)
                            <option value="{{ $db->id }}" onClick="SearchBox_show('{{ $db->id }}')">
                                @if($signal[0]->id=='0')
                                    {{ $db->database_name }}
                                @else
                                    <?php
                                    $name_i18n = $db->database_name;
                                    foreach ($db->db_i18ns as $db_i18n) {
                                        if ($db_i18n->language == $signal[0]->id) {
                                            if ($db_i18n->database_name != null) {
                                                $name_i18n = $db_i18n->database_name;
                                            }
                                            break;
                                        }
                                    }
                                    ?>
                                    {{ $name_i18n }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </span>
                </div>
            </div>
        </div>

        <div class="search_box" style="display: block;">
            <div class="innerwrapper">
                @if(count($queryDb) > 0)
                    @for($i = 0; $i < count($queryDb); $i++ )
                        <div class="search_box_in search_box_in_{{ $queryDb[$i]->id }}">
                            @if($signal[0]->id=='0')
                                {!! $queryDb[$i]->syntax !!}
                            @else
                                <?php
                                $syntax_i18n = $queryDb[$i]->syntax;
                                foreach ($queryDb[$i]->db_i18ns as $db_i18n) {
                                    if ($db_i18n->language == $signal[0]->id) {
                                        if ($db_i18n->syntax != null) {
                                            $syntax_i18n = $db_i18n->syntax;
                                        }
                                        break;
                                    }
                                }
                                ?>
                                {!! $syntax_i18n !!}
                            @endif
                        </div>
                    @endfor
                @endif
            </div>
        </div>
    </div>
@endif