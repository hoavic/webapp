<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Classes\MetaTags;
use Hoadev\CoreBlog\Traits\Guest\PermalinkWithPost;
use Hoadev\CoreBlog\Traits\Guest\PermalinkWithTerm;
use Illuminate\Http\Request;

class PermalinkController extends Controller
{

    use PermalinkWithTerm, PermalinkWithPost;

    public function single(Request $request, $slug)
    {

        $term = $this->getTerm($slug);

        if($term) {
            if($request->getPathInfo() !== $term->parseSlug()) { return redirect($term->parseSlug());}
            $meta_tags = new MetaTags();
            $meta_tags->importFromTerm($term);
            return view('coreblog::guest.term.default', [
                'term' => $term,
                'posts' => $this->listPostsWithPaginate($term),
                'meta_tags' => $meta_tags
            ]);
        }

        return $this->renderPost(['post', 'page'], $slug);

    }

    public function post($type, $name)
    {

        if($type === 'post' || $type === 'page') {return redirect()->route('permalink.single', $name); }

        return $this->renderPost(array($type), $name);

    }

    public function term(Request $request, $type, $slug)
    {

        if($type === 'category') {return redirect()->route('permalink.single', $slug); }

        return $this->renderTerm($request, $slug, $type);

    }

    public function termHasParent(Request $request, $type, $parent, $slug)
    {

        if($type === 'category') {return redirect()->route('permalink.single', $slug); }

        return $this->renderTerm($request, $slug, $type);
    }

    public function categoryHasParent(Request $request, $parent, $slug)
    {
        return $this->renderTerm($request, $slug);
    }

    public function termHasGrand(Request $request, $type, $grand, $parent, $slug)
    {

        if($type === 'category') {return redirect()->route('permalink.single', $slug); }

        return $this->renderTerm($request, $slug, $type);

    }

    public function categoryHasGrand(Request $request, $grand, $parent, $slug)
    {
        return $this->renderTerm($request, $slug);
    }

}
