<?php

namespace Ethan\LaravelAdmin\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'display_name' => $this->display_name,
            'pg_id' => $this->pg_id,
            'sort' => $this->sort,
            'description' => $this->description,
            'created_at' => (string)$this->created_at,
            'updated_at' =>  (string)$this->updated_at,
            'created_name' => $this->created_name,
            'updated_name' => $this->updated_name,
        ];
    }
}