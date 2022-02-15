<?php

namespace Ethan\LaravelAdmin\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionGroupResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ];
    }
}