<?php

namespace CopyaPost\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;
    use SoftDeletes;

    protected $table = 'posts';
    protected $dates = ['deleted_at'];
    protected $fillable = ['title', 'content', 'featured_image', 'published_at'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
