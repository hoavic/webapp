<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Models\Post;
use Hoadev\CoreBlog\Models\Taxonomy;
use Hoadev\CoreBlog\Models\Term;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermalinkController extends Controller
{
    public function single($slug)
    {
/*         $term = Term::where('taxonomy', 'category')
                    ->where('slug', $slug)
                    ->first(); */

        $term = Term::whereHas('taxonomy', function (Builder $query) {
                        $query->where('taxonomy', 'category')
                                ->where('parent_id', null);;
                    })
                    ->where('slug', $slug)
                    ->first();

        if($term) {
            return view('coreblog::guest.term.default', [
                'term' => $term,
                'posts' => $term->posts()->where('status', 'published')->get()
            ]);
        }

        $post = Post::with(['terms'])->whereIn('type', ['post', 'page'])
                        ->where('name', $slug)
                        ->first();

        if ($post) {
/*             return Inertia::render('CoreBlog/Admin/Post/Show', [
                'post' => $post
            ]); */

            return view('coreblog::guest.post.default', [
                'post' => $post,
                'relatedPosts' => $post->getRelatedPosts()
            ]);
        }

        return redirect()->route('home');
    }

    public function post($type, $name)
    {

        if($type === 'post' || $type === 'page') {return redirect()->route('permalink.single', $name); }

        $post = Post::with(['terms'])->where('type', $type)
                        ->where('name', $name)
                        ->first();

        if ($post) {
            return Inertia::render('CoreBlog/Admin/Post/Show', [
                'post' => $post
            ]);
        }

        return redirect()->route('home');
    }

    public function term($type, $slug)
    {

        if($type === 'category') {return redirect()->route('permalink.single', $slug); }


        $term = Term::whereHas('taxonomy', function (Builder $query) use($type) {
                            $query->where('taxonomy', $type)
                                    ->where('parent_id', null);
                        })
                        ->where('slug', $slug)
                        ->first();

        if($term) {
            return view('coreblog::guest.term.default', [
                'term' => $term,
                'posts' => $term->posts()->where('status', 'published')->get()
            ]);
        }

        return redirect()->route('home');
    }

    public function termHasParent($type, $parent, $slug)
    {

        if($type === 'category') {return redirect()->route('permalink.single', $slug); }

        $term = Term::whereHas('taxonomy', function (Builder $query) use ($type) {
                            $query->where('taxonomy', $type);
                        })
                        ->where('slug', $slug)
                        ->first();
        /* dd($term->parseSlug()); */
        if($term && $term->parseSlug() === '/'.$parent.'/'.$slug) {
            return view('coreblog::guest.term.default', [
                'term' => $term,
                'posts' => $term->posts()->where('status', 'published')->get()
            ]);
        }

        return redirect()->route('home');
    }

    public function categoryHasParent($parent, $slug)
    {


        $term = Term::whereHas('taxonomy', function (Builder $query) {
                            $query->where('taxonomy', 'category');
                        })
                        ->where('slug', $slug)
                        ->first();
        /* dd($term->parseSlug()); */


        if($term && $term->parseSlug() === '/'.$parent.'/'.$slug) {
            return view('coreblog::guest.term.default', [
                'term' => $term,
                'posts' => $term->posts()->where('status', 'published')->get()
            ]);
        }

        return redirect()->route('home');
    }

    public function termHasGrand($type, $grand, $parent, $slug)
    {

        if($type === 'category') {return redirect()->route('permalink.single', $slug); }

        $term = Term::whereHas('taxonomy', function (Builder $query) use ($type) {
                            $query->where('taxonomy', $type);
                        })
                        ->where('slug', $slug)
                        ->first();
        /* dd($term->parseSlug()); */
        if($term && $term->parseSlug() === '/'.$grand.'/'.$parent.'/'.$slug) {
            return view('coreblog::guest.term.default', [
                'term' => $term,
                'posts' => $term->posts()->where('status', 'published')->get()
            ]);
        }

        return redirect()->route('home');
    }

    public function categoryHasGrand($grand, $parent, $slug)
    {

        $term = Term::whereHas('taxonomy', function (Builder $query) {
                            $query->where('taxonomy', 'category');
                        })
                        ->where('slug', $slug)
                        ->first();
        /* dd($term->parseSlug()); */
        if($term && $term->parseSlug() === '/'.$grand.'/'.$parent.'/'.$slug) {
            return view('coreblog::guest.term.default', [
                'term' => $term,
                'posts' => $term->posts()->where('status', 'published')->get()
            ]);
        }

        return redirect()->route('home');
    }

}
