<script src="{{ asset('templates/jquery-1.11.3.min.js') }}"></script>
<script src="{{ asset('templates/matchMedia.js') }}"></script>
<script src="{{ asset('templates/art.js') }}"></script>
<script>
    $(document).ready(function () {
        //SearchBox 初始化
        var data = [];

        @if(isset($queryDb))
        @for($i = 0; $i < count($queryDb); $i++)
            data.push(['search_box_in_{{ $queryDb[$i]->id }}']);
        @endfor
        @endif

        SearchBox_init(data);

        //BooksBox 初始化
        var book = [];

        @if(isset($book))
        @for($i = 0; $i < count($book); $i++)
            @if(Cookie::get('language')==0)
                <?php
                $book_name = $book[$i]->book_name
                ?>
            @else
                <?php
                $book_name = $book[$i]->book_name;
                ?>
                @foreach($book[$i]['many'] as $book_i18n)
                    <?php
                    if ($book_i18n->language == Cookie::get('language') && $book_i18n->book_name != null) {
                        $book_name = $book_i18n->book_name;
                    }
                    ?>
                @endforeach
            @endif

            book.push(['{{ $book_name }}', '{{ $book[$i]->url }}', '{{ $book[$i]->cover }}']);
        @endfor
        @endif

        BooksBox_init(book);

    });

    //cssom
    $(window).bind('load', function () {
        SearchBox_show('load');
        Book_load_resize();
    });

    $(window).bind('resize', function () {
        Book_load_resize();
    });
</script>