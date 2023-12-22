<?php

namespace Hoadev\CoreBlog\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
class Post extends Model
{
    use HasFactory;

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
        return $this->hasMany(PostMeta::class);
    }

/*     public function postMetasArr() {
        return $this->postMetas->pluck('value', 'key');
    } */

    public function terms(): BelongsToMany
    {
        return $this->belongsToMany(Term::class, 'term_relationships');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getFeatured() {
        return $this->postMetas->where('key', 'featured_image')->load('media')->first();
    }

    public function getFeaturedImageUrl($size = 'thumbnail') {
        if(!$this->getFeatured()) {return;}
        return $this->getFeatured()->media->responsive_images[$size];
    }

    public function getExcerpt($limit = 50) {
        if(!$this->excerpt) {
            return $this->limit_words(strip_tags($this->content), $limit);
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

    public function getRelatedPosts() {
        $post = $this;
        return Post::whereHas('terms', function (Builder $query) use($post) {
            $query->whereIn('id', $post->terms->pluck('id'));
        })->whereNot('id', $post->id)->get();
    }

}
