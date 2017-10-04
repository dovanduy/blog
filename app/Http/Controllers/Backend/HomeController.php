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

        $post_id = json_decode(Post::where('user_id', Auth::id())->pluck('id'));

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
