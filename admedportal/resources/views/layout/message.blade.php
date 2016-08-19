@if(Session::get('error'))
    <div class="message_print_errer">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
                <td class="message_text">{{ Session::get('error') }}</td>
                <td class="message_close" valign="middle"><a href="javascript:void(0);"
                                                             onClick="message_print_errer_hide();">關閉</a>
                </td>
            </tr>
        </table>
    </div>
    @else
    <div class="message_print_errer" style="display: none">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
                <td class="message_text"></td>
                <td class="message_close" valign="middle"><a href="javascript:void(0);"
                                                             onClick="message_print_errer_hide();">關閉</a>
                </td>
            </tr>
        </table>
    </div>
@endif

@if(Session::get('success'))
    <div class="message_print_ok">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr valign="top">
                <td class="message_text">{{ Session::get('success') }}</td>
                <td class="message_close" valign="middle"><a href="javascript:void(0);"
                                                             onClick="message_print_ok_hide();">關閉</a>
                </td>
            </tr>
        </table>
    </div>
@endif