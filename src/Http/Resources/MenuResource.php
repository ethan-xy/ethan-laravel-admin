<?php

namespace Ethan\LaravelAdmin\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'icon' => $this->icon,
            'uri' => $this->uri,
            'is_link' => $this->is_link,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at
        ];
    }
}