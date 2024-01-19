<?php

namespace Hoadev\CoreShop\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Classes\Breadcrumbs;
use Hoadev\CoreBlog\Classes\MetaTags;
use Hoadev\CoreBlog\Traits\Guest\PermalinkWithTerm;
use Hoadev\CoreShop\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PermalinkShopController extends Controller
{

    use PermalinkWithTerm;

    public function product(Request $request, $name)
    {

        if ($post = $this->getPost($name)) {

            if($request->getPathInfo() !== $post->getPermalink()) { return redirect($post->getPermalink());}

            $meta_tags = new MetaTags();
            $meta_tags->importFromPost($post);

            $breadcrumbs = new Breadcrumbs();
            $breadcrumbs->importFromPost($post);

            return view('coreshop::guest.product.default', [
                'post' => $post,
                'metas' => $post->postMetas->pluck(['value', 'key']),
                'taxonomies' => $post->terms->groupBy('taxonomy'),
                'relatedPosts' => $post->getRelatedPosts(),
                'meta_tags' => $meta_tags,
                'breadcrumbs' => $breadcrumbs,
                'contentStyle' => 'shop-sidebar'
            ]);
        }

        return redirect()->route('home');
    }

    public function getPost($name) {

        return Cache::tags(['posts'])->remember('post_name:'.$name, 3600, function() use ($name){
            return Product::with(['postMetas', 'terms.taxonomy.ancestors', 'variants'])->where('type', 'product')
                        ->where('name', $name)
                        ->first();
        });
    }

    public function productCategory(Request $request, $slug)
    {
        return $this->renderTerm($request, $slug);
    }

    public function productCategoryHasParent(Request $request, $parent, $slug)
    {
        return $this->renderTerm($request, $slug);
    }

    public function productCategoryHasGrand(Request $request, $grand, $parent, $slug)
    {
        return $this->renderTerm($request, $slug);
    }

    public function renderTerm($request, $slug) {

        if($term = $this->getTerm($slug)) {

            if($request->getPathInfo() !== $term->getPermalink()) { return redirect($term->getPermalink());}

            $meta_tags = new MetaTags();
            $meta_tags->importFromTerm($term);
            $breadcrumbs = new Breadcrumbs();
            $breadcrumbs->importFromTerm($term);

            return view('coreshop::guest.term.product-category', [
                'term' => $term,
                'posts' => $this->listPostsWithPaginate($request, $term),
                'meta_tags' => $meta_tags,
                'breadcrumbs' => $breadcrumbs,
                'contentStyle' => 'no-sidebar'
            ]);

        }

        return redirect()->route('home');
    }

    //Overwrite traits
    public static function listPostsWithPaginate($request, $term) {

        $currentPage = $request->query('page', 1);

        return Cache::tags(['posts', 'terms', 'taxonomies'])->remember('posts_by_term_slug:'.$term->slug.'_page:'.$currentPage, 3600, function() use ($term){
            return $term->products()->where('status', 'published')->with(['postMetas.media', 'terms', 'variants'])->latest()->paginate(10);
        });

    }
}
