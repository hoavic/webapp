<?php

namespace Hoadev\CoreBlog\Traits\Guest;

use Hoadev\CoreBlog\Classes\Breadcrumbs;
use Hoadev\CoreBlog\Classes\MetaTags;
use Hoadev\CoreBlog\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

trait PermalinkWithPost {

    public function getPost(array $types, $name) {

        return Cache::tags(['posts'])->remember('post_name:'.$name, 3600, function() use ($name){
            return Post::with(['postMetas','postMetas.media', 'terms.taxonomy.ancestors'])
                        ->where('name', $name)
                        ->first();
        });
/*         return Post::with(['postMetas.media', 'terms.taxonomy.ancestors'])->whereIn('type', $types)
                    ->where('name', $name)
                    ->first(); */
    }

    public function renderPost($request, $type, $name) {

        if ($post = $this->getPost($type, $name)) {

            if($request->getPathInfo() !== $post->getPermalink()) { return redirect($post->getPermalink());}

            $meta_tags = new MetaTags();
            $meta_tags->importFromPost($post);
            $breadcrumbs = new Breadcrumbs();
            $breadcrumbs->importFromPost($post);

            if($post->type === 'page' && View::exists('guest.custom-page.'.$name)) {
                return view('guest.custom-page.'.$name, [
                    'post' => $post,
                    'metas' => $post->postMetas->pluck(['value', 'key']),
                    'meta_tags' => $meta_tags,
                    'breadcrumbs' => $breadcrumbs
                ]);
            }

            return view('coreblog::guest.post.default', [
                'post' => $post,
                'metas' => $post->postMetas->pluck(['value', 'key']),
                'taxonomies' => $post->terms->groupBy('taxonomy'),
                'relatedPosts' => $post->getRelatedPosts(),
                'meta_tags' => $meta_tags,
                'breadcrumbs' => $breadcrumbs
            ]);
        }

        return redirect()->route('home');
    }

}
