<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use File;

class UploadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $link = null;
        if (!empty($this->path)) {
            if (File::exists(storage_path('app/' . $this->path))) {
                $link = url('api/show_file/candidate/' . $this->id);
            }
        }

        $result = [
            'id' => $this->id,
            'name' => $this->name,
            'path' => $this->path,
            'size' => $this->size,
            'ext' => $this->ext,
            'is_image' => $this->is_image,
            'link' => $link,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'candidate' => new CandidateResource($this->whenLoaded('candidate')),
        ];

        return $result;
    }
}
