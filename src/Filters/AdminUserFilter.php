<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class AdminUserFilter extends ModelFilter
{
    public function name($name)
    {
        return $this->where('name', $name);
    }


    public function email($email)
    {
        return $this->where('email', $email);
    }
}