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

    public function terms(): BelongsToMany
    {
        return $this->belongsToMany(Term::class, 'term_relationships');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getFeatured() {
        return $this->postMetas()->where('key', 'featured_image')->with('media')->first();
    }

    public function getRelatedPosts() {
        $post = $this;
        return Post::whereHas('terms', function (Builder $query) use($post) {
            $query->whereIn('id', $post->terms->pluck('id'));
        })->whereNot('id', $post->id)->get();
    }

}
