<?php

namespace App\Http\Controllers\Api;

use App\Models\UserMeta;
use Illuminate\Http\Request;
use App\Http\Requests\UserMetaRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserMetaResource;

/**
 * @group User meta data
 *
 * APIs for User meta data
 */
class UserMetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userMeta = UserMeta::paginate();

        return UserMetaResource::collection($userMeta);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserMetaRequest $request): UserMeta
    {
        return UserMeta::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(UserMeta $usermeta): UserMeta
    {
        return $usermeta;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserMetaRequest $request, UserMeta $usermeta): UserMeta
    {
        $usermeta->update($request->validated());

        return $usermeta;
    }

    public function destroy(UserMeta $usermeta): Response
    {
        $usermeta->delete();

        return response()->noContent();
    }
}
