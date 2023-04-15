<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReleaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->release_id,
            'api_path' => '/release/' . $this->release_id,
            'upc_num' => $this->release_upc_num,
            'catalog_num' => $this->release_catalog_num,
            'format' => $this->format->format_alias,
            'alternate_title' => $this->release_alternate_title,
            'alias' => $this->release_alias,
            'label' => $this->release_label,
            'release_date' => $this->release_release_date,
            'visible' => $this->release_is_visible,
            'album' => $this->album->album_title,
            'tracks' => TrackResource::collection($this->whenLoaded('tracks')),
            'ecommerce' => EcommerceResource::collection($this->whenLoaded('ecommerce')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
