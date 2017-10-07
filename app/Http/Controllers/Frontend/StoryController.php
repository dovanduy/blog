<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Type;
use App\Post;
use App\View;
use Auth;

class StoryController extends Controller
{
    //
    public function __construct()
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        Auth::logout();
    }

    private $pa = 1500;

    public function index($name, Request $request)
    {
        $array_category = json_decode(Type::pluck('name_unicode'));
        $admin = 'admin';
        $search = 'search';

        if ($name == $admin) {
            return redirect()->route('login');
        } elseif ($name == $search) {
            $keyword = $request->keyword;
            if ($request->type == 'stories') {
                $responses = Post::select('id', 'title', 'view')
                    ->whereStatus(1)
                    ->where('title', 'like', '%' . $keyword . '%')
                    ->limit(10)
                    ->get();
            } else {
                $responses = Post::select('id', 'title', 'view')
                    ->whereStatus(1)
                    ->where('title', 'like', '%' . $keyword . '%')
                    ->limit(10)
                    ->get();
            }
            return response()->json($responses);

        } elseif (in_array($name, $array_category)) {
            $type_name = Type::whereName_unicode($name)->first();
            $type_id = $type_name->id;
            $posts = Post::with('User')->whereType($type_id)->whereStatus('1')->orderBy('created_at', 'DESC')->paginate(15);

            $types = Type::all();
            $tops_30 = Post::whereStatus('1')->where('created_at', '>=', date('Y-m-d', time() - 24 * 3600 * 30))->orderBy('view', 'DESC')->limit(5)->get();
            $tops_7 = Post::whereStatus('1')->where('created_at', '>=', date('Y-m-d', time() - 24 * 3600 * 7))->orderBy('view', 'DESC')->limit(7)->get();
            return view('frontend.category', compact('posts', 'types', 'tops_30', 'tops_7', 'type_name'));
        } else {
            $types = Type::all();
            $story = Post::whereTitle_seo($name)->first();
//
            $paragraph_paginate = [
                'total_page' => 1,
                'content' => '',
                'current_page' => 1
            ];
            $trang = $request->trang;

            $content = $story->content;
            $content = explode(' ', $content);
            $count = count($content);

            if (is_numeric($trang)) {

                $paragraph_paginate['total_page'] = ceil($count / $this->pa);
                $total_page = $paragraph_paginate['total_page'];

                $paragraph = $trang * $this->pa;

                if ($paragraph > $count) {
                    $paragraph = $count;
                }

                if($trang <=1) {
                    $paragraph_paginate['content'] = implode(' ', array_slice($content, 0, $this->pa)) . '</p>';
                    $paragraph_paginate['current_page'] = 1;
                } else {
                    if ($trang < $total_page) {
                        $paragraph_paginate['content'] = '<p>' . implode(' ',array_slice($content, ($paragraph - $this->pa), $this->pa)) . '</p>';
                    } else {
                        $paragraph_paginate['content'] = '<p>' . implode(' ',array_slice($content, ($paragraph - $this->pa), $this->pa));
                    }
                    $trang <= $total_page?$paragraph_paginate['current_page'] = $trang:$paragraph_paginate['current_page']=$total_page;
                }
            } else {

                $paragraph_paginate['total_page'] = ceil($count / $this->pa);

                $paragraph = 1 * $this->pa;

                $paragraph_paginate['content'] = implode(' ', array_slice($content, 0, $paragraph)) . '</p>';
                $paragraph_paginate['current_page'] = 1;
            }
//
            $tops_30 = Post::whereStatus('1')->where('created_at', '>=', date('Y-m-d', time() - 24 * 3600 * 30))->orderBy('view', 'DESC')->limit(5)->get();
            $involves = Post::whereStatus('1')->where('title_seo', '<>', $name)->orderby('id', 'desc')->orderby('view', 'desc')->limit('20')->take(5)->get();
            if (count($story) != 0) {
                $post_id = $story->id;
                $view = $story->view;
                $story->view = $view + 1;
                $story->save();

                //save view 7 day
                $count_view_story_id = View::wherePost_id($post_id)->first();
                if (count($count_view_story_id) != 0) {
                    $time_db_now = date('Y-m-d', strtotime($count_view_story_id->updated_at));
                    $time_now = date('Y-m-d', time());
                    if ($time_db_now == $time_now) {
                        $add_view = $count_view_story_id->today;
                        $count_view_story_id->today = $add_view + 1;
                        $count_view_story_id->save();
                    } else {
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

                                $count_view_story_id->today = 1;
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

                                $count_view_story_id->today = 1;
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

                                $count_view_story_id->today = 1;
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

                                $count_view_story_id->today = 1;
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

                                $count_view_story_id->today = 1;
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

                                $count_view_story_id->today = 1;
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

                                $count_view_story_id->today = 1;
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
                                $count_view_story_id->today = 1;
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
                } else {
                    $view_today = new View();
                    $view_today->today = 1;
                    $view_today->post_id = $post_id;
                    $view_today->save();
                }
            }
            return view('frontend.story', compact('story', 'types', 'tops_30', 'involves', 'paragraph_paginate'));
        }
    }
}
