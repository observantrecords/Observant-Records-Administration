<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->album_id,
            'api_path' => '/album/' . $this->album_id,
            'title' => $this->album_title,
            'alias' => $this->album_alias,
            'order' => $this->album_order,
            'release_date' => $this->album_release_date,
            'visible' => $this->album_is_visible,
            'format' => $this->format->format_alias,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'artist' => $this->artist->artist_display_name,
            'primary_release' => new ReleaseResource($this->whenLoaded('primary_release')),
            'releases' => new ReleaseCollection($this->whenLoaded('releases')),
        ];
    }
}
