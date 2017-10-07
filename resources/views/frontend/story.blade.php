@extends('layouts.frontend')
<?php setlocale(LC_TIME, 'Vietnamese');
//$arr[] = array('truyện sex');
$arr = explode(' ', $story->title);
$count_title = count($arr);

?>
@section('title')
    @if(count($story)!=0)
        {!! $story->title !!}
    @else
        Truyện không tồn tại
    @endif
@endsection
@section('content')
    <main>
        <div class="row" id="story">
            <div class="content col-md-9">
                @if(count($story)!=0)
                    <nav class="breadcrumb">
                        <a class="breadcrumb-item" href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
                        @foreach($types as $type)@if($type->id == $story->type)<a class="breadcrumb-item hover-link"
                                                                                  href="{{$type->name_unicode}}"> {{$type->name}}</a>@endif
                        @endforeach
                        <span class="breadcrumb-item active"><a class="hover-link"
                                                                href="{{ url($story->title_seo) }}">{!! $story->title !!}</a></span>
                    </nav>
                    <div class="description-story item">
                        <h4 id="name">{!! $story->title !!}</h4>
                        <div>
                            <small class="name story-r">Trang {{$paragraph_paginate['current_page']}}</small>
                        </div>
                        <span>
                <i class="fa fa-eye" aria-hidden="true"></i> {!! $story->view !!}&nbsp;-&nbsp;<i class="fa fa-clock-o"
                                                                                                 aria-hidden="true"> {{ time_elapsed_string($story->created_at) }}</i><br/>
                <i class="fa fa-tags" aria-hidden="true">
                  <a class="tag-story" href="{{url('/?timkiem=truyen-sex')}}">Truyện sex</a>
                    @for($i=0; $i<$count_title;$i++)
                        @if($i+1 < $count_title)
                            <a class="tag-story"
                               href="{{url('/?timkiem=' .  $arr[$i] . ' ' . $arr[$i+1] )}}">{{ $arr[$i] . ' ' . $arr[$i+1] }}</a>
                        @else
                            <a class="tag-story" href="{{url('/?timkiem=' .  $arr[$i])}}">{{ $arr[$i] }}</a>
                        @endif
                        <?php $i += 1; ?>
                    @endfor
                </i>
            </span>
                    </div>
                    <div class="item">
                        <p class="content-story">
                            {!! $paragraph_paginate['content'] !!}
                            <small class="name story-r">{{$paragraph_paginate['current_page']}}</small>
                        </p>
                    </div>
                    <ul class="pagination">
                        {{--pre--}}
                        @if ($paragraph_paginate['total_page'] > 1)
                            @if($paragraph_paginate['current_page'] == 1)
                                <li class="disabled"><span>&laquo;</span></li>
                            @else
                                <li>
                                    <a href="{{ url($story->title_seo)  . '?trang=' . ($paragraph_paginate['current_page']-1) }}"
                                       rel="prev">&laquo;</a></li>
                            @endif
                            @for($i=1; $i<=$paragraph_paginate['total_page']; $i++)
                                @if($i == $paragraph_paginate['current_page'])
                                    <li class="active"><span>{{$i}}</span></li>
                                @else
                                    <li><a href="{{ url($story->title_seo)  . '?trang=' . $i }}">{{$i}}</a></li>
                                @endif
                            @endfor
                            {{--next--}}
                            @if($paragraph_paginate['current_page'] == $paragraph_paginate['total_page'])
                                <li class="disabled"><span>&raquo;</span></li>
                            @else
                                <li>
                                    <a href="{{ url($story->title_seo)  . '?trang=' . ($paragraph_paginate['current_page']+1) }}"
                                       rel="next">&raquo;</a></li>
                            @endif
                        @endif
                    </ul>
                @else
                    <a href="{{url('/')}}" title="Trang chủ."><h5>Truyện không tồn tại...</h5></a>
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
                            <i class="fa fa-sign-language" aria-hidden="true"></i>Truyện liên quan
                        </p>
                        @foreach($involves as $key=>$involve)
                            <div class="item-sidebar">
                                <div class="item-story-sidebar">
                                    <p class="name"><a href="{{url($involve->title_seo)}}">{{$involve->title}}</a></p>
                                    <div class="story-w-r">
                                        @foreach($types as $type)
                                            @if($involve->type == $type->id)
                                                <small class="name story-r"><a href="{{$type->name_unicode}}"><i
                                                                class="fa fa-reply"></i>{{$type->name}}</a></small>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="stats">
                                        <i class="fa fa-eye" aria-hidden="true"></i> {{$involve->view}} -
                                        <i class="fa fa-clock-o" aria-hidden="true">
                                            <?php date_default_timezone_set("Asia/Ho_Chi_Minh");?>{{ time_elapsed_string($involve->created_at) }}
                                        </i>
                                    </div>
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
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{$top_30->view}} -
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
