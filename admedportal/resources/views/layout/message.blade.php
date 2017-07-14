@if(count($errors) > 0)
    <div class="message" style="display: block;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
                <td class="message_text">
                    @foreach ($errors->all() as $error)
                        <p>．{{ $error }}</p>
                    @endforeach
                </td>
                <td class="message_close" valign="middle"><a href="javascript:void(0);"
                                                             onClick="message_hide();">@lang('ui.close')</a>
                </td>
            </tr>
        </table>
    </div>
@else
    <div class="message" style="display: none">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
                <td class="message_text"></td>
                <td class="message_close" valign="middle"><a href="javascript:void(0);"
                                                             onClick="message_hide();">@lang('ui.close')</a>
                </td>
            </tr>
        </table>
    </div>
@endif

@if(Session::get('successes'))
    <div class="message_print_ok" style="display: block;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
                <td class="message_text">
                    @foreach (Session::get('successes') as $success)
                        <p>．{{ $success }}</p>
                    @endforeach
                </td>
                <td class="message_close" valign="middle"><a href="javascript:void(0);"
                                                             onClick="message_print_ok_hide();">@lang('ui.close')</a>
                </td>
            </tr>
        </table>
    </div>
@endif