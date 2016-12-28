<?php

use CopyaPost\Eloquent\Post;

function prev_post($id)
{
    return Post::where('id', '>', $this->id)->orderBy('id','desc')->first();
}

function next_post($id)
{
    return Post::where('id', '<', $this->id)->orderBy('id','asc')->first();
}