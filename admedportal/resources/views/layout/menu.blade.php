<div class="menu">

    <div class="menu_box">
        <div class="title">@lang('ui.platform settings')</div>
        @if(Auth::user()->perm == 1)
            <a class="menu_A" href="{{ route('admin.browser') }}">@lang('ui.account management')</a>
            <a class="menu_B" href="{{ route('sys.edit') }}">@lang('ui.website settings')</a>
        @endif
        <a class="menu_I" href="{{ route('banner.index') }}">@lang('ui.banner management')</a>
        <a class="menu_C" href="{{ route('db.index') }}">@lang('ui.query database management')</a>
        <a class="menu_D" href="{{ route('book.index') }}">@lang('ui.book management')</a>
        <a class="menu_E" href="{{ route('news.index') }}">@lang('ui.news management')</a>
        <a class="menu_F" href="{{ route('menupage.index') }}">@lang('ui.webpage management')</a>
        {{--<a class="menu_G" href="">電子書管理</a>--}}
        <a class="menu_H" href="{{ route('lang.browser') }}">@lang('ui.message settings')</a>
    </div>

    <div class="menu_box">
        <div class="title">@lang('ui.statics information')</div>
        <a class="menu_list" href="{{ route('state.A') }}">@lang('ui.backend login times statics')</a>
        <a class="menu_list" href="{{ route('state.C') }}">@lang('ui.every webpage login times statics')</a>
    </div>
</div>