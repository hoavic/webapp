<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Models\Post;
use Hoadev\CoreBlog\Models\Taxonomy;
use Hoadev\CoreBlog\Models\Term;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $type = $request->query('type', 'post');
        $posts = Post::where('type', $type)->get();
        $allTerms = Taxonomy::where('taxonomy', ['category', 'tag'])->groupBy('taxonomy')->get();

        return Inertia::render('CoreBlog/Admin/Post/Index', [
            'type' => $type,
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request->query('type', 'post');

        return Inertia::render('CoreBlog/Admin/Post/Create', [
            'type' => $type
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post.content'  => 'nullable|string',
            'post.title' => 'required|string',
            'post.excerpt' => 'nullable|string',
            'post.status' => 'required|string',
            'post.comment_status' => 'required|string',
            'post.password' => 'required|string',
            'post.name' => 'required|string|unique:posts',
            'post.parent' => 'nullable|string',
            'post.type' => 'required|string',
        ]);

        $request->user()->posts()->create($validated);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return Inertia::render('CoreBlog/Admin/Post/Show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $type = $post->type;

        return Inertia::render('CoreBlog/Admin/Post/Edit', [
            'type' => $type,
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index');
    }
}
