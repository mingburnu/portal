<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="expires" content="0">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1">
    <title>
        @if($webconfig_i18n!=null && $webconfig_i18n[0]->site_name!=null)
            {{$webconfig_i18n[0]->site_name }}
        @else
            {{ $webconfig[0]->site_name }}
        @endif
    </title>
    <link rel="icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('templates/OwlCarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('templates/OwlCarousel/assets/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{ asset('templates/art_' . $webconfig[0]->color . '_l.css').'?v='.uniqid() }}">
    <link rel="stylesheet" href="{{ asset('templates/art_' . $webconfig[0]->color . '_s.css').'?v='.uniqid() }}"
          media="only screen and (max-width:640px)">
</head>