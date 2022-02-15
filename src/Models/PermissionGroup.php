<?php

namespace Ethan\LaravelAdmin\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    use  Filterable;

    protected $guarded = [
        'id'
    ];

    public function permission()
    {
        return $this->hasMany(Permission::class, 'pg_id');
    }
}
