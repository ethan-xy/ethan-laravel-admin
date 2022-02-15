<?php

namespace Ethan\LaravelAdmin\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use Filterable;

    protected $guarded = [
        'id'
    ];
}
