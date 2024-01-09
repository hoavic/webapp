<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Classes\MetaTags;
use Hoadev\CoreBlog\Models\Post;
use Hoadev\CoreBlog\Traits\Guest\PermalinkWithPost;
use Hoadev\CoreBlog\Traits\Guest\PermalinkWithTerm;
use Hoadev\CoreShop\Models\Product;
use Illuminate\Http\Request;

class PermalinkController extends Controller
{

    use PermalinkWithTerm, PermalinkWithPost;

    public function single(Request $request, $slug)
    {

        $term = $this->getTerm($slug);

        if($term) {

            if($request->getPathInfo() !== $term->parseSlug()) { return redirect($term->parseSlug());}

            return $this->renderTerm($request, $slug, 'category');
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

    public function archive($post_type) {
        return $this->renderArchive($post_type);
    }

    public function renderArchive($post_type) {

        $gb_posts = config('coreblog.post_types');

        if($post_type === 'product') {

            $posts = Product::with(['postMetas.media', 'variants'])
                ->where('status', 'published')
                ->where('type', $post_type)
                ->paginate(10);

            return view('coreblog::guest.archive.product', [
                'post_type' => $gb_posts[$post_type]["labels"]["vietsub"],
                'posts' => $posts,
                'contentStyle' => 'no-sidebar'
            ]);
        }

        $posts = Post::with(['postMetas.media'])
            ->where('status', 'published')
            ->where('type', $post_type)
            ->paginate(10);

        return view('coreblog::guest.archive.default', [
            'post_type' => $gb_posts[$post_type]["labels"]["vietsub"],
            'posts' => $posts,
        ]);

    }

}
