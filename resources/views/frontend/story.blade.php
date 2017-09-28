@extends('layouts.frontend')
<?php setlocale(LC_TIME, 'Vietnamese');?>
@section('content')
    <main>
        <div class="row" id="story">
            <div class="content col-md-9">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
                    @foreach($types as $type)@if($type->id == $story->type)<a class="breadcrumb-item hover-link" href="{{$type->name_unicode}}"> {{$type->name}}</a>@endif @endforeach
                    <span class="breadcrumb-item active"><a class="hover-link" href="{{ url($story->title_seo) }}">{!! $story->title !!}</a></span>
                </nav>
                <div class="description-story item">
                    <h4 id="name">{!! $story->title !!}</h4>
                    <span>
                <i class="fa fa-eye" aria-hidden="true"></i> {!! $story->view !!}&nbsp;-&nbsp;<i class="fa fa-clock-o" aria-hidden="true"> 2 ngày trước</i><br/>
                <i class="fa fa-tags" aria-hidden="true">
                  <a href="#">tag 1</a>,
                  <a href="#">tag 2</a>
                </i>
            </span>
                </div>
                <!-- // End item 1 -->

                <div class="item">
                    <p class="content-story">
                        {!! $story->content !!}
                    </p>
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
                <!-- // End item 2 -->
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
                            <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>Thể loại 1
                        </div>
                        <div id="item-sidebar">
                            <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>Thể loại 2
                        </div>
                        <div id="item-sidebar">
                            <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>Thể loại 3
                        </div>
                        <div id="item-sidebar">
                            <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>Thể loại 4
                        </div>
                        <div id="item-sidebar">
                            <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>Thể loại 5
                        </div>
                    </div>
                </div>

                <div class="cung-the-loai">
                    <p id="sidebar-title">
                        <i class="fa fa-folder-open" aria-hidden="true"></i>Cùng thể loại
                    </p>
                    <div id="categories">
                        <div id="item-sidebar">
                            <div class="item-story-sidebar">
                                <p id="name">Title</p>
                            </div>
                        </div>

                        <div id="item-sidebar">
                            <div class="item-story-sidebar">
                                <p id="name">Title</p>
                            </div>
                        </div>
                        <div id="item-sidebar">
                            <div class="item-story-sidebar">
                                <p id="name">Title</p>
                            </div>
                        </div>
                        <div id="item-sidebar">
                            <div class="item-story-sidebar">
                                <p id="name">Title</p>
                            </div>
                        </div>
                        <div id="item-sidebar">
                            <div class="item-story-sidebar">
                                <p id="name">Title</p>
                            </div>
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
                                <p id="name">Title</p>
                                <span id="stats">
                        <i class="fa fa-eye" aria-hidden="true"></i> 69 -
                        <i class="fa fa-clock-o" aria-hidden="true"> 2 ngày trước</i>
                      </span>
                            </div>
                        </div>

                        <div id="item-sidebar">
                            <span id="rank-story-sidebar-2">2</span>
                            <div class="item-story-sidebar">
                                <p id="name">Title</p>
                                <span id="stats">
                        <i class="fa fa-eye" aria-hidden="true"></i> 69 -
                        <i class="fa fa-clock-o" aria-hidden="true"> 2 ngày trước</i>
                      </span>
                            </div>
                        </div>
                        <div id="item-sidebar">
                            <span id="rank-story-sidebar-3">3</span>
                            <div class="item-story-sidebar">
                                <p id="name">Title</p>
                                <span id="stats">
                        <i class="fa fa-eye" aria-hidden="true"></i> 69 -
                        <i class="fa fa-clock-o" aria-hidden="true"> 2 ngày trước</i>
                      </span>
                            </div>
                        </div>
                        <div id="item-sidebar">
                            <span id="rank-story-sidebar-4">4</span>
                            <div class="item-story-sidebar">
                                <p id="name">Title</p>
                                <span id="stats">
                        <i class="fa fa-eye" aria-hidden="true"></i> 69 -
                        <i class="fa fa-clock-o" aria-hidden="true"> 2 ngày trước</i>
                      </span>
                            </div>
                        </div>
                        <div id="item-sidebar">
                            <span id="rank-story-sidebar-4">5</span>
                            <div class="item-story-sidebar">
                                <p id="name">Title</p>
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
