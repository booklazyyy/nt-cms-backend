<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;


class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Default Resource
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'organization_id' => $this->organization_id,
            'type' => $this->type,
            'parent_id' => $this->parent_id,
            'slug' => $this->slug,
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'data_json' => $this->data_json,
            'content' => $this->content,
            'custom_css' => $this->custom_css,
            'custom_js' => $this->custom_js,
            'language' => $this->language,
            'status' => $this->status,
            'guid' => $this->guid,
            'menu_order' => $this->menu_order,
            'ordered' => $this->ordered,
            'mime_type' => $this->mime_type,
            'published_at' => $this->published_at,
            'published_by' => $this->published_by,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by
        ];
    }
}
