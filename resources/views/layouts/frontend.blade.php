<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}

    {{--font awesome--}}
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.css')}}" />

    {{--my style--}}
    <link href="{{asset('frontend/styles.css')}}" rel="stylesheet" />
    @yield('css')

</head>
<body>
<div id="app">
    <div class="wrap">
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto"></ul>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </nav>
        </header>
        @yield('content')

        <footer>
            <span class="text-right">Copyright &copy; XXX</span>
        </footer>
    </div>
</div>

<!-- Scripts -->

{{--jquery--}}
<script src="{{ asset('jquery/jquery.min.js') }}"></script>

{{--popper--}}
<script src="{{ asset('frontend/js/popper.js') }}"></script>

<script src="{{asset('frontend/js/Bootstrap.js')}}"></script>

@yield('js')

</body>
</html>
