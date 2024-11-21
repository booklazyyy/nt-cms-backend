<?php

namespace App\Http\Controllers\Api;

use App\Models\Template;
use Illuminate\Http\Request;
use App\Http\Requests\TemplateRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TemplateResource;

/**
 * @group Templates
 *
 * APIs for Templates
 */
class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $templates = Template::paginate();

        return TemplateResource::collection($templates);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TemplateRequest $request): Template
    {
        return Template::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template): Template
    {
        return $template;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TemplateRequest $request, Template $template): Template
    {
        $template->update($request->validated());

        return $template;
    }

    public function destroy(Template $template): Response
    {
        $template->delete();

        return response()->noContent();
    }
}
