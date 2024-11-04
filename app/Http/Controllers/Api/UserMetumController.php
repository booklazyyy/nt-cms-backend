<?php

namespace App\Http\Controllers\Api;

use App\Models\UserMetum;
use Illuminate\Http\Request;
use App\Http\Requests\UserMetumRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserMetumResource;

class UserMetumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userMeta = UserMetum::paginate();

        return UserMetumResource::collection($userMeta);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserMetumRequest $request): UserMetum
    {
        return UserMetum::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(UserMetum $userMetum): UserMetum
    {
        return $userMetum;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserMetumRequest $request, UserMetum $userMetum): UserMetum
    {
        $userMetum->update($request->validated());

        return $userMetum;
    }

    public function destroy(UserMetum $userMetum): Response
    {
        $userMetum->delete();

        return response()->noContent();
    }
}
