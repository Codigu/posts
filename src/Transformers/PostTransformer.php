<?php

namespace CopyaPost\Transformers;

use League\Fractal\TransformerAbstract;
use CopyaPost\Eloquent\Post;
use Storage;

class PostTransformer extends TransformerAbstract
{
    public function transform(Post $post)
    {
<<<<<<< HEAD
        $status = '';

        if($post->deleted_at){
            $status = 'trashed';
        } else if($post->published_at){
            $status = 'published';
        } else {
            $status = 'draft';
        }

=======
>>>>>>> dcd9dd4007d0d0e4125aab954f13ea73807b102f
        return [
            'id' => (int) $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'content' => $post->content,
<<<<<<< HEAD
            //'featured_image' => Storage::url($post->featured_image),
            'featured_image' => ($post->image_filename) ? url('images/small/'.$post->image_filename) : '',
            'image_path' => $post->featured_image,
            'status' => $status,
             'published_at' => $post->published_at,
            'deleted_at' => $post->deleted_at,
=======
            'featured_image' => Storage::url($post->featured_image),
            'published_at' => $post->published_at,
            'deleted_t' => $post->deleted_at,
>>>>>>> dcd9dd4007d0d0e4125aab954f13ea73807b102f
        ];
    }
}