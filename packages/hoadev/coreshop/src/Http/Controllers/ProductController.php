<?php

namespace Hoadev\CoreShop\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Models\PostMeta;
use Hoadev\CoreBlog\Models\Taxonomy;
use Hoadev\CoreShop\Models\Product;
use Hoadev\CoreShop\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->query('search');

        $products = Product::where('type', 'product')
                        ->where('title', 'like', '%'.$search.'%')
                        ->latest()
                        ->paginate(10);

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
            'variants.*.sku' => 'string|nullable',
            'variants.*.barcode' => 'string|nullable',
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

        Cache::tags(['posts'])->flush();

        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return Inertia::render('CoreBlog/Admin/Post/Show', [
            'post' => $product
        ]);
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
        $product->load(['postMetas', 'variants']);

        foreach($product->postMetas as $key => $value) {
            if(!is_array($product->postMetas[$key]->value)) {
                $product->postMetas[$key]->load('media');
            }
        }

        return Inertia::render('CoreShop/Admin/Product/Edit', [
            'post' => $product,
            'post_type' => $product->type,
            'groupTaxonomies' => $groupTaxonomies,
            'selectedTerms' => $selectedTerms,
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
            'post.post_metas' => 'array',
            'post.post_metas.*.key' => 'required|string',
            'post.post_metas.*.value' => 'nullable',
            'post.variants' => 'array',
            'post.variants.*.stock_id' => 'integer|nullable',
            'post.variants.*.name' => 'string|nullable',
            'post.variants.*.sku' => 'string|nullable',
            'post.variants.*.barcode' => 'string|nullable',
            'post.variants.*.quantity' => 'integer|nullable',
            'post.variants.*.price' => 'integer|nullable',
        ]);

        $product->update($validated['post']);

        // handle all metas
        foreach($validated['post']['post_metas'] as $meta) {
            $product->postMetas()->updateOrCreate(
                [
                    'key' => $meta['key'],
                ],
                [
                    'value' => $meta['value'],
                ]
            );
        }

        $termIDs = [];
        foreach($validated['selectedTerms'] as $key => $value) {
            foreach($value as $item) {
                $termIDs[] = $item;
            }
        }
        $product->terms()->sync($termIDs);

        //Store Variant
        $newVariants = collect();
        foreach($validated['post']['variants'] as $variant) {
            $newVariants->push($product->variants()->updateOrCreate(
                [
                    'name' => $variant['name'],
                ],
                [
                    'price' => $variant['price'],
                    'quantity' => $variant['quantity'],
                ]
            ));
        }

        Cache::tags(['posts'])->flush();

        session()->flash('message', 'Update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        Cache::tags(['posts'])->flush();

        return redirect()->route('admin.products.index');
    }
}
