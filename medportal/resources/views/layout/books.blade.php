@if($webconfig[0]->exhibition)
    <div class="books">
        <div class="innerwrapper">
            <div class="books_box">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left"><a class="books_pager_prev" href="javascript:void(0);"
                                            onClick="books_pager_prev();">&nbsp;</a></td>
                        <td align="center">
                            <div class="books_box_list">loading...</div>
                        </td>
                        <td align="right"><a class="books_pager_next" href="javascript:void(0);"
                                             onClick="books_pager_next();">&nbsp;</a></td>
                    </tr>
                </table>
                <div class="pager_btn">Loading...</div>
            </div>
        </div>
    </div>
@endif