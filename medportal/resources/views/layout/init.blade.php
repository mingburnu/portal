<script src="{{ asset('templates/jquery-1.11.3.min.js') }}"></script>
<script src="{{ asset('templates/matchMedia.js') }}"></script>
<script src="{{ asset('templates/art.js').'?v='.uniqid() }}"></script>
<script src="{{ asset('templates/OwlCarousel/owl.carousel.js') }}"></script>
<script>
    var interval_bug_owlCarousel = setInterval("bug_owlCarousel()", 1000);

    $(document).ready(function () {
        //SearchBox 初始化
        var data = [];
        @for($i = 0; $i < count($queryDb); $i++)
            data.push(['search_box_in_{{ $queryDb[$i]->id }}']);
        @endfor

        SearchBox_init(data);

        //BooksBox 初始化
        var books = [];
        @if(isset($book))
        @for($i = 0; $i < count($book); $i++)
            @if($signal[0]->id=='0')
                <?php
                    $book_name = $book[$i]->book_name
                ?>
            @else
                <?php
                    $book_name = $book[$i]->book_name;
                    foreach ($book[$i]->book_i18ns as $book_i18n) {
                        if ($book_i18n->language == $signal[0]->id) {
                            if($book_i18n->book_name != null) {
                                $book_name = $book_i18n->book_name;
                            }
                            break;
                        }
                    }
                ?>
            @endif
        books.push(['{{ $book_name }}', '{{ $book[$i]->url }}', '{{ $book[$i]->cover }}']);
        @endfor
        @endif
        BooksBox_init(books);

        //owlCarousel 初始化
        setTimeout(function () {
            begin_owlCarousel();
        }, 500);
    });

    //cssom
    $(window).bind('load', function () {
        SearchBox_show('{{$queryDb[0]->id}}');
        Book_load_resize();
    });

    $(window).bind('resize', function () {
        Book_load_resize();
    });

    function begin_owlCarousel() {
        $('.owl-carousel').owlCarousel({
            loop: true,
            items: 1,
            autoHeight: true,
            autoplay: true,
            autoplayTimeout: 6000,
            smartSpeed: 1000,
            navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
            responsive: {
                0: {
                    margin: 10,
                    stagePadding: 0,
                    nav: false,
                    mouseDrag: true,
                    touchDrag: true
                },
                641: {
                    margin: 10,
                    stagePadding: 0,
                    nav: true,
                    mouseDrag: false,
                    touchDrag: false
                }
            }
        });
        $('.owl-carousel').on('resized.owl.carousel', function (event) {
            setTimeout(function () {
                $(".owl-nav .owl-prev").css("top", ($(".owl-height").height() / 2) - 40 + "px");
                $(".owl-nav .owl-next").css("top", ($(".owl-height").height() / 2) - 40 + "px");
            }, 500);
        });
    }
    function bug_owlCarousel() {
        if ($(".owl-theme .owl-nav").css("top") != null) {
            $(".owl-nav .owl-prev").css("top", ($(".owl-height").height() / 2) - 40 + "px");
            $(".owl-nav .owl-next").css("top", ($(".owl-height").height() / 2) - 40 + "px");
            clearInterval(interval_bug_owlCarousel);
        }
    }
</script>