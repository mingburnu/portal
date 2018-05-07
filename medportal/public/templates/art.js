//本檔案為網頁設計師撰寫,非人請勿修改,以免未來維護困難,如果需修改可請找網頁設計師討論,感謝~
//cssom
$(window).bind('load resize', function() {	
	Menu_load_resize();
	Ad_load_resize();
});

//查詢區
var SearchBox_arr;
function SearchBox_init(arg){
	SearchBox_arr = arg;
}
function SearchBox_show(arg){
	if(arg == 'load'){
		//手機版與電腦版之控制
		if (window.matchMedia("(max-width:640px)").matches) {
			//640px以下
			//顯示選單式第一項目
			arg = '0';
		} else {
			//640px以上
			//抓第一項目的id並顯示第一項目
			var temp = SearchBox_arr[0].toString().split("_");
			arg = temp[3];
		}
	}
	
	
	//選擇資料庫之設定
	//radio
	$("input[name=search_db_radio]").prop('checked',false);
	$("input[name=search_db_radio][value='" + arg + "']").prop('checked',true);
	//select
	$('.search_db option').each(function(i, item){
		if($(item).val() == arg){
			$(item).prop('selected', true);
		}
	});
	
	
	//內容設定
	$(".search_box").hide();
	for(var i=0 ; i < SearchBox_arr.length ; i++){
		$("." + SearchBox_arr[i]).hide();
	}
	if(arg != '0'){
		$(".search_box").show();
		$(".search_box_in_" + arg).show();
	}
}

//Menu區
function Menu_load_resize(){
	var MenuWidth = 0;
	$('.menu_box_list ul li').each(function(i, item){
		MenuWidth += $(item).width();
	});
	MenuWidth += 40;
	
	if (window.matchMedia("(max-width:" + MenuWidth + "px)").matches) {
		//Menu寬度超過視窗時
		$(".menu").css({
			height:"auto",
			padding:"10px 0 10px 0"
		});
		$(".menu_box_list").css({
			display:"block",
			/*fontSize:"13px",*/
			position:"absolute",
			top:"-100em"
		});
		$(".menu_box_select").css({
			display:"block",
			position:"static",
			top:"0"
		});
	} else {
		//Menu寬度正常時
		$(".menu").css({
			height:"40px",
			padding:"0"
		});
		$(".menu_box_list").css({
			display:"block",
			/*fontSize:"13px",*/
			position:"static",
			top:"0"
		});
		$(".menu_box_select").css({
			display:"block",
			position:"absolute",
			top:"-100em"
		});
	}
}
function menu_box_select_chg(arg){
	if(arg.value){
		location.href = arg.value;
	}
}

//Books區
var BooksBox_arr;
var BooksBox_current_pageNum = 0;
var BooksBox_max_pageNum;
var BooksBox_current_width = "";

function BooksBox_init(arg){
	BooksBox_arr = arg;
}
function BooksBox_show(arg){
	BooksBox_current_pageNum = arg;
	//
	var newHtml = '';
	
	if (window.matchMedia("(max-width:640px)").matches) {
		//0~640px
		var book_num = 2;
		var book_width = "50%";
		
		BooksBox_max_pageNum = Math.ceil(BooksBox_arr.length / book_num)-1;
		//
		for(var i=(BooksBox_current_pageNum * book_num) ; i < ((BooksBox_current_pageNum * book_num) + book_num) ; i++){
			if(i < BooksBox_arr.length){
				newHtml +='<td style="width:' + book_width + ';" align="center"><a target="_blank" href="' + BooksBox_arr[i][1] + '"><img src="' + BooksBox_arr[i][2] + '" /></a></td>';
			}else{
				newHtml +='<td style="width:' + book_width + ';" align="center"> </td>';
			}	
		}
		newHtml += "</tr><tr>";
		for(var i=(BooksBox_current_pageNum * book_num) ; i < ((BooksBox_current_pageNum * book_num) + book_num) ; i++){
			if(i < BooksBox_arr.length){
				newHtml +='<td style="width:' + book_width + ';" align="center"><a target="_blank" href="' + BooksBox_arr[i][1] + '"><div>' + BooksBox_arr[i][0] + '</div></a></td>';
			}else{
				newHtml +='<td style="width:' + book_width + ';" align="center"> </td>';
			}	
		}
	} else if (window.matchMedia("(max-width:960px)").matches) {
		//640px~960px
		var book_num = 3;
		var book_width = "10%";
		
		BooksBox_max_pageNum = Math.ceil(BooksBox_arr.length / book_num)-1;
		//
		for(var i=(BooksBox_current_pageNum * book_num) ; i < ((BooksBox_current_pageNum * book_num) + book_num) ; i++){
			if(i < BooksBox_arr.length){
				newHtml +='<td style="width:' + book_width + ';" align="center"><a target="_blank" href="' + BooksBox_arr[i][1] + '"><img src="' + BooksBox_arr[i][2] + '" /></a></td>';
			}else{
				newHtml +='<td style="width:' + book_width + ';" align="center"> </td>';
			}	
		}
		newHtml += "</tr><tr>";
		for(var i=(BooksBox_current_pageNum * book_num) ; i < ((BooksBox_current_pageNum * book_num) + book_num) ; i++){
			if(i < BooksBox_arr.length){
				newHtml +='<td style="width:' + book_width + ';" align="center"><a target="_blank" href="' + BooksBox_arr[i][1] + '"><div>' + BooksBox_arr[i][0] + '</div></a></td>';
			}else{
				newHtml +='<td style="width:' + book_width + ';" align="center"> </td>';
			}	
		}
	} else {
		//960px~9999
		var book_num = 5;
		var book_width = "20%";
		
		BooksBox_max_pageNum = Math.ceil(BooksBox_arr.length / book_num)-1;
		//
		for(var i=(BooksBox_current_pageNum * book_num) ; i < ((BooksBox_current_pageNum * book_num) + book_num) ; i++){
			if(i < BooksBox_arr.length){
				newHtml +='<td style="width:' + book_width + ';" align="center"><a target="_blank" href="' + BooksBox_arr[i][1] + '"><img src="' + BooksBox_arr[i][2] + '" /></a></td>';
			}else{
				newHtml +='<td style="width:' + book_width + ';" align="center"> </td>';
			}	
		}
		newHtml += "</tr><tr>";
		for(var i=(BooksBox_current_pageNum * book_num) ; i < ((BooksBox_current_pageNum * book_num) + book_num) ; i++){
			if(i < BooksBox_arr.length){
				newHtml +='<td style="width:' + book_width + ';" align="center"><a target="_blank" href="' + BooksBox_arr[i][1] + '"><div>' + BooksBox_arr[i][0] + '</div></a></td>';
			}else{
				newHtml +='<td style="width:' + book_width + ';" align="center"> </td>';
			}	
		}
	}

	
	if(newHtml != ""){
		$(".books_box_list").empty();
		$(".books_box_list").html('<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>' + newHtml + '</tr></table>');
	}

	
	//上一頁
	if(BooksBox_current_pageNum == 0){
		$(".books_pager_prev").css("visibility","hidden");
	}else{
		$(".books_pager_prev").css("visibility","visible");
	}
	//下一頁
	if(BooksBox_current_pageNum < BooksBox_max_pageNum){
		$(".books_pager_next").css("visibility","visible");
	}else{
		$(".books_pager_next").css("visibility","hidden");
	}
	//頁數列
	var newHtml = '';
	if(0 < BooksBox_max_pageNum){
		for(var i=0 ; i <= BooksBox_max_pageNum ; i++){
			if(BooksBox_current_pageNum == i){
				newHtml +='<a href="javascript:void(0);" class="a_hover">&nbsp;</a>';
			}else{
				newHtml +='<a href="javascript:void(0);" onClick="BooksBox_show(' + i + ');">&nbsp;</a>';
			}
		}
	}
	$(".pager_btn").empty();
	$(".pager_btn").html(newHtml);
}
function Book_load_resize(){
	//這是防止手機閃掉畫面
	var temp;
	if(window.matchMedia("(max-width:640px)").matches){
		temp = "0-640";
	} else if (window.matchMedia("(max-width:960px)").matches) {
		temp = "640-960";
	}else{
		temp = "960-9999";
	}
	
	if(BooksBox_current_width != temp){
		BooksBox_show(0);
	}
	
	BooksBox_current_width = temp;
}
function books_pager_prev(){
	var temp = BooksBox_current_pageNum -= 1;
	BooksBox_show(temp);
}
function books_pager_next(){
	var temp = BooksBox_current_pageNum += 1;
	BooksBox_show(temp);
}

/*Banner區*/
function ShowInfo(arg){
	var t = $(arg).parent().find(".info_txt");
	if(t.css('opacity') == "1"){
		$(arg).parent().css("width","0");
		t.css("opacity","0");
	}else{
		$(arg).parent().css("width","500px");
		t.css("opacity","1");
	}
}

/*Ad區*/
function Ad_load_resize(){
	if($(".ad").length == 0){
		$(".books").css("margin-right","0px");
		$(".news_home").css("margin-right","0px");
	}
}