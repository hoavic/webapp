<?php
namespace Hoadev\CoreBlog\Http\Controllers;

use Illuminate\Http\Request;
use Hoadev\CoreBlog\CoreBlog;

class CoreBlogController
{
    public function __invoke(CoreBlog $coreBlog) {
        $quote = $coreBlog->justDoIt();

        return view('coreblog::index', compact('quote'));
    }
}
