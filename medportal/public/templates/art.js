//本檔案為網頁設計師撰寫,非人請勿修改,以免未來維護困難,如果需修改可請找網頁設計師討論,感謝~
//cssom
$(window).bind('load resize', function() {
	Menu_load_resize();
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
			fontSize:"13px",
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
			fontSize:"13px",
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

function BooksBox_init(arg){
	BooksBox_arr = arg;
}
function BooksBox_show(arg){
	BooksBox_current_pageNum = arg;
	//
	var newHtml = '';
	if (window.matchMedia("(max-width:640px)").matches) {
		//640px以下
		BooksBox_max_pageNum = Math.ceil(BooksBox_arr.length / 2)-1;
		//
		for(var i=(BooksBox_current_pageNum * 2) ; i < ((BooksBox_current_pageNum * 2) + 2) ; i++){
			if(i < BooksBox_arr.length){
				newHtml +='<li style="width:50%;"><a target="_blank" href="' + BooksBox_arr[i][1] + '"><img src="' + BooksBox_arr[i][2] + '" /><div>' + BooksBox_arr[i][0] + '</div></a></li>';
			}else{
				newHtml +='<li style="width:50%;"> </li>';
			}
		}
	} else {
		//640px以上
		BooksBox_max_pageNum = Math.ceil(BooksBox_arr.length / 5)-1;
		//
		for(var i=(BooksBox_current_pageNum * 5) ; i < ((BooksBox_current_pageNum * 5) + 5) ; i++){
			if(i < BooksBox_arr.length){
				newHtml +='<li style="width:20%;"><a target="_blank" href="' + BooksBox_arr[i][1] + '"><img src="' + BooksBox_arr[i][2] + '" /><div>' + BooksBox_arr[i][0] + '</div></a></li>';
			}else{
				newHtml +='<li style="width:20%;"> </li>';
			}
		}
	}
	$(".books_box_list").empty();
	$(".books_box_list").html(newHtml);
	//上一頁
	if(BooksBox_current_pageNum == 0){
		$(".books_pager_prev").hide();
	}else{
		$(".books_pager_prev").show();
	}
	//下一頁
	if(BooksBox_current_pageNum < BooksBox_max_pageNum){
		$(".books_pager_next").show();
	}else{
		$(".books_pager_next").hide();
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
	BooksBox_show(0);
}
function books_pager_prev(){
	var temp = BooksBox_current_pageNum -= 1;
	BooksBox_show(temp);
}
function books_pager_next(){
	var temp = BooksBox_current_pageNum += 1;
	BooksBox_show(temp);
}