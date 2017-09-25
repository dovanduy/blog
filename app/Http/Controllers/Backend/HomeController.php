<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
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

            $chart['views'][] = Post::whereBetween('created_at', [$days[$i], $days[$i + 1]])->sum('view');
            $chart_user['views'][] = Post::whereBetween('created_at', [$days[$i], $days[$i + 1]])->whereUser_id(Auth::id())->sum('view');
        }
        $chart['days'][] = date('d/m/y', time());
        $chart_user['days'][] = date('d/m/y', time());

        $chart['data'][] = Post::where('created_at', '>=', date('Y-m-d', time()))->count();
        $chart_user['data'][] = Post::where('created_at', '>=', date('Y-m-d', time()))->whereUser_id(Auth::id())->count();

        $chart['views'][] = Post::where('created_at', '>=', date('Y-m-d', time()))->sum('view');
        $chart_user['views'][] = Post::where('created_at', '>=', date('Y-m-d', time()))->whereUser_id(Auth::id())->sum('view');

        return view('backend.home.index', compact('chart', 'chart_user'));
    }
}
