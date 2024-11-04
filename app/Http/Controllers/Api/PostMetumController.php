<?php

namespace App\Http\Controllers\Api;

use App\Models\PostMetum;
use Illuminate\Http\Request;
use App\Http\Requests\PostMetumRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostMetumResource;

class PostMetumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $postMeta = PostMetum::paginate();

        return PostMetumResource::collection($postMeta);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostMetumRequest $request): PostMetum
    {
        return PostMetum::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(PostMetum $postMetum): PostMetum
    {
        return $postMetum;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostMetumRequest $request, PostMetum $postMetum): PostMetum
    {
        $postMetum->update($request->validated());

        return $postMetum;
    }

    public function destroy(PostMetum $postMetum): Response
    {
        $postMetum->delete();

        return response()->noContent();
    }
}
