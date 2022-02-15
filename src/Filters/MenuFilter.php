<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class MenuFilter extends ModelFilter
{
    public function guardName($guardName)
    {
        return $this->where('guard_name', $guardName);
    }
}