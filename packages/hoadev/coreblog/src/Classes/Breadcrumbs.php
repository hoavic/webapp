<?php

namespace Hoadev\CoreBlog\Classes;

use Hoadev\CoreBlog\Models\Post;
use Hoadev\CoreBlog\Models\Term;

class Breadcrumbs {

    public $breadcrumbs;

    public function importFromPost(Post $post)
    {

        foreach($post->terms as $term) {
            $breadcrumbList = new BreadcrumbList();
            $breadcrumbList->setParent($term);
            $breadcrumbList->setEndpointByPost($post);
            $this->breadcrumbs[] = $breadcrumbList;
        }

        /* dd($this->breadcrumbs);
 */
    }
}
