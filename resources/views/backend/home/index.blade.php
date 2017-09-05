@extends('layouts.backend')
@section('content')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <h4>Số truyện đăng của bạn trong tuần: </h4>
            <div id="chart_user_div" style="height: 500px"></div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <h4>Tổng Hợp số truyện đăng trong tuần: </h4>
            <div id="chart_div" style="height: 500px"></div>
        </div>
    </div>

    {{--<div class="col-md-12 col-sm-12 col-xs-12">--}}
        {{--<div class="x_panel tile fixed_height_320 widget-custom-padding">--}}
            {{--<div class="content">--}}
                {{--<h4>Tất cả các bài viết.</h4>--}}
            {{--</div>--}}
            {{--<div class="content">--}}
                {{--<table class="table table-hover">--}}
                    {{--<thead>--}}
                    {{--<tr>--}}
                        {{--<th>STT</th>--}}
                        {{--<th>Tài khoản</th>--}}
                        {{--<th>Số lượt đăng trong tuần</th>--}}
                        {{--<th>Nội dung</th>--}}
                        {{--<th>Nội dung ngắn</th>--}}
                        {{--<th>Trạng thái</th>--}}
                        {{--<th>Ngày đăng</th>--}}
                        {{--<th></th>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}

                    {{--</tbody>--}}
                {{--</table>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@endsection
@section('js')
    <script src="{{ asset('chart-gg/chart.js') }}"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawChartUser);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Ngày', 'Truyện', 'Lượt xem'],
                    @for($i=0; $i<count($chart['days']); $i++)
                ['{{$chart['days'][$i]}}',{{$chart['data'][$i]}}, {{$chart['views'][$i]}}],
                @endfor
            ]);

            var options = {
                hAxis: {title: 'Tất cả truyện trong tuần qua',  titleTextStyle: {color: '#333'}},
                vAxis: {minValue: 0}
            };

            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }

        function drawChartUser() {
            var data = google.visualization.arrayToDataTable([
                ['Ngày', 'Truyện', 'Lượt xem'],
                    @for($i=0; $i<count($chart_user['days']); $i++)
                ['{{$chart_user['days'][$i]}}',{{$chart_user['data'][$i]}},{{$chart_user['views'][$i]}}],
                @endfor
            ]);

            var options = {
                hAxis: {title: 'Tất cả truyện của bạn đăng trong tuần qua',  titleTextStyle: {color: '#333'}},
                vAxis: {minValue: 0}
            };

            var chart = new google.visualization.AreaChart(document.getElementById('chart_user_div'));
            chart.draw(data, options);
        }
    </script>
@endsection
