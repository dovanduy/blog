@extends('layouts.frontend')
<?php setlocale(LC_TIME, 'Vietnamese');?>
@section('meta')
    <meta property="og:title" content="Trang chủ truyện 18+ | Truyện Sex" />
    <meta property="og:url" content="{{url()->current()}}" />
@endsection
@section('title')
    @if(!isset($_GET['timkiem']))Trang chủ - {{url()->current()}} @else Tìm kiếm @endif
@endsection
@section('content')
    <main>
        <div class="row">
            <div class="content col-md-9">
                <p class="content-title">
                    @if(!isset($_GET['timkiem']))<i class="fa fa-newspaper-o" aria-hidden="true"></i> Truyện mới cập nhật @else <i class="fa fa-search-plus" aria-hidden="true"></i> Tìm kiếm ... @endif
                </p>
                @if ($posts->count())
                @foreach($posts as $post)
                    <div class="item">
                        <h5 data-id="{{$post->id}}"><a href="{{ url($post->title_seo) }}">{{$post->title}}</a></h5>
                        <span><i class="fa fa-eye" aria-hidden="true">
                            </i>{{post_views($post->view)}}&nbsp;-&nbsp;<i class="fa fa-clock-o" aria-hidden="true">
                                <?php date_default_timezone_set("Asia/Ho_Chi_Minh");?>{{time_elapsed_string($post->created_at) }}
                            </i>
                        </span>
                        <a href="{{ url($post->title_seo) }}">
                            <p class="description">
                                {!! str_limit(strip_tags($post->content), $limit = 200, $end = '...') !!}
                            </p>
                        </a>
                    </div>

                    <div class="container">
                        <hr class="end-story">
                    </div>
                    
                @endforeach
                    {!! $posts->appends(request()->except('page'))->links() !!}
                @else
                    <a href="{{url('/')}}"><h5>Không có truyện nào ...</h5></a>
                @endif
            </div>
            <!-- // End content -->

            <!-- Start sidebar -->
            <div class="sidebar col-md-3">
                <div class="list-categories">
                    <p class="sidebar-title">
                        <i class="fa fa-th-list" aria-hidden="true"></i>Danh mục
                    </p>
                    <div class="categories">
                        @foreach($types as $type)
                            <div class="item-sidebar">
                                <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><a
                                        href="{{ url($type->name_unicode) }}">{{$type->name}}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{--//top 7--}}
                <div class="stories">
                    <div class="form-group">
                        <p class="sidebar-title">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>Top truyện 7 ngày
                        </p>
                        @foreach($tops_7 as $key=>$top_7)
                            <div class="item-sidebar">
                                <span class="rank-story-sidebar">{{$key+1}}</span>
                                <div class="item-story-sidebar">
                                    <p class="name"><a href="{{url($top_7->post->title_seo)}}">{{$top_7->post->title}}</a></p>
                                    <span class="stats">
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{post_views($top_7->post->view)}} -
                                    <i class="fa fa-clock-o"
                                       aria-hidden="true"> <?php date_default_timezone_set("Asia/Ho_Chi_Minh");?>{{ time_elapsed_string($top_7->post->created_at) }}</i>
                                </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{--//top 30--}}
                <div class="top-story">
                    <div class="form-group">
                        <p class="sidebar-title">
                            <i class="fa fa-calendar" aria-hidden="true"></i>Top truyện tháng
                        </p>
                        <div class="stories">
                            @foreach($tops_30 as $key=>$top_30)
                                <div class="item-sidebar">
                                    <span class="rank-story-sidebar">{{$key+1}}</span>
                                    <div class="item-story-sidebar">
                                        <p class="name"><a href="{{url($top_30->title_seo)}}">{{$top_30->title}}</a></p>
                                        <span class="stats">
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{post_views($top_30->view)}} -
                                    <i class="fa fa-clock-o"
                                       aria-hidden="true"> <?php date_default_timezone_set("Asia/Ho_Chi_Minh");?>{{ time_elapsed_string($top_30->created_at) }}</i>
                                </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- End sidebar -->

            </div>
        </div>
    </main>
@endsection