@extends('layouts.frontend')
<?php setlocale(LC_TIME, 'Vietnamese');?>
@section('content')
    <main>
        <div class="row" id="story">
            <div class="content col-md-9">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
                    <a class="breadcrumb-item" href="#">Thể loại</a>
                    <span class="breadcrumb-item active">Tên truyện</span>
                </nav>
                <div class="description-story item">
                    <p id="name">Title</p>
                    <span>
                <i class="fa fa-eye" aria-hidden="true"></i> 69 -
                <i class="fa fa-clock-o" aria-hidden="true"> 2 ngày trước</i><br/>
                <i class="fa fa-tags" aria-hidden="true">
                  <a href="#">tag 1</a>,
                  <a href="#">tag 2</a>
                </i>
            </span>
                </div>
                <!-- // End item 1 -->

                <div class="item">
                    <p class="content-story">
                        What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                        type and scrambled
                        it to make a type specimen book. It has survived not only five centuries, but also the leap into
                        electronic
                        typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release
                        of Letraset
                        sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like
                        Aldus PageMaker
                        including versions of Lorem Ipsum. Why do we use it? It is a long established fact that a reader
                        will be distracted
                        by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is
                        that it has
                        a more-or-less normal distribution of letters, as opposed to using 'Content here, content here',
                        making it
                        look like readable English. Many desktop publishing packages and web page editors now use Lorem
                        Ipsum as their
                        default model text, and a search for 'lorem ipsum' will uncover many web sites still in their
                        infancy. Various
                        versions have evolved over the years, sometimes by accident, sometimes on purpose (injected
                        humour and the
                        like). Where does it come from? Contrary to popular belief, Lorem Ipsum is not simply random
                        text. It has roots
                        in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard
                        McClintock, a Latin
                        professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words,
                        consectetur,
                        from a Lorem Ipsum passage, and going through the cites of the word in classical literature,
                        discovered the
                        undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum
                        et Malorum"
                        (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the
                        theory of ethics,
                        very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit
                        amet..", comes from
                        a line in section 1.10.32. The standard chunk of Lorem Ipsum used since the 1500s is reproduced
                        below for those
                        interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also
                        reproduced
                        in their exact original form, accompanied by English versions from the 1914 translation by H.
                        Rackham.<br/><br/>
                        In a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard
                        McClintock, a Latin
                        professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words,
                        consectetur,
                        from a Lorem Ipsum passage, and going through the cites of the word in classical literature,
                        discovered the
                        undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum
                        et Malorum"
                        (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the
                        theory of ethics,
                        very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit
                        amet..", comes from
                        a line in section 1.10.32. The standard chunk of Lorem Ipsum used since the 1500s is reproduced
                        below for those
                        interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also
                        reproduced
                        in their exact original form, accompanied by English versions from the 1914 translation by H.
                        Rackham.
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
