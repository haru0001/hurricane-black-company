<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Eloquent\Post
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquent\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquent\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquent\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquent\Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquent\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquent\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquent\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquent\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquent\Post whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Eloquent\User $author
 */
class Post extends Model
{
    protected $fillable = [
        'title', 'body', 'name', 'user_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];

    public function isWrittenBy(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Eloquent\Comment');
    }

    public function favorites()
    {
        return $this->hasMany('App\Eloquent\Favorite');
    }

    public function getPosts($count, $orderBy = ['id', 'DESC'])
    {
        return Post::orderBy($orderBy[0], $orderBy[1])->take($count)->get();
    }

    public function getAllPosts($orderBy = ['id', 'DESC'])
    {
        return Post::orderBy($orderBy[0], $orderBy[1])->get()->all();
    }

    public function getAllPostsWithCommentsFavorite($count, $orderBy = ['id', 'DESC'])
    {
        return Post::withCount('favorites')
            ->withCount('comments')
            ->orderBy($orderBy[0], $orderBy[1])
            ->take($count)
            ->get();
    }

    public function getAllPostsWithCommentsFavoriteOrderByFavoriteCount($count, $orderBy = ['id', 'DESC'])
    {
        return Post::withCount('favorites')
            ->withCount('comments')
            ->orderBy('favorites_count', 'DESC')
            ->orderBy($orderBy[0], $orderBy[1])
            ->take($count)
            ->get();
    }

    public function getPostInfo($postId)
    {
        return Post::findOrFail($postId);
    }

    public function createPost(array $formData)
    {
        return Post::create($formData);
    }
}
