<?php

namespace Hoadev\CoreBlog\Traits\Guest;

use Hoadev\CoreBlog\Classes\Breadcrumbs;
use Hoadev\CoreBlog\Classes\MetaTags;
use Hoadev\CoreBlog\Models\Term;
use Illuminate\Database\Eloquent\Builder;

trait PermalinkWithTerm {

    public function getTerm($slug, $taxonomy = 'category') {
        return Term::whereHas('taxonomy', function (Builder $query) use($taxonomy) {
                        $query->where('taxonomy', $taxonomy);
                    })
                    ->where('slug', $slug)
                    ->first();
    }

    public function renderTerm($request, $slug, $taxonomy = 'category') {

        if($term = $this->getTerm($slug, $taxonomy)) {

            if($request->getPathInfo() !== $term->getPermalink()) { return redirect($term->getPermalink());}

            $meta_tags = new MetaTags();
            $meta_tags->importFromTerm($term);
            $breadcrumbs = new Breadcrumbs();
            $breadcrumbs->importFromTerm($term);

            return view('coreblog::guest.term.default', [
                'term' => $term,
                'posts' => $this->listPostsWithPaginate($term),
                'meta_tags' => $meta_tags,
                'breadcrumbs' => $breadcrumbs
            ]);

        }

        return redirect()->route('home');
    }

    public static function listPostsWithPaginate(Term $term) {
        return $term->posts()->where('status', 'published')->with(['postMetas.media'])->paginate(10);
    }

}
