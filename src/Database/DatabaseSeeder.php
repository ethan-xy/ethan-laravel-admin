<?php

namespace Ethan\LaravelAdmin\Database;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Ethan\LaravelAdmin\Models\AdminUser;
use Ethan\LaravelAdmin\Models\Menu;
use Ethan\LaravelAdmin\Models\PermissionGroup;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    private $permissions = [
        [
            'name' => 'admin-user.index',
            'display_name' => '管理员',
            'guard_name' => 'admin',
            'pg_id' => 1
        ],
        [
            'name' => 'admin-user.store',
            'display_name' => '保存',
            'guard_name' => 'admin',
            'pg_id' => 1
        ],
        [
            'name' => 'admin-user.update',
            'display_name' => '更新',
            'guard_name' => 'admin',
            'pg_id' => 1
        ],
        [
            'name' => 'admin-user.destroy',
            'display_name' => '删除',
            'guard_name' => 'admin',
            'pg_id' => 1
        ],
        [
            'name' => 'role.index',
            'display_name' => '角色',
            'guard_name' => 'admin',
            'pg_id' => 2
        ],
        [
            'name' => 'role.store',
            'display_name' => '保存',
            'guard_name' => 'admin',
            'pg_id' => 2
        ],
        [
            'name' => 'role.update',
            'display_name' => '更新',
            'guard_name' => 'admin',
            'pg_id' => 2
        ],
        [
            'name' => 'role.destroy',
            'display_name' => '删除',
            'guard_name' => 'admin',
            'pg_id' => 2
        ],
        [
            'name' => 'permission.index',
            'display_name' => '权限',
            'guard_name' => 'admin',
            'pg_id' => 4
        ],
        [
            'name' => 'permission.store',
            'display_name' => '保存',
            'guard_name' => 'admin',
            'pg_id' => 4
        ],
        [
            'name' => 'permission.update',
            'display_name' => '更新',
            'guard_name' => 'admin',
            'pg_id' => 4
        ],
        [
            'name' => 'permission.destroy',
            'display_name' => '删除',
            'guard_name' => 'admin',
            'pg_id' => 4
        ],
        [
            'name' => 'menu.index',
            'display_name' => '菜单',
            'guard_name' => 'admin',
            'pg_id' => 3
        ],
        [
            'name' => 'menu.store',
            'display_name' => '保存',
            'guard_name' => 'admin',
            'pg_id' => 3
        ],
        [
            'name' => 'menu.update',
            'display_name' => '更新',
            'guard_name' => 'admin',
            'pg_id' => 3
        ],
        [
            'name' => 'menu.destroy',
            'display_name' => '删除',
            'guard_name' => 'admin',
            'pg_id' => 3
        ],
        [
            'name' => 'permission-group.index',
            'display_name' => '权限组',
            'guard_name' => 'admin',
            'pg_id' => 5
        ],
        [
            'name' => 'permission-group.store',
            'display_name' => '保存',
            'guard_name' => 'admin',
            'pg_id' => 5
        ],
        [
            'name' => 'permission-group.update',
            'display_name' => '更新',
            'guard_name' => 'admin',
            'pg_id' => 5
        ],
        [
            'name' => 'permission-group.destroy',
            'display_name' => '删除',
            'guard_name' => 'admin',
            'pg_id' => 5
        ],
        [
            'name' => 'admin-user.roles',
            'display_name' => '管理员拥有角色',
            'guard_name' => 'admin',
            'pg_id' => 6
        ],
        [
            'name' => 'admin-user.assign-roles',
            'display_name' => '分配角色',
            'guard_name' => 'admin',
            'pg_id' => 6
        ],
        [
            'name' => 'menu.my',
            'display_name' => '用户拥有菜单',
            'guard_name' => 'admin',
            'pg_id' => 6
        ],
        [
            'name' => 'permission.user-all-permissions',
            'display_name' => '用户拥有权限',
            'guard_name' => 'admin',
            'pg_id' => 6
        ],
        [
            'name' => 'permission-group.all',
            'display_name' => '全部权限组',
            'guard_name' => 'admin',
            'pg_id' => 6
        ],
        [
            'name' => 'permission-group.guard-name-for-permission',
            'display_name' => '项目拥有权限',
            'guard_name' => 'admin',
            'pg_id' => 6
        ],
        [
            'name' => 'role.permissions',
            'display_name' => '角色拥有权限',
            'guard_name' => 'admin',
            'pg_id' => 6
        ],
        [
            'name' => 'role.assign-permissions',
            'display_name' => '角色分配权限',
            'guard_name' => 'admin',
            'pg_id' => 6
        ],
        [
            'name' => 'role.guard-name-roles',
            'display_name' => '项目拥有角色',
            'guard_name' => 'admin',
            'pg_id' => 6
        ],
    ];

    public function run()
    {
        //Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $this->createdAdminUser();

        $this->createPermissionGroup();

        $this->createRole();

        $this->createPermission();

        $this->createMenu();

        $this->associateRolePermissions();
    }

    private function createdAdminUser()
    {
        AdminUser::query()->truncate();

        AdminUser::query()->create([
            'name' => 'test',
            'email' => 'test@qq.com',
            'status' => 1,
            'password' => bcrypt(123456), // secret
        ]);
    }


    private function createPermission()
    {
        Permission::query()->delete();

        foreach ($this->permissions as $permission) {
            Permission::create($permission);
        }
    }

    private function createPermissionGroup()
    {
        PermissionGroup::query()->truncate();
        PermissionGroup::insert([
            [
                'id' => 1,
                'name' => '管理员',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id' => 2,
                'name' => '角色',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id' => 3,
                'name' => '菜单',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id' => 4,
                'name' => '权限',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id' => 5,
                'name' => '权限组',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id' => 6,
                'name' => '基础权限',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }

    private function createRole()
    {
        Role::query()->delete();
        Role::create([
            'name' => '管理员',
            'guard_name' => 'admin'
        ]);
    }

    private function createMenu()
    {
        Menu::truncate();
        Menu::insert([
            [
                'id' => 1,
                'p_id' => 0,
                'uri' => 'system-setting',
                'name' => '系统设置',
                'icon' => 'menu',
                'guard_name' => 'admin',
                'permission_name' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'p_id' => 1,
                'uri' => 'admin-user',
                'name' => '管理员',
                'icon' => '',
                'guard_name' => 'admin',
                'permission_name' => 'admin-user.index',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'p_id' => 1,
                'uri' => 'role',
                'name' => '角色',
                'icon' => '',
                'guard_name' => 'admin',
                'permission_name' => 'role.index',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'p_id' => 1,
                'uri' => 'permission',
                'name' => '权限',
                'icon' => '',
                'guard_name' => 'admin',
                'permission_name' => 'permission.index',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'p_id' => 1,
                'uri' => 'menu',
                'name' => '菜单',
                'icon' => '',
                'guard_name' => 'admin',
                'permission_name' => 'menu.index',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 6,
                'p_id' => 1,
                'uri' => 'permission-group',
                'name' => '权限组',
                'icon' => '',
                'guard_name' => 'admin',
                'permission_name' => 'permission-group.index',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }

    private function associateRolePermissions()
    {
        $role = Role::first();

        AdminUser::query()->first()->assignRole($role->name);

        foreach ($this->permissions as $permission) {
            $role->givePermissionTo($permission['name']);
        }
    }
}