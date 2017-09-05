@extends('layouts.frontend')
<?php setlocale(LC_TIME, 'Vietnamese');?>
@section('content')
    <main>
        <div class="row">
            <div class="content col-md-9">
                <p id="content-title">
                    <i class="fa fa-newspaper-o" aria-hidden="true"></i> Truyện mới cập nhật
                </p>
                @foreach($posts as $post)

                    <div class="item">
                        <p data-id="{{$post->id}}"><a href="{{ url($post->title_seo) }}">{{$post->title}}</a></p>
                        <span>
                <i class="fa fa-eye" aria-hidden="true"></i> {{$post->view}} -
                <i class="fa fa-clock-o" aria-hidden="true"> <?php date_default_timezone_set("Asia/Ho_Chi_Minh");?>{{ time_elapsed_string($post->created_at) }}</i>
               </span>
                        <p id="description">
                            {!! $post->short_content !!}
                        </p>
                    </div>
                @endforeach

                <nav aria-label="paginationStory">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active">
                <span class="page-link">
                    2
                   <span class="sr-only">(current)</span>
                </span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>

            </div>
            <!-- // End content -->

            <!-- Start sidebar -->
            <div class="sidebar col-md-3">
                <div class="list-categories">
                    <p id="sidebar-title">
                        <i class="fa fa-th-list" aria-hidden="true"></i>Danh mục
                    </p>
                    <div id="categories">
                        <div id="item-sidebar">
                            <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><a href="#">Thể loại 1</a>
                        </div>
                        <div id="item-sidebar">
                            <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><a href="#">Thể loại 2</a>
                        </div>
                        <div id="item-sidebar">
                            <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><a href="#">Thể loại 3</a>
                        </div>
                        <div id="item-sidebar">
                            <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><a href="#">Thể loại 4</a>
                        </div>
                        <div id="item-sidebar">
                            <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><a href="#">Thể loại 5</a>
                        </div>
                    </div>
                </div>

                <div class="top-story">
                    <p id="sidebar-title">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>Top truyện
                    </p>
                    <div id="categories">
                        <div id="item-sidebar">
                            <span id="rank-story-sidebar-1">1</span>
                            <div class="item-story-sidebar">
                                <p id="name"><a href="#">Title</a></p>
                                <span id="stats">
                        <i class="fa fa-eye" aria-hidden="true"></i> 69 -
                        <i class="fa fa-clock-o" aria-hidden="true"> 2 ngày trước</i>
                      </span>
                            </div>
                        </div>

                        <div id="item-sidebar">
                            <span id="rank-story-sidebar-2">2</span>
                            <div class="item-story-sidebar">
                                <p id="name"><a href="#">Title</a></p>
                                <span id="stats">
                        <i class="fa fa-eye" aria-hidden="true"></i> 69 -
                        <i class="fa fa-clock-o" aria-hidden="true"> 2 ngày trước</i>
                      </span>
                            </div>
                        </div>
                        <div id="item-sidebar">
                            <span id="rank-story-sidebar-3">3</span>
                            <div class="item-story-sidebar">
                                <p id="name"><a href="#">Title</a></p>
                                <span id="stats">
                        <i class="fa fa-eye" aria-hidden="true"></i> 69 -
                        <i class="fa fa-clock-o" aria-hidden="true"> 2 ngày trước</i>
                      </span>
                            </div>
                        </div>
                        <div id="item-sidebar">
                            <span id="rank-story-sidebar-4">4</span>
                            <div class="item-story-sidebar">
                                <p id="name"><a href="#">Title</a></p>
                                <span id="stats">
                        <i class="fa fa-eye" aria-hidden="true"></i> 69 -
                        <i class="fa fa-clock-o" aria-hidden="true"> 2 ngày trước</i>
                      </span>
                            </div>
                        </div>
                        <div id="item-sidebar">
                            <span id="rank-story-sidebar-4">5</span>
                            <div class="item-story-sidebar">
                                <p id="name"><a href="#">Title</a></p>
                                <span id="stats">
                        <i class="fa fa-eye" aria-hidden="true"></i> 69 -
                        <i class="fa fa-clock-o" aria-hidden="true"> 2 ngày trước</i>
                      </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End sidebar -->

            </div>
        </div>
    </main>
@endsection
{{--</div>--}}

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
{{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/popper.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>--}}
{{--<script src="./js/custom.js"></script>--}}
{{--</body>--}}
{{--</html>--}}