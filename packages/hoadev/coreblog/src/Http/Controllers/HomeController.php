<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Classes\MetaTags;
use Hoadev\CoreBlog\Models\Post;
use Hoadev\CoreBlog\Models\Taxonomy;
use Hoadev\CoreShop\Models\Product;

class HomeController extends Controller
{
    public function default()
    {
        $meta_tags = new MetaTags();
        $meta_tags->importManual(config('app.title'), 'Sia Ginseng không chỉ cung cấp sản phẩm mà còn tạo ra những trải nghiệm tuyệt vời cho khách hàng.', config('app.url'));

        return view('coreblog::guest.home', [
            'newestPosts' => Post::with(['postMetas.media'])->where('status', 'published')->where('type', 'post')->latest()->limit(10)->get(),
            'categories' => Taxonomy::with(['term', 'ancestors'])->where('taxonomy', 'category')->get(),
            'contentStyle' => 'no-sidebar',
            'meta_tags' => $meta_tags,
            'products' => Product::with(['postMetas.media', 'variants'])->where('status', 'published')->where('type', 'product')->latest()->limit(3)->get(),
        ]);
    }

}
