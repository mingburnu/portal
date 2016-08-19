<div class="menu">

    <div class="menu_box">
        <div class="title">平台設定</div>
        <a class="menu_A" href="{{ route('admin.browser') }}">帳號管理</a>
        <a class="menu_B" href="{{ route('sys.edit') }}">網站設定</a>
        <a class="menu_C" href="{{ route('db.browser') }}">查詢資料庫管理</a>
        <a class="menu_D" href="{{ route('books.browser') }}">書籍管理</a>
        <a class="menu_E" href="{{ route('news.browser') }}">公告管理</a>
        <a class="menu_F" href="{{ route('paper.browser') }}">網頁管理</a>
    </div>

    <div class="menu_box">
        <div class="title">統計資訊</div>
        <a class="menu_list" href="{{ route('state.A') }}">後台登入次數統計</a>
        <a class="menu_list" href="{{ route('state.C') }}">各網頁登入次數統計</a>
    </div>

</div>