//本檔案為網頁設計師撰寫,非人請勿修改,以免未來維護困難,如果需修改可請找網頁設計師討論,感謝~
function message_show(arg){
	$("td.message_text").html(arg);
	$(".message_print_errer").show();
	$('html, body').animate({scrollTop:0}, 'fase');
}
function message_hide(){
	$("td.message_text").empty();
	$(".message_print_errer").hide();
}
function message_print_errer_hide(){
	$(".message_print_errer .message_text").empty();
	$(".message_print_errer").hide();
}
function message_print_ok_hide(){
	$(".message_print_ok .message_text").empty();
	$(".message_print_ok").hide();
}
function checkEmail(remail) {
	if (remail.search(/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/)!=-1) {
		return true;
	} else {
		return false;
	}
}
function chgShowField(arg1,arg2){
	$("." + arg1).hide();
	$("." + arg2).show();
}