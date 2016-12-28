<?php

namespace CopyaPost\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use CopyaCategory\Eloquent\Category;


class PostCategory extends Category
{
    protected $table = 'categories';

    public function posts()
    {
        return $this->belongsToMany('CopyaPost\Eloquent\Post', 'category_post', 'category_id', 'post_id');
    }

}
