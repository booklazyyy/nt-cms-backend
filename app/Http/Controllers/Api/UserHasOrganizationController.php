<?php

namespace App\Http\Controllers\Api;

use App\Models\UserHasOrganization;
use Illuminate\Http\Request;
use App\Http\Requests\UserHasOrganizationRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserHasOrganizationResource;

class UserHasOrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userHasOrganizations = UserHasOrganization::paginate();

        return UserHasOrganizationResource::collection($userHasOrganizations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserHasOrganizationRequest $request): UserHasOrganization
    {
        return UserHasOrganization::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(UserHasOrganization $userHasOrganization): UserHasOrganization
    {
        return $userHasOrganization;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserHasOrganizationRequest $request, UserHasOrganization $userHasOrganization): UserHasOrganization
    {
        $userHasOrganization->update($request->validated());

        return $userHasOrganization;
    }

    public function destroy(UserHasOrganization $userHasOrganization): Response
    {
        $userHasOrganization->delete();

        return response()->noContent();
    }
}
