<?php

namespace App\Http\Controllers\Api;

use App\Models\PostMeta;
use Illuminate\Http\Request;
use App\Http\Requests\PostMetaRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostMetaResource;

/**
 * @group Post Metadata
 *
 * APIs for Post Metadata
 */
class PostMetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $postMeta = PostMeta::paginate();

        return PostMetaResource::collection($postMeta);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostMetaRequest $request): PostMeta
    {
        return PostMeta::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(PostMeta $postmeta): PostMeta
    {
        return $postmeta;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostMetaRequest $request, PostMeta $postmeta): PostMeta
    {
        $postmeta->update($request->validated());

        return $postmeta;
    }

    public function destroy(PostMeta $postmeta): Response
    {
        $postmeta->delete();

        return response()->noContent();
    }
}
