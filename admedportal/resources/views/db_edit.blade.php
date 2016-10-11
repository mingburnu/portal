<!DOCTYPE html>
<html lang="zh-tw">
@include('layout.head')
<body>
<div class="wrapper">

    @include('layout.header')

    <div class="box">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
                <td class="td_1">
                    <!-- menu 區塊 Begin -->
                    @include('layout.menu')
                            <!-- menu 區塊 End -->
                </td>
                <td class="td_2">
                    <!-- 內容 區塊 Begin -->

                    <!-- message 區塊 Begin -->
                    @include('layout.message')
                            <!-- message 區塊 End -->


                    <!-- detail 區塊 Begin -->
                    <div class="detail_box">
                        <div class="steps_box">
                            <span class="title">步驟</span>
                            <span class="active">1</span>
                            <span>2</span>
                            <span>3</span>
                        </div>
                        <form id="database_id" method="POST" action="/db_edit/{{$querydatabase[0]->id}}">
                            {!! Form::model($querydatabase[0],['method' => 'PATCH','route'=>['db.edit.post',$querydatabase[0]->id]]) !!}
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>資料庫名稱</th>
                                    <td>
                                        @foreach($languages as $language)
                                            @if($language==$languages[0])
                                                <h3>{{$language->language.$language->required}}</h3>

                                                <div>
                                                    {!! Form::text($language->id.'_database_name',$querydatabase[0]->database_name,['class'=>'v_01']) !!}
                                                </div>
                                            @elseif($querydatabase_i18n!=null && $querydatabase_i18n[$language->id-1]!=null )
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::text($language->id.'_database_name',$querydatabase_i18n[$language->id-1]->database_name,['class'=>'v_01']) !!}
                                                </div>
                                            @else
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::text($language->id.'_database_name',null,['class'=>'v_01']) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>嵌入語法</th>
                                    <td>
                                        @foreach($languages as $language)
                                            @if($language==$languages[0])
                                                <h3>{{$language->language.$language->required}}</h3>

                                                <div>
                                                    {!! Form::textarea($language->id.'_syntax',$querydatabase[0]->syntax) !!}
                                                </div>
                                            @elseif($querydatabase_i18n!=null && $querydatabase_i18n[$language->id-1]!=null )
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::textarea($language->id.'_syntax',$querydatabase_i18n[$language->id-1]->syntax) !!}
                                                </div>
                                            @else
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::textarea($language->id.'_syntax',null) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>是否顯示</th>
                                    <td>
                                        <label>{!! Form::radio('view',true) !!}是</label>
                                        <label>{!! Form::radio('view',false) !!}否</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>排序</th>
                                    <td>
                                        {!! Form::text('rank_id',null,['class'=>'v_00']) !!}
                                        <div class="note_txt">數字愈大，順序愈前面。</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>備註</th>
                                    <td> {!! Form::textarea('note',null,['rows'=>'5']) !!}</td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02"
                                           onClick="step(parseInt($('span.active').html())-1)">上一步</a>
                                        <a class="btn_02"
                                           onClick="step(parseInt($('span.active').html())+1)">下一步</a>
                                        <a class="btn_02"
                                           onClick="document.getElementById('database_id').submit();">完成</a>
                                    </td>
                                </tr>
                            </table>
                            {!! Form::close() !!}
                        </form>
                    </div>
                    <!-- detail 區塊 End -->

                    <!-- Note 區塊 Begin -->
                    <div class="detail_note">
                        <div class="detail_note_title">Note</div>
                        <div class="detail_note_content"><span class="required">(&#8226;)</span>為必填欄位</div>
                    </div>
                    <!-- Note 區塊 End -->

                    <!-- 內容 區塊 End -->
                </td>
            </tr>
        </table>
    </div>

    @include('layout.footer')

</div>

<!-- 執行javascript 區塊 Begin -->
@include('layout.javascript')
        <!-- 執行javascript 區塊 End -->
<script>
    for (var i = 1; i <= 4; i++) {
        $("form table tr:eq(" + i + ")").hide();
    }

    $("a.btn_02:eq(0)").hide();
    $("a.btn_02:eq(2)").hide();

    function step(i) {
        switch (i) {
            case 1 :
                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                $("form table tr:eq(0)").show();
                for (var i = 1; i <= 4; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                $("div.message").hide();
                $("a.btn_02:eq(0)").hide();
                $("a.btn_02:eq(1)").show();
                $("a.btn_02:eq(2)").hide();
                break;
            case 2 :
                if ($("span.active").html() == "1") {
                    var database_name_ch = $("input[name='0_database_name']").val()
                    if (database_name_ch == null || database_name_ch.trim() == "") {
                        message_show("<p>．請輸入資料庫名稱。</p>");
                        break;
                    }
                }

                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                for (var i = 0; i <= 4; i++) {
                    switch (i) {
                        case 1:
                            $("form table tr:eq(" + i + ")").show();
                            break;
                        default:
                            $("form table tr:eq(" + i + ")").hide();
                    }
                }

                message_hide();
                $("a.btn_02:eq(0)").show();
                $("a.btn_02:eq(1)").show();
                $("a.btn_02:eq(2)").hide();
                break;

            case 3:
                if ($("span.active").html() == "2") {
                    var syntax_ch = $("textarea[name='0_syntax']").val()
                    if (syntax_ch == null || syntax_ch.trim() == "") {
                        message_show("<p>．請輸入嵌入語法。</p>");
                        break;
                    }
                }

                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");

                for (var i = 1; i <= 4; i++) {
                    switch (i) {
                        case 1:
                            $("form table tr:eq(" + i + ")").hide();
                            break;
                        default:
                            $("form table tr:eq(" + i + ")").show();
                    }
                }

                message_hide();
                $("a.btn_02:eq(0)").show();
                $("a.btn_02:eq(1)").hide();
                $("a.btn_02:eq(2)").show();
                break;
        }
    }
</script>
</body>
</html>
