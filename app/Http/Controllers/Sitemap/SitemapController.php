<?php

namespace App\Http\Controllers\Sitemap;

use App\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;

class SitemapController extends Controller
{
    //
    public function index()
    {
        $posts = Post::select('title_seo', 'created_at')->get();
        return response()->view('sitemaps.sitemap', compact('posts'))->header('Content-Type', 'text/xml');
    }
    public function category()
    {
        $types = Type::all();
        return response()->view('sitemaps.categorySitemap', compact('posts', 'types'))->header('Content-Type', 'text/xml');
    }
    public function tags() {
        return response()->view('sitemaps.tagsSitemap')->header('Content-Type', 'text/xml');
    }
}
