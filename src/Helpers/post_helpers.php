<?php

use CopyaPost\Eloquent\Post;

function prev_post($id)
{
    return Post::where('id', '<', $id)->whereNotNull('published_at')->orderBy('created_at','desc')->first();
}

function next_post($id)
{
    return Post::where('id', '>', $id)->whereNotNull('published_at')->orderBy('created_at','asc')->first();
}