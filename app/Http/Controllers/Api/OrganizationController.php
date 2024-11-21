<?php

namespace App\Http\Controllers\Api;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Requests\OrganizationRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;

/**
 * @group Organizations
 *
 * APIs for Organization
 */
class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $organizations = Organization::paginate();

        return OrganizationResource::collection($organizations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrganizationRequest $request): Organization
    {
        return Organization::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization): Organization
    {
        return $organization;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrganizationRequest $request, Organization $organization): Organization
    {
        $organization->update($request->validated());

        return $organization;
    }

    public function destroy(Organization $organization): Response
    {
        $organization->delete();

        return response()->noContent();
    }
}
