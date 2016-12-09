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
        return $this->collection(Post::withTrashed()->get(), new PostTransformer);
    }

    public function show($id)
    {
        $post = Post::withTrashed()->find($id);

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

    public function update(PostRequest $request, $id)
    {
        try {
            $post = Post::withTrashed()->find($id);

            if($request->has('action')){
                if($request->get('action') == 'restore'){
                    $post->restore();
                }
            } else {
                $data = $request->all();

                $post->title = $data['title'];
                $post->content = $data['content'];
                $post->featured_image = ($request->has('featured_image')) ? $data['featured_image'] : null;
                if ($request->get('status') == 'published') {
                    $post->published_at = Carbon::now();
                }

                $post->save();
            }

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return $this->item($post, new PostTransformer);
    }

    public function destroy($id)
    {
        try{
            $post = Post::withTrashed()->find($id);
            if($post->trashed()){
                $post->forceDelete();
            } else {
                Post::destroy($id);
            }

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return $this->item($post, new PostTransformer);
    }
}
