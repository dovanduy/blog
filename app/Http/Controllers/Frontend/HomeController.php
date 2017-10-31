<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Type;
use App\View;
use Auth;

class HomeController extends Controller
{
    //
    public function __construct()
    {
        Auth::logout();
    }

    public function index(Request $request) {
        $types = Type::all();
        $type_dcd = json_decode(Type::pluck('name_unicode'));
        $list_seo = ['truyenxxx', 'truyen-nguoi-lon', 'truyen-18', 'truyenxx'];

        if($request->timkiem) {
            if(in_array(categoryStory($request->timkiem), $list_seo)) {
                $posts = Post::whereStatus(1)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(15);
            } elseif (in_array(categoryStory($request->timkiem), $type_dcd)) {
                $id = Type::select('id')->whereName_unicode(categoryStory($request->timkiem))->first();
                $posts = Post::whereStatus(1)
                    ->whereType($id->id)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(15);
            } else {
                $posts = Post::whereStatus(1)
                    ->where('title_seo', 'like', '%' . categoryStory($request->timkiem) . '%')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(15);
            }
        } else {
            $posts = Post::with('User')->whereStatus('1')->orderBy('created_at', 'DESC')->paginate(15);
        }

        $post_views_id = json_decode(View::pluck('post_id'));
        foreach ($post_views_id as $val) {
            $count_view_story_id = View::wherePost_id($val)->first();
            if (count($count_view_story_id) != 0) {
                $time_db_now = date('Y-m-d', strtotime($count_view_story_id->updated_at));
                $time_now = date('Y-m-d', time());
                if($time_db_now != $time_now) {
                    if ($time_db_now != $time_now) {
                        $time_old = strtotime($time_now) - strtotime($time_db_now);
                        $day = $time_old / (3600 * 24);

                        switch ($day) {
                            case 1:
                                $day_2 = $count_view_story_id->today;
                                $day_3 = $count_view_story_id->day_2;
                                $day_4 = $count_view_story_id->day_3;
                                $day_5 = $count_view_story_id->day_4;
                                $day_6 = $count_view_story_id->day_5;
                                $day_7 = $count_view_story_id->day_6;
                                $day_8 = $count_view_story_id->day_7;

                                $count_view_story_id->today = 0;
                                $count_view_story_id->day_2 = $day_2;
                                $count_view_story_id->day_3 = $day_3;
                                $count_view_story_id->day_4 = $day_4;
                                $count_view_story_id->day_5 = $day_5;
                                $count_view_story_id->day_6 = $day_6;
                                $count_view_story_id->day_7 = $day_7;
                                $count_view_story_id->day_8 = $day_8;

                                $count_view_story_id->total = (int)$day_2 + (int)$day_3 + (int)$day_4 + (int)$day_5 + (int)$day_6 + (int)$day_7 + (int)$day_8;
                                $count_view_story_id->save();
                                break;
                            case 2:
                                $day_3 = $count_view_story_id->today;
                                $day_4 = $count_view_story_id->day_2;
                                $day_5 = $count_view_story_id->day_3;
                                $day_6 = $count_view_story_id->day_4;
                                $day_7 = $count_view_story_id->day_5;
                                $day_8 = $count_view_story_id->day_6;

                                $count_view_story_id->today = 0;
                                $count_view_story_id->day_2 = 0;
                                $count_view_story_id->day_3 = $day_3;
                                $count_view_story_id->day_4 = $day_4;
                                $count_view_story_id->day_5 = $day_5;
                                $count_view_story_id->day_6 = $day_6;
                                $count_view_story_id->day_7 = $day_7;
                                $count_view_story_id->day_8 = $day_8;

                                $count_view_story_id->total = (int)$day_3 + (int)$day_4 + (int)$day_5 + (int)$day_6 + (int)$day_7 + (int)$day_8;
                                $count_view_story_id->save();

                                break;
                            case 3:
                                $day_4 = $count_view_story_id->today;
                                $day_5 = $count_view_story_id->day_2;
                                $day_6 = $count_view_story_id->day_3;
                                $day_7 = $count_view_story_id->day_4;
                                $day_8 = $count_view_story_id->day_5;

                                $count_view_story_id->today = 0;
                                $count_view_story_id->day_2 = 0;
                                $count_view_story_id->day_3 = 0;
                                $count_view_story_id->day_4 = $day_4;
                                $count_view_story_id->day_5 = $day_5;
                                $count_view_story_id->day_6 = $day_6;
                                $count_view_story_id->day_7 = $day_7;
                                $count_view_story_id->day_8 = $day_8;

                                $count_view_story_id->total = (int)$day_4 + (int)$day_5 + (int)$day_6 + (int)$day_7 + (int)$day_8;
                                $count_view_story_id->save();

                                break;
                            case 4:
                                $day_5 = $count_view_story_id->today;
                                $day_6 = $count_view_story_id->day_2;
                                $day_7 = $count_view_story_id->day_3;
                                $day_8 = $count_view_story_id->day_4;

                                $count_view_story_id->today = 0;
                                $count_view_story_id->day_2 = 0;
                                $count_view_story_id->day_3 = 0;
                                $count_view_story_id->day_4 = 0;
                                $count_view_story_id->day_5 = $day_5;
                                $count_view_story_id->day_6 = $day_6;
                                $count_view_story_id->day_7 = $day_7;
                                $count_view_story_id->day_8 = $day_8;

                                $count_view_story_id->total = (int)$day_5 + (int)$day_6 + (int)$day_7 + (int)$day_8;
                                $count_view_story_id->save();

                                break;
                            case 5:
                                $day_6 = $count_view_story_id->today;
                                $day_7 = $count_view_story_id->day_2;
                                $day_8 = $count_view_story_id->day_3;

                                $count_view_story_id->today = 0;
                                $count_view_story_id->day_2 = 0;
                                $count_view_story_id->day_3 = 0;
                                $count_view_story_id->day_4 = 0;
                                $count_view_story_id->day_5 = 0;
                                $count_view_story_id->day_6 = $day_6;
                                $count_view_story_id->day_7 = $day_7;
                                $count_view_story_id->day_8 = $day_8;

                                $count_view_story_id->total = (int)$day_6 + (int)$day_7 + (int)$day_8;
                                $count_view_story_id->save();

                                break;
                            case 6:
                                $day_7 = $count_view_story_id->today;
                                $day_8 = $count_view_story_id->day_2;

                                $count_view_story_id->today = 0;
                                $count_view_story_id->day_2 = 0;
                                $count_view_story_id->day_3 = 0;
                                $count_view_story_id->day_4 = 0;
                                $count_view_story_id->day_5 = 0;
                                $count_view_story_id->day_6 = 0;
                                $count_view_story_id->day_7 = $day_7;
                                $count_view_story_id->day_8 = $day_8;

                                $count_view_story_id->total = (int)$day_7 + (int)$day_8;
                                $count_view_story_id->save();
                                break;
                            case 7:
                                $day_8 = $count_view_story_id->today;

                                $count_view_story_id->today = 0;
                                $count_view_story_id->day_2 = 0;
                                $count_view_story_id->day_3 = 0;
                                $count_view_story_id->day_4 = 0;
                                $count_view_story_id->day_5 = 0;
                                $count_view_story_id->day_6 = 0;
                                $count_view_story_id->day_7 = 0;
                                $count_view_story_id->day_8 = $day_8;

                                $count_view_story_id->total = (int)$day_8;
                                $count_view_story_id->save();
                                break;
                            default:
                                $count_view_story_id->today = 0;
                                $count_view_story_id->day_2 = 0;
                                $count_view_story_id->day_3 = 0;
                                $count_view_story_id->day_4 = 0;
                                $count_view_story_id->day_5 = 0;
                                $count_view_story_id->day_6 = 0;
                                $count_view_story_id->day_7 = 0;
                                $count_view_story_id->day_8 = 0;

                                $count_view_story_id->total = 0;
                                $count_view_story_id->save();
                        }
                    }
                }
            }
        }

        $tops_30 = Post::whereStatus('1')->where('created_at', '>=', date('Y-m-d', time() - 24*3600*60))->orderBy('view', 'DESC')->limit(5)->get();
        $tops_7 = View::with('post')->where('updated_at', '>=', date('Y-m-d', time() - 24*3600*7))->orderBy('total', 'DESC')->limit(7)->get();
        return view('frontend.index', compact('posts', 'types', 'tops_30', 'tops_7', 'list_seo'));
    }
}
