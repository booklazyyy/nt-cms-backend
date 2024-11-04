<?php

namespace App\Http\Controllers\Api;

use App\Models\Block;
use Illuminate\Http\Request;
use App\Http\Requests\BlockRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlockResource;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $blocks = Block::paginate();

        return BlockResource::collection($blocks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlockRequest $request): Block
    {
        return Block::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Block $block): Block
    {
        return $block;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlockRequest $request, Block $block): Block
    {
        $block->update($request->validated());

        return $block;
    }

    public function destroy(Block $block): Response
    {
        $block->delete();

        return response()->noContent();
    }
}
