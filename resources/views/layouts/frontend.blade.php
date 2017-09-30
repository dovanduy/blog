<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{--font awesome--}}
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.css')}}"/>

    {{--my style--}}
    <link href="{{asset('frontend/styles.css')}}" rel="stylesheet"/>

    {{--selectize--}}
    <link href="{{asset('frontend/selectize/css/bootstrap2.css')}}" rel="stylesheet"/>
    <link href="{{asset('frontend/selectize/css/bootstrap3.css')}}" rel="stylesheet"/>
    <link href="{{asset('frontend/selectize/css/selectize.css')}}" rel="stylesheet"/>
    <link href="{{asset('frontend/selectize/css/default.css')}}" rel="stylesheet"/>
    <link href="{{asset('frontend/selectize/css/legacy.css')}}" rel="stylesheet"/>

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
                    <form method="GET" action="" class="form-inline my-2 my-lg-0">
                        <select style="width: 290px;" id="story-search" class="mr-sm-2" type="text"
                                placeholder="Tìm kiếm..." aria-label="Search"></select>
                        <button class="btn btn-outline-success my-2 my-sm-0 story-cursor" type="submit"><i
                                    class="fa fa-search"></i>&nbsp;&nbsp;Tìm...
                        </button>
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

{{--selectize--}}
<script src="{{asset('frontend/selectize/js/standalone/selectize.js')}}"></script>

<script src="{{asset('frontend/selectize/js/selectize.js')}}"></script>

<script>
    $('#story-search').selectize({
        valueField: 'id',
        labelField: 'name',
        searchField: ['name', 'phone_number'],
        create: true,
        maxItems: 1,
        maxOptions: 10,
        render: {
            option: function(item, escape) {
                return '<div>' +
                    '<span class="title">' +
                    '<span class="name">' + escape(item.name) + '</span>' +
                    '<span class="name">' + escape(item.phone_number) + '</span>' +
                    '</span>' +
                    '</div>';
            }
        },
        load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: '/users/search?type=stories&keyword=' + encodeURIComponent(query),
                type: 'GET',
                error: function() {
                    callback();
                },
                success: function(res) {
                    callback(res);
                }
            });
        }
    });
</script>

@yield('js')

</body>
</html>
