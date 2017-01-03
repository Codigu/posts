<?php

namespace CopyaPost\Http\Controllers\FrontEnd\Categories;

use Copya\Http\Controllers\Controller as BaseController;
use CopyaPost\Eloquent\PostCategory;

class PostsController extends BaseController
{
    public function index($category_slug)
    {

        $category = PostCategory::findBySlug($category_slug);
        $category = $category->load('posts');

        return view('vendor.copya.front.posts.categories', ['category' => $category])->withShortcodes();

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
                return response()->json(['deleted' => true]);
            } else {
                Post::destroy($id);
                return $this->item($post, new PostTransformer);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
