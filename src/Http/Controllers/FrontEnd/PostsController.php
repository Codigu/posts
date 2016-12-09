<?php

namespace CopyaPost\Http\Controllers\FrontEnd;

use Copya\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use CopyaPost\Eloquent\Post;

class PostsController extends BaseController
{
    public function index()
    {

    }

    public function show($slug)
    {
        $post = Post::findBySlug($slug);
        if (!$post || $post->published_at == null) {
            return abort(404);
        }

        return view('vendor.copya.front.posts.show', array('post' => $post));
    }
}
