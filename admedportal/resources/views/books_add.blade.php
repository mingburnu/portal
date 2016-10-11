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
                        </div>
                        <form id="book_id" method="POST" action="/books_add/post" enctype="multipart/form-data">
                            {!! Form::open(['method' => 'POST','route'=>['books.add.post']]) !!}
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>書名</th>
                                    <td>
                                        @foreach($languages as $language)
                                            <h3>{{$language->language.$language->required}}</h3>

                                            <div>
                                                {!! Form::text($language->id.'_book_name',null) !!}
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>書封(&#8226;)</th>
                                    <td>
                                        <div>
                                            使用方式：
                                            <label>{!! Form::radio('upload_option',true,true,['onclick'=>'chgShowField("group_02","pic");']) !!}
                                                上傳圖檔</label>
                                            <label>{!! Form::radio('upload_option',false,false,['onclick'=>'chgShowField("group_02","url");']) !!}
                                                圖檔網址</label>
                                        </div>

                                        <div class="group_02 pic">上傳圖檔：{!! Form::file('upload_file') !!}</div>
                                        <div class="group_02 url" style="display:none;">
                                            圖檔網址： {!! Form::text('cover',null) !!}</div>
                                        <div class="note_txt">圖檔尺寸大小不限制，前台會自動調整尺寸。</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>連結(&#8226;)</th>
                                    <td>{!! Form::text('url',null) !!}

                                        <div class="note_txt">格式必須為網址(含http://)，例如:http://www.google.com.tw</div>
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
                                    <td>{!! Form::text('rand_id',null,['class'=>'v_00']) !!}

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
                                           onClick="submit()">完成</a>
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
                        <div class="detail_note_content">
                            <span class="required">(&#8226;)</span>為必填欄位
                        </div>
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
    init();

    function init() {
        for (var i = 1; i <= 5; i++) {
            $("form table tr:eq(" + i + ")").hide();
        }

        var value = $("input[name='upload_option']:checked").val();
        var option = value != null && value.trim() != "" && value != "0" && value != 0;
        if (option) {
            chgShowField("group_02", "pic");
        } else {
            chgShowField("group_02", "url");
        }

        $("a.btn_02:eq(0)").hide();
        $("a.btn_02:eq(2)").hide();
    }

    function step(i) {
        switch (i) {
            case 1 :
                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                $("form table tr:eq(0)").show();
                for (var i = 1; i <= 5; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                $("div.message").hide();
                $("a.btn_02:eq(0)").hide();
                $("a.btn_02:eq(1)").show();
                $("a.btn_02:eq(2)").hide();
                break;

            case 2:
                if ($("span.active").html() == "1") {
                    var book_name_ch = $("input[name='0_book_name']").val()
                    if (book_name_ch == null || book_name_ch.trim() == "") {
                        message_show("<p>．請輸入書名。</p>");
                        break;
                    }
                }

                $("span.active").removeClass();
                $("div.steps_box span:eq(" + i + ")").addClass("active");
                for (var i = 0; i <= 0; i++) {
                    $("form table tr:eq(" + i + ")").hide();
                }

                for (var i = 1; i <= 5; i++) {
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
        var value = $("input[name='upload_option']:checked").val();
        var option = value != null && value.trim() != "" && value != "0" && value != 0;

        if (option) {
            if ($("input[name='upload_file']").val() == null || $("input[name='upload_file']").val() == "") {
                msg = msg.concat("<p>．請上傳書封。</p>");
            } else {
                if (window.FileReader && window.Blob) {
                    var mime = document.getElementsByName('upload_file')[0].files[0].type;
                    if (mime != "image/png" && mime != "image/jpeg" && mime != "image/gif") {
                        msg = msg.concat("<p>．請上傳書封。</p>");
                    }
                }
            }

        } else {
            if ($('input[name="cover"]').val() == null || $('input[name="cover"]').val().trim() == "") {
                msg = msg.concat("<p>．請輸入書封。</p>");
            } else {
                if (!$('input[name="cover"]').val().match(/^http([s]?):\/\/.*/)) {
                    msg = msg.concat("<p>．圖檔網址格式必須為網址(含http://)。</p>");
                }
            }
        }

        if ($('input[name="url"]').val() == null || $('input[name="url"]').val().trim() == "") {
            msg = msg.concat("<p>．請輸入連結。</p>");
        } else {
            if (!$('input[name="url"]').val().match(/^http([s]?):\/\/.*/)) {
                msg = msg.concat("<p>．連結格式必須為網址(含http://)。</p>");
            }
        }

        if (msg != "") {
            message_show(msg);
        } else {
            document.getElementById('book_id').submit();
        }
    }
</script>
</body>
</html>