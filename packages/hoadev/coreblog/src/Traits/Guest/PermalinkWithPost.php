<?php

namespace Hoadev\CoreBlog\Traits\Guest;

use Hoadev\CoreBlog\Classes\Breadcrumbs;
use Hoadev\CoreBlog\Classes\MetaTags;
use Hoadev\CoreBlog\Models\Post;

trait PermalinkWithPost {

    public function getPost(array $types, $name) {
        return Post::with(['postMetas', 'terms.taxonomy.ancestors'])->whereIn('type', $types)
                    ->where('name', $name)
                    ->first();
    }

    public function renderPost($type, $name) {

        if ($post = $this->getPost($type, $name)) {

            $meta_tags = new MetaTags();
            $meta_tags->importFromPost($post);
            $breadcrumbs = new Breadcrumbs();
            $breadcrumbs->importFromPost($post);

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
