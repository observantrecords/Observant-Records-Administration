<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AlbumResource;

class ArtistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->artist_id,
            'api_path' => '/artist/' . $this->artist_id,
            'display_name' => $this->artist_display_name,
            'alias' => $this->artist_alias,
            'url' => $this->artist_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'albums' => AlbumResource::collection($this->albums),
        ];
    }
}
