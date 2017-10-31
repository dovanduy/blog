<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="my web" />

    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="Truyện 18+ hay nhất, cập nhật mọi lúc" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="Truyện sex" />
    <meta property="og:description" content="Những truyện sex dâm nhất nhiều thể loại truyện sex hấp dẫn như loạn luân, anh em. Mời các bạn trên 18 tuổi theo dõi đọc truyện và cùng thủ dâm nhé" />
    @yield('meta')

    <meta property="article:tag" content="Nữ thần" />
    <meta property="article:tag" content="Thủ dâm" />
    <meta property="article:tag" content="Truyện anh và em" />
    <meta property="article:tag" content="truyện loạn luân" />
    <meta property="article:tag" content="truyện sex loạn luân" />
    <meta property="article:tag" content="truyện xxx" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    {{--font awesome--}}
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{asset('frontend/css/bootstrap.css')}}" rel="stylesheet"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    {{--my style--}}
    <link href="{{asset('frontend/styles.css')}}" rel="stylesheet"/>

    {{--selectize--}}
    <link href="{{asset('selectize/css/bootstrap2.css')}}" rel="stylesheet"/>
    <link href="{{asset('selectize/css/bootstrap3.css')}}" rel="stylesheet"/>
    <link href="{{asset('selectize/css/selectize.css')}}" rel="stylesheet"/>
    <link href="{{asset('selectize/css/default.css')}}" rel="stylesheet"/>
    <link href="{{asset('selectize/css/legacy.css')}}" rel="stylesheet"/>

    @yield('css')

</head>
<body>
<div id="app">
    <div class="wrap">
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="{{url('/')}}">Story</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto"></ul>
                    <div id="search-form-story" class="form-inline my-2 my-lg-0">
                        <select style="width: 290px;" id="story-search" class="mr-sm-2" type="text"
                                placeholder="Tìm kiếm..." aria-label="Search"></select>
                        <button class="btn btn-outline-success my-2 my-sm-0 story-cursor" id="search-story" type="submit"><i
                                    class="fa fa-search"></i>&nbsp;&nbsp;Tìm...
                        </button>
                    </div>
                </div>
            </nav>
        </header>
        @yield('content')

        <footer>
            <span class="text-right">Copyright &copy; XXX</span>
            <div class="text-bot"><i>@Tìm kiếm:</i><a href="{{url('/?timkiem=truyện%20xxx')}}"><small>Truyện xxx</small></a><i>|</i><a href="{{url('/?timkiem=truyện%20sex')}}"><small>Truyện sex</small></a><i>|</i><a href="{{url('/?timkiem=truyện%20loạn%20luân')}}"><small>truyện loạn luân</small></a><i>|</i><a href="{{url('/?timkiem=truyện%2018+')}}"><small>truyện 18+</small></a></div>
        </footer>
    </div>
</div>

<!-- Scripts -->

{{--jquery--}}
<script src="{{ asset('jquery/jquery.min.js') }}"></script>

{{--popper--}}
<script src="{{ asset('frontend/js/popper.js') }}"></script>

<script src="{{asset('frontend/js/Bootstrap.js')}}"></script>

{{--selectize--}}
<script src="{{asset('selectize/js/standalone/selectize.js')}}"></script>

<script src="{{asset('selectize/js/selectize.js')}}"></script>

{{--seach--}}
<script src="{{asset('frontend/js/search.js')}}"></script>

@yield('js')

</body>
</html>
