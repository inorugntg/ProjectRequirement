<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PenggunaResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result = [
            'nama' => $this->nama,
            'birth_year' => $this->birth_year,
            'email' => $this->email,
            'phone' => $this->phone,
            'job' => $this->job,
            'skill' => $this->skill,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            // 'job' => new JobResource($this->whenLoaded('job')),
            'Register' => RegisterResource::collection($this->whenLoaded('Register')),
            // 'uploads' => UploadResource::collection($this->whenLoaded('uploads')),
        ];
           return $result;
        // return parent::toArray($request);
    }
}
