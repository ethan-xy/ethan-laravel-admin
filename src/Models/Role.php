<?php

namespace Ethan\LaravelAdmin\Models;

use EloquentFilter\Filterable;

class Role extends \Spatie\Permission\Models\Role
{
    use Filterable;
}
