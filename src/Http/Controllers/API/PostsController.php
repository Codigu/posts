<?php

namespace CopyaPost\Http\Controllers\API;

use Exception;
use CopyaPost\Transformers\PostTransformer;
use Copya\Http\Controllers\API\ApiBaseController;
use CopyaPost\Eloquent\Post;
use CopyaPost\Http\Requests\PostRequest;
use Carbon\Carbon;


class PostsController extends ApiBaseController
{
    public function index()
    {
        return $this->collection(Post::all(), new PostTransformer);
    }

    public function show($id)
    {
        $post = Post::find($id);

        return $this->item($post, new PostTransformer);
    }

    public function store(PostRequest $request)
    {
        try {

            $data = $request->except('status');

            $post = new Post;

            $post->title = $data['title'];
            $post->content = $data['content'];
            $post->featured_image = ($request->has('featured_image')) ? $data['featured_image'] : null;
            if($request->get('status') == 'published'){
                $post->published_at = Carbon::now();
            }

            $post->save();

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return $this->item($post, new PostTransformer);
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::find($id);

            $category->name = $request->name;
            $category->description = $request->description;

            $category->save();

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return $this->item($category, new CategoryTransformer);
    }

    public function destroy($id)
    {
        try{
            Post::destroy($id);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['deleted' => true]);
    }
}
