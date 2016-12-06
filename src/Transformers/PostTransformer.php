<?php

namespace CopyaPost\Transformers;

use League\Fractal\TransformerAbstract;
use CopyaPost\Eloquent\Post;
use Storage;

class PostTransformer extends TransformerAbstract
{
    public function transform(Post $post)
    {
        return [
            'id' => (int) $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'content' => $post->content,
            'featured_image' => Storage::url($post->featured_image),
            'published_at' => $post->published_at,
            'deleted_t' => $post->deleted_at,
        ];
    }
}