<?php

namespace Hoadev\CoreBlog\Classes;

use Hoadev\CoreBlog\Models\Post;
use Hoadev\CoreBlog\Models\Term;

class MetaTags {

    public $title;
    public $description;
    public $image;
/*     public $imageWidth;
    public $imageHeight; */
    public $created_at;
    public $updated_at;
    public $canonical;

    public function importFromPost(Post $post)
    {
        $this->title = $post->title;
        $this->description = $post->getMetaDescription();
        $this->image = config('app.url').$post->getFeaturedImageUrl();
/*         $this->imageWidth = $post->getFeatured()->media->custom_properties->width;
        $this->imageHeight = $post->getFeatured()->media->custom_properties->height; */
        $this->created_at = $post->created_at;
        $this->updated_at = $post->updated_at;
        $this->canonical = config('app.url').$post->getPermalink();
    }

    public function importFromTerm(Term $term)
    {
        $this->title = $term->name;
        $this->description = $term->getMetaDescription();
        $this->canonical = config('app.url').$term->getPermalink();
    }

}
