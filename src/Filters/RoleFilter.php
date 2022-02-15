<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class RoleFilter extends ModelFilter
{
    public function name($name)
    {
        return $this->where('name', $name);
    }

    public function guardName($guardName)
    {
        return $this->where('guard_name', $guardName);
    }
}