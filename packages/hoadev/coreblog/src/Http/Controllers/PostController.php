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

        $post_type = $request->query('post_type', 'post');
        $search = $request->query('search');

        $posts = Post::where('type', $post_type)->paginate(10);

        $posts->appends(['post_type' => $post_type]);

        if($search !== null) {
            $posts->appends(['search' => $search]);
        }

        return Inertia::render('CoreBlog/Admin/Post/Index', [
            'post_type' => $post_type,
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $post_type = $request->query('post_type', 'post');

        $post_types = config('coreblog.post_types');

        /* $groupTaxonomies = Taxonomy::with(['term', 'ancestors'])->whereIn('taxonomy', $post_types[$post_type]['taxonomies'])->defaultOrder()->get()->groupBy('taxonomy'); */

        $groupTaxonomies = Taxonomy::with(['term', 'ancestors'])
            ->whereIn('taxonomy', $post_types[$post_type]['taxonomies'])
            ->defaultOrder()
            ->get()
            ->groupBy(['taxonomy', 'term_id']);
/*             dd($groupTaxonomies); */
/*         $group = collect();

        foreach($post_types[$post_type]['taxonomies'] as $taxonomy) {
            $group =
        } */

        return Inertia::render('CoreBlog/Admin/Post/Create', [
            'post_type' => $post_type,
            'groupTaxonomies' => $groupTaxonomies
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
            'post.comment_status' => 'nullable|string',
            'post.password' => 'nullable|string',
            'post.name' => 'required|string|unique:posts,name',
            'post.parent_id' => 'nullable|string',
            'post.type' => 'required|string',
            'selectedTerms' => 'array',
        ]);

        $post = $request->user()->posts()->create($validated['post']);

        $termIDs = [];

        foreach($validated['selectedTerms'] as $key => $value) {
            array_push($termIDs, $value);
        }

        $post->terms()->sync($validated['selectedTerms']);

        return redirect()->route('admin.posts.index');
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

        $post_types = config('coreblog.post_types');

        $groupTaxonomies = Taxonomy::with(['term', 'ancestors'])
            ->whereIn('taxonomy', $post_types[$post->type]['taxonomies'])
            ->defaultOrder()
            ->get()
            ->groupBy(['taxonomy', 'term_id']);

        dd($post->terms()->groupBy('taxonomy'))->get();

        return Inertia::render('CoreBlog/Admin/Post/Edit', [
            'post' => $post,
            'post_type' => $post->type,
            'groupTaxonomies' => $groupTaxonomies
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
