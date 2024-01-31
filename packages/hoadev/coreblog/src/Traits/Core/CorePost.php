<?php

namespace Hoadev\CoreBlog\Traits\Core;

use Hoadev\CoreBlog\Models\Post;
use Hoadev\CoreBlog\Models\Taxonomy;
use Illuminate\Http\Request;
use Inertia\Inertia;

trait CorePost {

    private function paginatePosts(Request $request, $post_type = false, $eagerLoad = false, $numberOfPosts = 10)
    {

        if (!$post_type) {$post_type = $request->query('post_type', 'post');}
        Inertia::share('post_type', $post_type);

        $search = $request->query('search');
        Inertia::share('search_term', $search);

        if(!$eagerLoad) {
            $posts = Post::where('type', $post_type)
                    ->where('title', 'like', '%'.$search.'%')
                    ->latest()
                    ->paginate($numberOfPosts);
        } else {
            $posts = Post::with($eagerLoad)
                    ->where('type', $post_type)
                    ->where('title', 'like', '%'.$search.'%')
                    ->latest()
                    ->paginate($numberOfPosts);
        }


        $posts->appends(['post_type' => $post_type]);

        if($search !== null) {
            $posts->appends(['search' => $search]);
        }

        return $posts;
    }

    private function getGroupTaxonomies($post_type = 'post') {

        $post_types = config('coreblog.post_types');
        Inertia::share('post_type', $post_type);

        return Taxonomy::with(['term', 'ancestors'])
            ->whereIn('taxonomy', $post_types[$post_type]['taxonomies'])
            ->defaultOrder()
            ->get()
            ->groupBy(['taxonomy', 'term_id']);
    }

    private function getSelectedTerms($post) {
        $selectedTermsObject = $post->terms->load('taxonomy')->groupBy('taxonomy.taxonomy');

        $selectedTerms = [];

        foreach(config('coreblog.post_types.'.$post->type.'.taxonomies') as $tax) {
            if(isset($selectedTermsObject[$tax])) {
                $selectedTerms[$tax] = $selectedTermsObject[$tax]->pluck('id');
            } else {
                $selectedTerms[$tax] = [];
            }
        }

        return $selectedTerms;
    }

}
