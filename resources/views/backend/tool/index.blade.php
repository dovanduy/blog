@extends('layouts.backend')

@section('content')
    @if ($errors->any())
        <div class="mes-page" style="position: absolute;z-index: 1;opacity: 0.9;left: 30%">
            <div class="alert alert-danger">
                <ul>
                    <li><strong>Lỗi !</strong></li>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    @if(session('mes'))
        <div class="mes-page" style="position: absolute;z-index: 1;opacity: 0.9;left: 30%">
            <div class="alert alert-success" role="alert">
                <strong>Thành công!</strong> {{session('mes')}}.
            </div>
        </div>
    @endif
    @if(session('er'))
        <div class="mes-page" style="position: absolute;z-index: 1;opacity: 0.9;left: 30%">
            <div class="alert alert-danger" role="alert">
                <strong>Lỗi!</strong> {{session('er')}}.
            </div>
        </div>
    @endif
    <div class="col-md-3 col-sm-3 height_page" style="overflow-y: scroll; height: auto">
        <div class="form-group">
            <div class="form-group">
                <h6>Hunter is my life:</h6>
            </div>

            <div class="form-group">
                <label for="select_site">Chọn các site sau:</label>
                <select class="form-control" id="select_site" name="select_site">
                    @foreach($sites as $site)
                        <option value="{{$site->id}}">{{ str_limit($site->site, $limit = 40, $end='...') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="short_content">Link truyện</label>
                <input type="url" class="form-control" id="get_site" name="get_site" placeholder="Link truyện" required>
            </div>
            <div class="form-inline">
                <div class="form-group">
                    <button type="button" title="Sẽ chuyển truyện sang phải" id="get_story" class="btn btn-info">Lấy truyện&nbsp;&nbsp;<span
                                class="fa fa-arrow-right"></span>
                    </button>
                </div>
                <div class="form-group">
                    <button class="btn btn-info">Auto&nbsp;&nbsp;<span class="fa fa-bolt"></span></button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <h4 style="color: #7da8c3">Các thể loại:</h4>
            @foreach($sites as $site)
                <div class="form-group">
                    <a href="{{url('admin/tool/siteDelete/' . $site->id)}}"
                       onclick="return window.confirm('Bạn muốn xóa?')"><span class="fa fa-close"
                                                                              style="color: #ff2222"></span></a>
                    <input type="text" class="form-control" value="{{$site->site}}" disabled>
                </div>
            @endforeach
        </div>
        <div class="form-group">
            <div class="form-group">
                <h3 style="color: #9c3328"><span class="fa fa-cogs"></span>&nbsp;&nbsp;Config</h3>
            </div>
            <form method="Post" action="{{route('tool.siteStory')}}">
                {{csrf_field()}}
                {{--<div class="form-group">--}}
                {{--<label for="site">Chọn site:</label>--}}
                {{--<select class="form-control" id="site">--}}
                {{--<option>...</option>--}}
                {{--</select>--}}
                {{--</div>--}}
                <div class="form-group">
                    <label for="search_site_2">Chọn site hoặc thêm site</label>
                    <input type="url" class="form-control" id="search_site_2" name="site" placeholder="Site"
                           autocomplete="off" required>
                    <div id="install_search_2"
                         style="position: absolute; background: #ffffff; width: 94%; border: 1px solid #ccd0d2; display: none;">
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="short_content">Config start title code</label>
                    <input type="text" class="form-control" id="start_title_code" name="start_title_code"
                           placeholder="Start title code" required>
                </div>
                <div class="form-group">
                    <label for="short_content">Config end title code</label>
                    <input type="text" class="form-control" id="end_title_code" name="end_title_code"
                           placeholder="End title code" required>
                </div>
                <hr>
                <div class="form-group">
                    <label for="short_content">Config start content code</label>
                    <input type="text" class="form-control" id="start_content_code" name="start_content_code"
                           placeholder="Start content code" required>
                </div>
                <div class="form-group">
                    <label for="short_content">Config end content code</label>
                    <input type="text" class="form-control" id="end_content_code" name="end_content_code"
                           placeholder="End content code" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" type="submit">Thay đổi hoặc thêm vào</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-9 col-sm-9 col-xs-12">
        <fieldset class="form-group">
            <legend>Tool truyện</legend>
        </fieldset>
        <form method="POST" action="{{route('post.postCreate')}}">
            {{csrf_field()}}
            <div class="form-group">
                <label for="title">Tiêu đề</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Nhập tiêu đề" required>
            </div>
            <div class="form-group">
                <label for="short_content">Title seo</label>
                <input class="form-control" id="title_seo" name="title_seo" placeholder="Title seo" required>
            </div>
            <div class="form-group">
                <label for="content">Nội dung</label>
                <textarea class="form-control" id="content" name="content_" placeholder="Nhập nội dung"
                          required></textarea>
            </div>
            <div class="form-group">
                <label for="type">Thể loại</label>
                <select class="form-control" id="type" name="type">
                    @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="status" checked value="1">
                    Trạng thái (Ẩn/hiện của bài viết)
                </label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default">Đăng bài</button>
                <button type="reset" class="btn btn-warning">Trạng thái rỗng</button>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script type="text/javascript">

        //short text search
        function shortTextSearch(text) {
            if (text.length > 30) {
                text = text.substring(0, 40) + "...";
            }
            return text;
        }

        CKEDITOR.replace('content');
        $(document).ready(function () {
            var timeout = null;
            $('#title, #title_seo').on('keyup', function () {
                clearTimeout(timeout);
                var title_seo = $(this).val();
                timeout = setTimeout(function () {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('ajax.validateTitleSeo') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'title_seo': title_seo
                        },
                        dataType: 'JSON',
                        timeout: 1000,
                        success: function (rsp) {
                            $('#title_seo').val(rsp);
                        },
                        error: function () {
                            location.reload();
                        }
                    })
                }, 800)
            });
        });
        setTimeout(function () {
            $('.mes-page').empty();
        }, 1500);
        //search site to cru(d) site 2
        $(document).ready(function () {
            var timeout = null;
            $('#search_site_2').on('keyup', function () {
                clearTimeout(timeout);
                var search_site = $(this).val();
                timeout = setTimeout(function () {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('tool.ajax.searchSite') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'search_site': search_site
                        },
                        dataType: 'JSON',
                        timeout: 1000,
                        success: function (rsp) {
                            var count_rsp = rsp.length;
                            if (count_rsp > 0) {
                                $('#install_search_2').empty();
                                $('#install_search_2').css({'display': 'block'});
                                for (var i = 0; i < count_rsp; i++) {
                                    $('#install_search_2').append('<div style="padding-left: 20px; margin-top: 20px; cursor: pointer" class="install_search" title="' + rsp[i] + '">' + shortTextSearch(rsp[i]) + '</div><hr>');
                                }
                            } else {
                                $('#install_search_2').empty();
                                $('#install_search_2').css({'display': 'none'});
                            }
                        },
                        error: function () {
                            location.reload();
                        }
                    })
                }, 800)
            });
        });
        $(document).on('click', '.install_search', function () {
            var value = $(this).attr('title');
            $('#search_site_2').val(value);
            $('#install_search_2').empty();
            $('#install_search_2').css({'display': 'none'});
            $('#search_site_2').blur(function () {
                $('#install_search_2').empty();
                $('#install_search_2').css({'display': 'none'});
            });
        });

        $('#search_site_2').blur(function () {
            if ($('.install_search').length > 0) {

            } else {
                $('#install_search_2').empty();
                $('#install_search_2').css({'display': 'none'});
            }
        });

        {{--//end search site to cru(d)--}}

        //height
        $(document).ready(function () {
            $height_current = $(window).height() - $('#app').height() - 70;
            $('.height_page').css({'height': $height_current});
        });

        //get story
        $(document).ready(function () {
            var timeout = null;
            clearTimeout(timeout);
            $('#get_story').click(function () {
                var get_site = $('#get_site').val();
                var select_site = $('#select_site').val();
                console.log(select_site);
                timeout = setTimeout(function () {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('tool.ajax.getStory') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'get_site': get_site,
                            'select_site' : select_site
                        },
                        dataType: 'JSON',
                        timeout: 1000,
                        success: function (rsp) {
//                            CKEDITOR.instances['content'].insertHtml(rsp[0]);
                            console.log(rsp);
                        },
                        error: function () {
//                            location.reload();
                        }
                    })
                }, 800)
                return false;
            });
        });

    </script>
@endsection