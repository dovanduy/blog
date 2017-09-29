@extends('layouts.frontend')
<?php setlocale(LC_TIME, 'Vietnamese');?>
@section('content')
    <main>
        <div class="row">
            <div class="content col-md-9">
                <p class="content-title">
                    <i class="fa fa-newspaper-o" aria-hidden="true"></i> Truyện mới cập nhật
                </p>
                @foreach($posts as $post)
                    <div class="item">
                        <h5 data-id="{{$post->id}}"><a href="{{ url($post->title_seo) }}">{{$post->title}}</a></h5>
                        <span><i class="fa fa-eye" aria-hidden="true">
                            </i>{{$post->view}}&nbsp;-&nbsp;<i class="fa fa-clock-o" aria-hidden="true">
                                <?php date_default_timezone_set("Asia/Ho_Chi_Minh");?>{{time_elapsed_string($post->created_at) }}
                            </i>
                        </span>
                        <a href="{{ url($post->title_seo) }}">
                            <p class="description">
                                {!! str_limit($post->content, $limit = 200, $end = '...') !!}
                            </p>
                        </a>
                    </div>


                    <div class="container">
                        <hr class="end-story">
                    </div>
                @endforeach

                <nav aria-label="paginationStory">
                    @if ($posts->lastPage() > 1)
                        <ul class="pagination">
                            <li class="page-item{{ ($posts->currentPage() == 1) ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $posts->url(1) }}">Sau</a>
                            </li>
                            @if ($posts->lastPage() <=6)
                                @for ($i = 1; $i <= $posts->lastPage(); $i++)
                                    <li class="page-item{{ ($posts->currentPage() == $i) ? ' active' : '' }}">
                                        {!!  ($posts->currentPage() == $i) ? '<span class="page-link">'.$i.'<span class="sr-only">(current)</span>' : '<a class="page-link" href="'. $posts->url($i) .'">'. $i .'</a>' !!}
                                    </li>
                                @endfor
                            @else
                                @for ($i = 1; $i <= 3; $i++)
                                    @if($i <=3)
                                        <li class="page-item{{ ($posts->currentPage() == $i) ? ' active' : '' }}">
                                            {!!  ($posts->currentPage() == $i) ? '<span class="page-link">'.$i.'<span class="sr-only">(current)</span>' : '<a class="page-link" href="'. $posts->url($i) .'">'. $i .'</a>' !!}
                                        </li>
                                    @endif
                                @endfor

                                {{--page hien tai bang 3--}}
                                @if($posts->currentPage() ==3)
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="{{ $posts->url($posts->currentPage()+1) }}">{{$posts->currentPage()+1}}</a>
                                    </li>
                                @endif

                                @if($posts->currentPage() <= 3)
                                    <li class="page-item">
                                        <span class="page-link">...<span class="sr-only">(current)</span></span>
                                    </li>
                                @else
                                    @if($posts->currentPage() > 5)
                                        <li class="page-item">
                                            <span class="page-link">...<span class="sr-only">(current)</span></span>
                                        </li>
                                    @endif
                                @endif

                                {{--page hien ta page thu 5 tro len--}}
                                @if($posts->currentPage() >=4 &&$posts->currentPage() <= $posts->lastPage()-1)
                                    @if($posts->currentPage() == 4)
                                        <li class="page-item{{ ($posts->currentPage() == 4) ? ' active' : '' }}">
                                            {!!  ($posts->currentPage() == 4) ? '<span class="page-link">'. 4 .'<span class="sr-only">(current)</span>' : '<a class="page-link" href="'. $posts->url(4) .'">'. 4 .'</a>' !!}
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="{{ $posts->url($posts->currentPage()+1) }}">{{$posts->currentPage()+1}}</a>
                                        </li>
                                    @else

                                        @if($posts->currentPage()>=5 && $posts->currentPage() <= $posts->lastPage()-3)
                                            <li class="page-item">
                                                <a class="page-link"
                                                   href="{{ $posts->url($posts->currentPage()-1) }}">{{$posts->currentPage()-1}}</a>
                                            </li>
                                            <li class="page-item active">
                                                <span class="page-link">{{$posts->currentPage()}}<span class="sr-only">(current)</span></span>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link"
                                                   href="{{ $posts->url($posts->currentPage()+1) }}">{{$posts->currentPage()+1}}</a>
                                            </li>
                                        @endif
                                    @endif
                                @endif
                                {{--paginate end page ...--}}
                                @if($posts->lastPage() >=7)
                                    @if($posts->lastPage() == 7)
                                    @else
                                        @if($posts->currentPage() <=$posts->lastPage())
                                            <li class="page-item">
                                                <span class="page-link">...<span class="sr-only">(current)</span></span>
                                            </li>
                                        @endif
                                    @endif
                                @endif


                                {{--page hien tai la page cuoi -1 --}}
                                @if($posts->currentPage() == $posts->lastPage()-1)
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="{{ $posts->url($posts->currentPage()-1) }}">{{$posts->currentPage()-1}}</a>
                                    </li>
                                @endif

                                {{--page cuoi -2 tro len--}}
                                @if($posts->currentPage() == $posts->lastPage()-2)
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="{{ $posts->url($posts->currentPage()-1) }}">{{$posts->currentPage()-1}}</a>
                                    </li>
                                    <li class="page-item{{ ($posts->currentPage() == ($posts->lastPage()-2)) ? ' active' : '' }}">
                                        {!!  ($posts->currentPage() == $posts->lastPage()-2) ? '<span class="page-link">'. ($posts->lastPage()-2) .'<span class="sr-only">(current)</span>' : '<a class="page-link" href="'. $posts->url($posts->lastPage()-2) .'">'. ($posts->lastPage()-2) .'</a>' !!}
                                    </li>
                                @endif
                                {{--page cuoi -1--}}
                                @for($i=$posts->lastPage()-1; $i<=$posts->lastPage();$i++)
                                    <li class="page-item{{ ($posts->currentPage() == $i) ? ' active' : '' }}">
                                        {!!  ($posts->currentPage() == $i) ? '<span class="page-link">'. $i .'<span class="sr-only">(current)</span>' : '<a class="page-link" href="'. $posts->url($i) .'">'. $i .'</a>' !!}
                                    </li>
                                @endfor
                            @endif
                            <li class="page-item{{ ($posts->currentPage() == $posts->lastPage()) ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $posts->url($posts->currentPage()+1) }}">Trước</a>
                            </li>
                        </ul>
                    @endif
                </nav>

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
                                        href="#">{{$type->name}}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{--//top 30--}}
                <div class="top-story">
                    <div class="form-group">
                        <p class="sidebar-title">
                            <i class="fa fa-calendar" aria-hidden="true"></i>Top truyện tháng.
                        </p>
                        <div class="stories">
                            @foreach($tops_30 as $key=>$top_30)
                                <div class="item-sidebar">
                                    <span class="rank-story-sidebar">{{$key+1}}</span>
                                    <div class="item-story-sidebar">
                                        <p class="name"><a href="{{$top_30->title_seo}}">{{$top_30->title}}</a></p>
                                        <span class="stats">
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{$top_30->view}} -
                                    <i class="fa fa-clock-o"
                                       aria-hidden="true"> <?php date_default_timezone_set("Asia/Ho_Chi_Minh");?>{{ time_elapsed_string($top_30->created_at) }}</i>
                                </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{--//top 7--}}
                    <div class="stories">
                        <div class="form-group">
                            <p class="sidebar-title">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>Top truyện 7 ngày.
                            </p>
                            @foreach($tops_7 as $key=>$top_7)
                                <div class="item-sidebar">
                                    <span class="rank-story-sidebar">{{$key+1}}</span>
                                    <div class="item-story-sidebar">
                                        <p class="name"><a href="{{$top_7->title_seo}}">{{$top_7->title}}</a></p>
                                        <span class="stats">
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{$top_7->view}} -
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
{{--</div>--}}

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
{{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/popper.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>--}}
{{--<script src="./js/custom.js"></script>--}}
{{--</body>--}}
{{--</html>--}}