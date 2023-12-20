<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Models\Post;
use Hoadev\CoreBlog\Models\Taxonomy;
use Hoadev\CoreBlog\Models\Term;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SitemapController extends Controller
{
    public function index()
    {

        $posts = Post::where('status', 'draft')->latest()->get()->groupBy('type');

        $taxonomies = Taxonomy::with(['term', 'ancestors'])->defaultOrder()->get()->groupBy('taxonomy');

        return Inertia::render('CoreBlog/Guest/Sitemap/Index', [
            'home' => '',
            'posts' => $posts,
            'taxonomies' => $taxonomies
        ]);

    }

}
