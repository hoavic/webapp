<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Models\Post;
use Hoadev\CoreBlog\Models\Taxonomy;

class HomeController extends Controller
{
    public function default()
    {

        return view('coreblog::guest.home', [
            'newestPosts' => Post::with(['postMetas.media'])->where('status', 'published')->where('type', 'post')->latest()->limit(10)->get(),
            'categories' => Taxonomy::with(['term', 'ancestors'])->where('taxonomy', 'category')->get(),
            'contentStyle' => 'no-sidebar'
        ]);
    }

}
