<?php

namespace Hoadev\CoreBlog\Models;

use App\Models\User;
use Hoadev\CoreBlog\Traits\Seo\WithSeoPostFunc;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    use HasFactory, SoftDeletes, WithSeoPostFunc;

    protected $table = 'posts';

    protected $fillable = [
        'content',
        'title',
        'excerpt',
        'status',
        'comment_status',
        'password',
        'name',
        'parent_id',
        'type',
        'comment_count'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function postMetas(): HasMany
    {
        return $this->hasMany(PostMeta::class, 'post_id');
    }

/*     public function postMetasArr() {
        return $this->postMetas->pluck('value', 'key');
    } */

    public function terms(): BelongsToMany
    {
        return $this->belongsToMany(Term::class, 'term_relationships', 'post_id', 'term_id', 'id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function getFeatured() {
        return Cache::tags(['posts', 'postMetas', 'medias'])->remember('post:'.$this->name.':featured', 3600, function() {
            return $this->postMetas->where('key', 'featured_image')->load('media')->first();
        });
    }

    public function getFeaturedImageUrl($size = 'thumbnail') {
        if(!$this->getFeatured()) {return;}
        $prefix = '';
        if(mb_substr($this->getFeatured()->media->responsive_images[$size], 0 , 1) !== '/') {$prefix = '/';}
        return $prefix.$this->getFeatured()->media->responsive_images[$size];
    }

    public function getFeaturedImage($size = 'thumbnail', $alt = '', $classes = '', $loading = 'lazy') {
        $featured = $this->getFeatured();
        if(!$featured) {return;}
        return '<img src="'.$featured->media->responsive_images[$size].'"
                    alt="'.$alt.'"
                    width="'.$featured->media->custom_properties['width'].'"
                    height="'.$featured->media->custom_properties['height'].'"
                    srcset="'.$this->getFeaturedImageSrcset().'"
                    loading="'.$loading.'"
                    class="'.$classes.'" />';
    }

    public function getFeaturedImageSrcset() {

        $featured = $this->getFeatured();
        if(!$featured->media->responsive_images) {return null;}

        $srcset = [];

        if(isset($featured->media->responsive_images['thumbnail'])) {
            $srcset[] = '/'.$featured->media->responsive_images['thumbnail'].' 150w';
        }

        if(isset($featured->media->responsive_images['medium'])) {
            $srcset[] = '/'.$featured->media->responsive_images['medium'].' 300w';
        }

        if(isset($featured->media->responsive_images['large'])) {
            $srcset[] = '/'.$featured->media->responsive_images['large'].' 768w';
        }

        if(isset($featured->media->responsive_images['extra'])) {
            $srcset[] = '/'.$featured->media->responsive_images['extra'].' 1024w';
        }

        if(isset($featured->media->responsive_images['wide'])) {
            $srcset[] = '/'.$featured->media->responsive_images['wide'].' 1280w';
        }

        return join(', ', $srcset);
    }


    public function getExcerpt($limit = 50, $append = ' ...') {
        if(!$this->excerpt) {
            return $this->limit_words(strip_tags($this->content), $limit, $append);
        }
        return $this->excerpt;
    }

    function limit_words($words, $limit, $append = ' ...') {
            // Add 1 to the specified limit becuase arrays start at 0
            $limit = $limit+1;
            // Store each individual word as an array element
            // Up to the limit
            $words = explode(' ', $words, $limit);
            // Shorten the array by 1 because that final element will be the sum of all the words after the limit
            array_pop($words);
            // Implode the array for output, and append an ellipse
            $words = implode(' ', $words) . $append;
            // Return the result
            return $words;
    }

    public function getRelatedPosts($limit = 6) {
        $post = $this;

        return Cache::tags(['posts', 'terms', 'taxonomies'])->remember('post_name:'.$this->name.':related_posts', 3600, function() use($post, $limit){
            return Post::with(['postMetas.media'])
                ->whereHas('terms', function (Builder $query) use($post) {
                    $query->whereIn('id', $post->terms->pluck('id'));
                })->whereNot('id', $post->id)->where('status', 'published')->limit($limit)->latest()->get();
        });

    }

    public function getPermalink() {
        if ($this->type === 'post' || $this->type === 'page') {
            return '/'.$this->name;
        }
        $post_slug = config('coreblog.post_types.'.$this->type.'.rewrite') ?? config('coreblog.post_types.'.$this->type.'.type');
        return '/'.$post_slug.'/'.$this->name;
    }

}
