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
                        <form id="news_edit" method="POST" action="/news_edit/{{$news[0]->id}}">
                            {!! Form::model($news[0],['method' => 'PATCH','route'=>['news.edit.post',$news[0]->id]]) !!}

                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <th>標題</th>
                                    <td>
                                        @foreach($languages as $language)
                                            @if($language==$languages[0])
                                                <h3>{{$language->language.$language->required}}</h3>

                                                <div>
                                                    {!! Form::text($language->id.'_title',$news[0]->title) !!}
                                                </div>
                                            @elseif($news_i18n!=null && $news_i18n[$language->id-1]!=null )
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::text($language->id.'_title',$news_i18n[$language->id-1]->title) !!}
                                                </div>
                                            @else
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::text($language->id.'_title',null) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>內容</th>
                                    <td>
                                        <div class="accordion_01">
                                            @foreach($languages as $language)
                                                @if($language==$languages[0])
                                                    <h3>{{$language->language.$language->required}}</h3>

                                                    <div>
                                                        {!! Form::textarea($language->id.'_content',$news[0]->content,['id'=>$language->id.'_editor','cols'=>'80','rows'=>'10']) !!}
                                                    </div>
                                                @elseif($news_i18n!=null && $news_i18n[$language->id-1]!=null )
                                                    <h3>{{$language->language}}</h3>

                                                    <div>
                                                        {!! Form::textarea($language->id.'_content',$news_i18n[$language->id-1]->content,['id'=>$language->id.'_editor','cols'=>'80','rows'=>'10']) !!}
                                                    </div>
                                                @else
                                                    <h3>{{$language->language}}</h3>

                                                    <div>
                                                        {!! Form::textarea($language->id.'_content',null,['id'=>$language->id.'_editor','cols'=>'80','rows'=>'10']) !!}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="note_txt">
                                            注意事項:<BR/>
                                            ▲編輯內文的連結時，連結的顏色儘量不手動設定，前台系統會自動預設。<BR/>
                                            ▲插入影像圖時，為了保持手機版品質，寬度建議設定為600px。<BR/>
                                            ▲插入影像圖時，為了保持手機版品質，建議該圖左右側邊為空白，而且放置中間。<BR/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>公告時間(•)</th>
                                    <td>
                                        {!! Form::text('publish_time',null,array('id'=>'datepicker','class'=>'v_01','style'=>'width:180px;')) !!}

                                        {!! Form::select('hh', $hours) !!} 時
                                        {!! Form::select('mm', $minuteSeconds) !!} 分
                                        {!! Form::select('ss', $minuteSeconds) !!} 秒
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
                                    <th>備註</th>
                                    <td>{!! Form::textarea('note',null,['rows'=>'5']) !!}</td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <a class="btn_02"
                                           onClick="step(parseInt($('span.active').html())-1)">上一步</a>
                                        <a class="btn_02"
                                           onClick="step(parseInt($('span.active').html())+1)">下一步</a>
                                        <a class="btn_02"
                                           onClick="submit();">完成</a>
                                    </td>
                                </tr>
                                </tbody>
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

    var total = parseInt('<?=sizeof($languages) ?>');
    for (var i = 0; i < total; i++) {
        CKEDITOR.replace(i + '_editor');
    }
    //
    $(".accordion_01").accordion({heightStyle: "content"});

    $("#datepicker").datepicker({
        dateFormat: "yy-mm-dd"
    });

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
                    var title_ch = $("input[name='0_title']").val()
                    if (title_ch == null || title_ch.trim() == "") {
                        message_show("<p>．請輸入標題。</p>");
                        break;
                    }
                }

                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                for (var i = 0; i <= 4 && i != 1; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }
                $("form table tr:eq(1)").show();
                message_hide();
                $("a.btn_02:eq(0)").show();
                $("a.btn_02:eq(1)").show();
                $("a.btn_02:eq(2)").hide();
                break;

            case 3:
                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                for (var i = 0; i <= 1; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                for (var i = 2; i <= 4; i++) {
                    $("form table tr:eq(" + i + ")").show();
                }

                message_hide();
                $("a.btn_02:eq(0)").show();
                $("a.btn_02:eq(1)").hide();
                $("a.btn_02:eq(2)").show();
                break;
        }
    }

    function submit() {
        var msg = "";
        var value = $("input[name='publish_time']").val();

        if (value == null || value.trim() == "") {
            msg = "<p>．請輸入公告時間。</p>";
        }

        if (msg != "") {
            message_show(msg);
        } else {
            document.getElementById('news_edit').submit();
        }
    }
</script>
</body>
</html>