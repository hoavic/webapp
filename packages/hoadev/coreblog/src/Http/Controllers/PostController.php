<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Models\Post;
use Hoadev\CoreBlog\Models\Taxonomy;
use Hoadev\CoreBlog\Traits\Core\CorePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class PostController extends Controller
{

    use CorePost;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($customAdmin = config('coreblog.post_types.'.$request->query('post_type', 'post').'.has_custom_admin_controller')) {
            return redirect()->route('admin.'.$customAdmin.'.index');
        }
        return Inertia::render('CoreBlog/Admin/Post/Index', [
            'posts' => $this->paginatePosts($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $post_type = $request->query('post_type', 'post');

        if($customAdmin = config('coreblog.post_types.'.$post_type.'.has_custom_admin_controller')) {
            return redirect()->route('admin.'.$customAdmin.'.create');
        }

        return Inertia::render('CoreBlog/Admin/Post/Create', [
            'groupTaxonomies' => $this->getGroupTaxonomies($post_type)
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
            'metas' => 'array',
        ]);

        $post = $request->user()->posts()->create($validated['post']);

        // handle all metas
        foreach($validated['metas'] as $key => $metasGroup) {
            if(isset($metasGroup) && $metasGroup != []) {
                $post->postMetas()->create($metasGroup[0]);
            }
        }

        $termIDs = [];
        foreach($validated['selectedTerms'] as $key => $value) {
            foreach($value as $item) {
                $termIDs[] = $item;
            }
        }
        $post->terms()->sync($termIDs);

        if($post->status === 'draft') {
            return redirect()->route('admin.posts.edit', $post);
        }

        Cache::tags(['posts'])->flush();

        return redirect()->route('admin.posts.index', ['post_type' => $post->type]);
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
        if($customAdmin = config('coreblog.post_types.'.$post->type.'.has_custom_admin_controller')) {
            return redirect()->route('admin.'.$customAdmin.'.index');
        }

        return Inertia::render('CoreBlog/Admin/Post/Edit', [
            'post' => $post->load(['postMetas.media']),
            'groupTaxonomies' => $this->getGroupTaxonomies($post->type),
            'selectedTerms' => $this->getSelectedTerms($post),
            'featured_image' => $post->getFeaturedImageUrl('medium')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'post.content'  => 'nullable|string',
            'post.title' => 'required|string',
            'post.excerpt' => 'nullable|string',
            'post.status' => 'required|string',
            'post.comment_status' => 'nullable|string',
            'post.password' => 'nullable|string',
            'post.name' => 'required|string|unique:posts,name,'.$post->id,
            'post.parent_id' => 'nullable|string',
            'post.type' => 'required|string',
            'selectedTerms' => 'array',
            'post.post_metas' => 'array',
            'post.post_metas.*.key' => 'required|string',
            'post.post_metas.*.value' => 'nullable',
        ]);

        $post->update($validated['post']);

        // handle all metas
        foreach($validated['post']['post_metas'] as $meta) {
            $post->postMetas()->updateOrCreate(
                [
                    'key' => $meta['key'],
                ],
                [
                    'value' => $meta['value'],
                ]
            );
        }

        $termIDs = [];
        foreach($validated['selectedTerms'] as $key => $value) {
            foreach($value as $item) {
                $termIDs[] = $item;
            }
        }
        $post->terms()->sync($termIDs);

        Cache::tags(['posts'])->flush();

        session()->flash('message', 'Update successfully!');
        /* return redirect()->route('admin.posts.index'); */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        Cache::tags(['posts'])->flush();

        return redirect()->route('admin.posts.index');
    }
}
