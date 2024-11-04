<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = Post::paginate();
        if ($request->has('type')) {
            $type = $request->string('type')->trim();
            // $posts = Post::where('type', $type)->paginate();
            // if ($request->has('orderBy')) {
            $order_by = $request->string('orderBy')->trim();
            $order = $request->string('order')->trim();
            $posts = Post::where('type', $type)
                ->orderBy($order_by, $order)
                ->paginate();
            // }
        }

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request): Post
    {
        return Post::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): Post
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post): Post
    {
        $post->update($request->validated());

        return $post;
    }

    public function destroy(Post $post): Response
    {
        $post->delete();

        return response()->noContent();
    }
}
