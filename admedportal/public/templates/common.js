var btn0 = $("a.btn_02:eq(0)");
var btn1 = $("a.btn_02:eq(1)");
var btn2 = $("a.btn_02:eq(2)");

function start(s) {
    $("span.active").removeClass();
    $("div.steps_box span:eq(" + s + ")").addClass("active");
    message_hide();
}

function getCurrentStep() {
    return $("span.active").html();
}