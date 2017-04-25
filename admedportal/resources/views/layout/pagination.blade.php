@if($table->lastPage()>1)
    <div class="bottom_box">
        <ul class="pagination">
            @if($table->currentPage()==1)
                <li class="disabled"><span>«</span></li>
            @else
                <li><a href="{{ $table->previousPageUrl() }}" rel="prev">«</a></li>
            @endif

            @for($p=1;$p<=$table->lastPage();$p++)
                @if($table->currentPage()==$p)
                    <li class="active"><span>{{$p}}</span></li>
                @else
                    <li><a href="{{ $table->url($p) }}">{{$p}}</a></li>
                @endif
            @endfor

            @if($table->currentPage()==$table->lastPage())
                <li class="disabled"><span>»</span></li>
            @else
                <li><a href="{{ $table->nextPageUrl() }}" rel="prev">»</a></li>
            @endif
        </ul>
    </div>
@endif