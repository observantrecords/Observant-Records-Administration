<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->track_id,
            'api_path' => '/track/' . $this->track_id,
            'disc_num' => $this->track_disc_num,
            'track_num' => $this->track_track_num,
            'song_title' => $this->song->song_title,
            'alias' => $this->track_alias,
            'visible' => $this->track_is_visible,
            'release' => $this->release->release_catalog_num,
            'album' => $this->release->album->album_title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
