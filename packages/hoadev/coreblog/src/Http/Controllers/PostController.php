<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Models\Post;
use Hoadev\CoreBlog\Models\Taxonomy;
use Hoadev\CoreBlog\Models\Term;
use Illuminate\Database\Eloquent\Builder;
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
        if($post_type === 'product') { return redirect()->route('admin.products.index'); }

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
        if($post_type === 'product') { return redirect()->route('admin.products.create'); }

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
            'metas' => 'array',
        ]);

        $post = $request->user()->posts()->create($validated['post']);

/*         $post->postMetas()->create([
            'key' => 'featured_image',
            'value' => $validated['metas']['featured_image']
        ]); */
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
        if($post->type === 'product') { return redirect()->route('admin.products.edit', $post); }
        $post_types = config('coreblog.post_types');

        $groupTaxonomies = Taxonomy::with(['term', 'ancestors'])
            ->whereIn('taxonomy', $post_types[$post->type]['taxonomies'])
            ->defaultOrder()
            ->get()
            ->groupBy(['taxonomy', 'term_id']);

         $selectedTermsObject = $post->terms->load('taxonomy')->groupBy('taxonomy.taxonomy');
/*        $selectedTerms = [];
        foreach($selectedTermsObject as $key => $value) {
            foreach($value as $child) {
                $selectedTerms[$key][] = $child->id;
            }
        } */

        $selectedTerms = [];
        /* dd($post_types[$post->type]['taxonomies']); */
        foreach($post_types[$post->type]['taxonomies'] as $tax) {
            if(isset($selectedTermsObject[$tax])) {
                $selectedTerms[$tax] = $selectedTermsObject[$tax]->pluck('id');
            } else {
                $selectedTerms[$tax] = [];
            }

        }

        $metas = $post->postMetas->groupBy('key');
        if(!isset($metas['featured_image'])) {$metas['featured_image'] = [];}

        /* dd($selectedTerms); */
        return Inertia::render('CoreBlog/Admin/Post/Edit', [
            'post' => $post,
            'post_type' => $post->type,
            'groupTaxonomies' => $groupTaxonomies,
            'selectedTerms' => $selectedTerms,
            'metas' => $metas,
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
            'metas' => 'array',
        ]);

        $post->update($validated['post']);

/*         foreach($validated['metas'] as $key => $value) {
            if($meta = $post->postMetas()->where('key', $key)->first()) {
                dd($key);
                $meta->update(['value' => $value]);
                $meta->save();
            }
        } */
        // handle all metas
        foreach($validated['metas'] as $key => $metasGroup) {
            if(isset($metasGroup[0]['id'])) {
                $post->postMetas()->update(collect($metasGroup[0])->except('media')->toArray());
            } else {
                $post->postMetas()->create(collect($metasGroup[0])->except('media')->toArray());
            }

        }

        $termIDs = [];
        foreach($validated['selectedTerms'] as $key => $value) {
            foreach($value as $item) {
                $termIDs[] = $item;
            }
        }
        $post->terms()->sync($termIDs);

        session()->flash('message', 'Update successfully!');
        /* return redirect()->route('admin.posts.index'); */
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
