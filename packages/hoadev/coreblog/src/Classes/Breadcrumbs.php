<?php

namespace Hoadev\CoreBlog\Classes;

use Hoadev\CoreBlog\Models\Post;
use Hoadev\CoreBlog\Models\Taxonomy;
use Hoadev\CoreBlog\Models\Term;

class Breadcrumbs {

    public $breadcrumbs;

    public function importFromPost(Post $post)
    {
        if($post->terms->count() > 0) {
            foreach($post->terms as $term) {
                $breadcrumbList = new BreadcrumbList();
                $breadcrumbList->setParent($term);
                $breadcrumbList->setEndpointByPost($post);
                $this->breadcrumbs[] = $breadcrumbList;
            }
        } else {
            $breadcrumbList = new BreadcrumbList();
            $breadcrumbList->setEndpointByPost($post);
            $this->breadcrumbs[] = $breadcrumbList;
        }


        /* dd($this->breadcrumbs);
 */
    }

    public function importFromTerm(Term $term)
    {
            $breadcrumbList = new BreadcrumbList();
            $breadcrumbList->setParent($term);
            $this->breadcrumbs[] = $breadcrumbList;

/*         foreach($term->taxonomy->ancestors as $tax) {
            $breadcrumbList = new BreadcrumbList();
            $breadcrumbList->setParent($tax);
            $breadcrumbList->setEndpointByTaxonomy($tax);// ???
            $this->breadcrumbs[] = $breadcrumbList;
        } */
    }

/*     public function importFromTaxonomy(Taxonomy $taxonomy)
    {
        foreach($taxonomy->ancestors as $tax) {

            $breadcrumbList = new BreadcrumbList();
            $breadcrumbList->setEndpointByTaxonomy($tax);
            $this->breadcrumbs[] = $breadcrumbList;dd($breadcrumbList);
        }
    } */
}
