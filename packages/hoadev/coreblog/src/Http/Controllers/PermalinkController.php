<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
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

        if($term = $this->getTerm($slug)) {

            if($request->getPathInfo() !== $term->parseSlug()) { return redirect($term->parseSlug());}

            return $this->renderTerm($request, $slug);
        }

        return $this->renderPost($request, ['post', 'page'], $slug);

    }

    public function post(Request $request, $type, $name)
    {

        if($type === 'post' || $type === 'page') {return redirect()->route('permalink.single', $name); }

        return $this->renderPost($request, array($type), $name);

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


    public function archive($post_type) {
        return $this->renderArchive($post_type);
    }

    public function renderArchive($post_type) {

        $gb_posts = config('coreblog.post_types');

        $product_slug = config('coreblog.post_types.product.archive_page') ?? $post_type === config('coreblog.post_types.product.type');

        if($post_type === $product_slug) {

            $posts = Product::with(['postMetas.media', 'variants'])
                ->where('status', 'published')
                ->where('type', 'product')
                ->latest()
                ->paginate(10);

            return view('coreblog::guest.archive.product', [
                'post_label' => config('coreblog.post_types.product.labels.vietsub'),
                'posts' => $posts,
                'contentStyle' => 'no-sidebar'
            ]);
        }
        $post_label = '';

        foreach ($gb_posts as $gb_post) {
            if($gb_post['archive_page'] === $post_type) {
                $post_label = $gb_post['labels']['vietsub'];
                $post_type = $gb_post['type'];
                break;
            }
            if($gb_post['type'] === $post_type) {
                $post_label = $gb_post['labels']['vietsub'];
                break;
            }
        }

        $posts = Post::with(['postMetas.media'])
            ->where('status', 'published')
            ->where('type', $post_type)
            ->latest()
            ->paginate(10);

        return view('coreblog::guest.archive.default', [
            'post_label' => $post_label,
            'posts' => $posts,
        ]);

    }

}
