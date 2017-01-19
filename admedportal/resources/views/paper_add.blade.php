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
                        <form id="paper_add" method="POST" action="/paper_add/post">
                            {!! Form::open(['method' => 'POST','route'=>['paper.add.post']]) !!}
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>項目名稱</th>
                                    <td>
                                        @foreach($languages as $language)
                                            @if($language->id==0)
                                                <h3>{{$language->language}} (&#8226;)</h3>

                                                <div>
                                                    {!! Form::text('title',null,['class'=>'v_01']) !!}
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
                                    <th>類型</th>
                                    <td>
                                        <label>
                                            {!! Form::radio('type',true,true,['onclick'=>'chgShowField("url","txt");']) !!}
                                            網頁內容
                                        </label>
                                        <label>
                                            {!! Form::radio('type',false,false,['onclick'=>'chgShowField("txt","url");']) !!}
                                            連結
                                        </label>
                                    </td>
                                </tr>
                                <tr class="txt">
                                    <th>網頁內容</th>
                                    <td>
                                        <div class="accordion_01">
                                            @foreach($languages as $language)
                                                @if($language->id==0)
                                                    <h3>{{$language->language}} (&#8226;)</h3>

                                                    <div>
                                                        {!! Form::textarea('content',null,['id'=>$language->id.'_editor','cols'=>'80','rows'=>'10']) !!}
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
                                <tr class="url" style="">
                                    <th>連結</th>
                                    <td>
                                        @foreach($languages as $language)
                                            @if($language->id==0)
                                                <h3>{{$language->language}} (&#8226;)</h3>

                                                <div>
                                                    {!! Form::text('url',null) !!}
                                                </div>
                                            @else
                                                <h3>{{$language->language}}</h3>

                                                <div>
                                                    {!! Form::text($language->id.'_url',null) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>位置</th>
                                    <td>
                                        {!! Form::select('parent_id',$select) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>是否顯示</th>
                                    <td>
                                        <label>{!! Form::radio('view',true,['checked'=>true]) !!}是</label>
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
    for (var i = 1; i <= 7; i++) {
        $("form table tr:eq(" + i + ")").hide();
    }

    $("a.btn_02:eq(0)").hide();
    $("a.btn_02:eq(2)").hide();

    var total = parseInt('<?=sizeof($languages) ?>');
    for (var i = 0; i < total; i++) {
        CKEDITOR.replace(i + '_editor');
    }

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
                for (var i = 1; i <= 7; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                $("div.message").hide();
                $("a.btn_02:eq(0)").hide();
                $("a.btn_02:eq(1)").show();
                $("a.btn_02:eq(2)").hide();
                break;
            case 2 :
                if ($("span.active").html() == "1") {
                    var title_ch = $("input[name='title']").val()
                    if (title_ch == null || title_ch.trim() == "") {
                        message_show("<p>．請輸入標題。</p>");
                        break;
                    }
                }

                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                $("form table tr:eq(0)").hide();
                $("form table tr:eq(1)").show();
                for (var i = 4; i <= 7; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                var value = $("input[name='type']:checked").val();
                var option = value != null && value.trim() != "" && value != "0" && value != 0;
                if (option) {
                    chgShowField("url", "txt");
                } else {
                    chgShowField("txt", "url");
                }

                message_hide();
                $("a.btn_02:eq(0)").show();
                $("a.btn_02:eq(1)").show();
                $("a.btn_02:eq(2)").hide();
                break;

            case 3:
                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                for (var i = 0; i <= 3; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                for (var i = 4; i <= 7; i++) {
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
        document.getElementById('paper_add').submit();
    }
</script>
</body>
</html>