<?php

namespace Ethan\LaravelAdmin\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class AdminUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Filterable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status'
    ];

    protected $guard_name = 'admin';

    public $table = 'admin_users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static $status = [
        1 => "启用",
        2 => "禁用"
    ];

    public function getStatusNameAttribute()
    {
        return data_get(self::$status, $this->status);
    }

}
