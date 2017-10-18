<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\View;
use Auth;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $post_id = json_decode(Post::where('user_id', Auth::id())->pluck('id'));
        $post_views_id = json_decode(View::pluck('post_id'));

        foreach ($post_views_id as $val) {
            $count_view_story_id = View::wherePost_id($val)->first();
            if (count($count_view_story_id) != 0) {
                $time_db_now = date('Y-m-d', strtotime($count_view_story_id->updated_at));
                $time_now = date('Y-m-d', time());
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
                            $count_view_story_id->save();
                    }
                }
            }
        }

        $chart = [
            'days' => [],
            'data' => [],
            'views' => []
        ];

        $chart_user = [
            'days' => [],
            'data' => [],
            'views' => []
        ];

        $today = View::sum('today');
        $day_2 = View::sum('day_2');
        $day_3 = View::sum('day_3');
        $day_4 = View::sum('day_4');
        $day_5 = View::sum('day_5');
        $day_6 = View::sum('day_6');
        $day_7 = View::sum('day_7');
        $day_8 = View::sum('day_8');
        $chart['views'] = array($day_8, $day_7, $day_6, $day_5, $day_4, $day_3, $day_2, $today);

        $today = View::whereIn('post_id', $post_id)->sum('today');
        $day_2 = View::whereIn('post_id', $post_id)->sum('day_2');
        $day_3 = View::whereIn('post_id', $post_id)->sum('day_3');
        $day_4 = View::whereIn('post_id', $post_id)->sum('day_4');
        $day_5 = View::whereIn('post_id', $post_id)->sum('day_5');
        $day_6 = View::whereIn('post_id', $post_id)->sum('day_6');
        $day_7 = View::whereIn('post_id', $post_id)->sum('day_7');
        $day_8 = View::whereIn('post_id', $post_id)->sum('day_8');
        $chart_user['views'] = array($day_8, $day_7, $day_6, $day_5, $day_4, $day_3, $day_2, $today);
        // thống 7 ngày gần nhất
        $time = time();
        $days = [];
        $date_n_y = [];
        for ($i = 0; $i < 8; $i++) {
            $days[] = date('Y-m-d', $time);
            $date_n_y[] = date('d/m/y', $time);
            $time -= 24 * 3600;
        }

        $days = (array_reverse($days));
        $date_n_y = (array_reverse($date_n_y));
//        tất cả truyện
        for ($i = 0; $i < 7; $i++) {
            $chart['days'][] = $date_n_y[$i];
            $chart_user['days'][] = $date_n_y[$i];

            $chart['data'][] = Post::whereBetween('created_at', [$days[$i], $days[$i + 1]])->count();
            $chart_user['data'][] = Post::whereBetween('created_at', [$days[$i], $days[$i + 1]])->whereUser_id(Auth::id())->count();
        }
        $chart['days'][] = date('d/m/y', time());
        $chart_user['days'][] = date('d/m/y', time());

        $chart['data'][] = Post::where('created_at', '>=', date('Y-m-d', time()))->count();
        $chart_user['data'][] = Post::where('created_at', '>=', date('Y-m-d', time()))->whereUser_id(Auth::id())->count();
        return view('backend.home.index', compact('chart', 'chart_user'));
    }
}
