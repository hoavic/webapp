<?php

namespace Hoadev\CoreBlog\Classes;

use Hoadev\CoreBlog\Models\Post;
use Hoadev\CoreBlog\Models\Term;

class BreadcrumbList
 {

    public string $context = 'https://schema.org';
    public string $type = 'BreadcrumbList';
    public array $itemListElement;
    private $counter = 1;

    public function setParent($term)
    {

        foreach($term->taxonomy->ancestors as $ans) {
            $itemElementLoop = new ItemListElement($this->counter, $ans->term->name, $ans->getPermalink());
            $this->itemListElement[] = $itemElementLoop;
            $this->counter = $this->counter + 1;
        }

        $itemElement = new ItemListElement($this->counter, $term->name, $term->getPermalink());
        $this->itemListElement[] = $itemElement;
        $this->counter = $this->counter + 1;
    }

    public function setEndpointByPost(Post $post)
    {
        $itemElement = new ItemListElement($this->counter, $post->title, $post->getPermalink());
        $this->itemListElement[] = $itemElement;
    }


}
