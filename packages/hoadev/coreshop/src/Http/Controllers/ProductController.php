<?php

namespace Hoadev\CoreShop\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Models\Taxonomy;
use Hoadev\CoreShop\Models\Product;
use Hoadev\CoreShop\Models\Variant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->query('search');

        $products = Product::where('type', 'product')->paginate(10);

        if($search !== null) {
            $products->appends(['search' => $search]);
        }

        return Inertia::render('CoreShop/Admin/Product/Index', [
            'post_type' => 'product',
            'posts' => $products
        ]);
    }

/**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $post_type = $request->query('post_type', 'product');

        $post_types = config('coreblog.post_types');

        $groupTaxonomies = Taxonomy::with(['term', 'ancestors'])
            ->whereIn('taxonomy', $post_types[$post_type]['taxonomies'])
            ->defaultOrder()
            ->get()
            ->groupBy(['taxonomy', 'term_id']);

        return Inertia::render('CoreShop/Admin/Product/Create', [
            'post_type' => $post_type,
            'groupTaxonomies' => $groupTaxonomies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post.content'  => 'nullable|string',
            'post.title' => 'required|string',
            'post.excerpt' => 'nullable|string',
            'post.status' => 'required|string',
            'post.comment_status' => 'nullable|string',
            'post.password' => 'nullable|string',
            'post.name' => 'required|string|unique:posts,name',
            'post.parent_id' => 'nullable|string',
            'post.type' => 'required|string',
            'selectedTerms' => 'array',
            'metas' => 'array',
            'variants' => 'array',
            'variants.*.name' => 'string|nullable',
            'variants.*.quantity' => 'integer|nullable',
            'variants.*.price' => 'integer|nullable',
        ]);

        $product = $request->user()->products()->create($validated['post']);

        // handle all metas
        foreach($validated['metas'] as $key => $metasGroup) {
            if(isset($metasGroup[0]['key'])) {
                $product->postMetas()->create($metasGroup[0]);
            }
        }

        //Store Terms
        $termIDs = [];
        foreach($validated['selectedTerms'] as $key => $value) {
            foreach($value as $item) {
                $termIDs[] = $item;
            }
        }
        $product->terms()->sync($termIDs);

        //Store Variant
        $product->variants()->createMany($validated['variants']);

        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $post_types = config('coreblog.post_types');

        $groupTaxonomies = Taxonomy::with(['term', 'ancestors'])
            ->whereIn('taxonomy', $post_types[$product->type]['taxonomies'])
            ->defaultOrder()
            ->get()
            ->groupBy(['taxonomy', 'term_id']);

        $selectedTermsObject = $product->terms->load('taxonomy')->groupBy('taxonomy.taxonomy');

        $selectedTerms = [];
        foreach($post_types[$product->type]['taxonomies'] as $tax) {
            if(isset($selectedTermsObject[$tax])) {
                $selectedTerms[$tax] = $selectedTermsObject[$tax]->pluck('id');
            } else {
                $selectedTerms[$tax] = [];
            }
        }

        $metas = $product->postMetas->groupBy('key');
        if(!isset($metas['featured_image'])) {$metas['featured_image'] = [];}

        return Inertia::render('CoreShop/Admin/Product/Edit', [
            'post' => $product->load('variants'),
            'post_type' => $product->type,
            'groupTaxonomies' => $groupTaxonomies,
            'selectedTerms' => $selectedTerms,
            'metas' => $metas,
            'featured_image' => $product->getFeaturedImageUrl('medium')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'post.content'  => 'nullable|string',
            'post.title' => 'required|string',
            'post.excerpt' => 'nullable|string',
            'post.status' => 'required|string',
            'post.comment_status' => 'nullable|string',
            'post.password' => 'nullable|string',
            'post.name' => 'required|string|unique:posts,name,'.$product->id,
            'post.parent_id' => 'nullable|string',
            'post.type' => 'required|string',
            'selectedTerms' => 'array',
            'metas' => 'array',
            'variants' => 'array',
            'variants.*.name' => 'string|nullable',
            'variants.*.quantity' => 'integer|nullable',
            'variants.*.price' => 'integer|nullable',
        ]);

        $product->update($validated['post']);

/*         foreach($validated['metas'] as $key => $value) {
            if($meta = $post->postMetas()->where('key', $key)->first()) {
                dd($key);
                $meta->update(['value' => $value]);
                $meta->save();
            }
        } */
        // handle all metas
        foreach($validated['metas'] as $key => $metasGroup) {
/*             if(isset($metasGroup[0]['id'])) {
                $product->postMetas()->update(collect($metasGroup[0])->except('media')->toArray());
            } else {
                $product->postMetas()->create(collect($metasGroup[0])->except('media')->toArray());
            } */
            $product->postMetas()->updateOrCreate(collect($metasGroup[0])->except('media')->toArray());
        }

        $termIDs = [];
        foreach($validated['selectedTerms'] as $key => $value) {
            foreach($value as $item) {
                $termIDs[] = $item;
            }
        }
        $product->terms()->sync($termIDs);

        //Store Variant
        $variantIds = [];
        foreach($validated['variants'] as $variant) {

            if(isset($variant['id'])) {
                $realVariant = $product->variants()->update($variant);
            } else {
                $realVariant = $product->variants()->create($variant);
            }
            $variantIds[] = $realVariant->id;
        }
        dd($variantIds);
        Variant::whereNotIn('id', $variantIds)->delete();

        session()->flash('message', 'Update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.posts.index');
    }
}
