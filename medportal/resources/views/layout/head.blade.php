<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="expires" content="0">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1">
    <title>
        @if(Cookie::get('language')==0)
            {{ $webconfig[0]->site_name }}
        @else
            @if($webconfig_i18n[0]->site_name!=null)
                {{$webconfig_i18n[0]->site_name }}
            @else
                {{ $webconfig[0]->site_name }}
            @endif
        @endif
    </title>
    <link rel="icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('templates/art_' . $webconfig[0]->color . '_l.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/art_' . $webconfig[0]->color . '_s.css') }}"
          media="only screen and (max-width:640px)">
</head>