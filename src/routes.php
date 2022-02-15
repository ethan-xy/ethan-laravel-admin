<?php

Route::prefix('api')
    ->middleware('api')
    ->group(function () {
        Route::post("auth/login", [\Ethan\LaravelAdmin\Http\Controllers\AuthController::class, 'authenticate'])->name('login');

        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::post("auth/logout", [\Ethan\LaravelAdmin\Http\Controllers\AuthController::class, 'logout'])->name('logout');

            Route::group(['middleware' => ['ethan.permission']], function () {
                Route::resource('admin-user', \Ethan\LaravelAdmin\Http\Controllers\AdminUserController::class);
                Route::get('admin-user-roles/{id}', [\Ethan\LaravelAdmin\Http\Controllers\AdminUserController::class, 'userRoles'])->name('admin-user.roles');
                Route::put('admin-user-assign-roles/{id}', [\Ethan\LaravelAdmin\Http\Controllers\AdminUserController::class, 'assignRoles'])->name('admin-user.assign-roles');

                Route::resource('role', \Ethan\LaravelAdmin\Http\Controllers\RoleController::class);
                Route::get('role-permissions/{id}', [\Ethan\LaravelAdmin\Http\Controllers\RoleController::class, 'permissions'])->name('role.permissions');
                Route::put('role-assign-permissions/{id}', [\Ethan\LaravelAdmin\Http\Controllers\RoleController::class, 'assignPermissions'])->name('role.assign-permissions');
                Route::get('guard-name-roles/{guardName}', [\Ethan\LaravelAdmin\Http\Controllers\RoleController::class, 'guardNameRoles'])->name('role.guard-name-roles');

                Route::resource('permission', \Ethan\LaravelAdmin\Http\Controllers\PermissionController::class);
                Route::get('permission-user-all', [\Ethan\LaravelAdmin\Http\Controllers\PermissionController::class, 'userAllPermissions'])->name('permission.user-all-permissions');

                Route::resource('permission-group', \Ethan\LaravelAdmin\Http\Controllers\PermissionGroupController::class);
                Route::get('permission-group-all', [\Ethan\LaravelAdmin\Http\Controllers\PermissionGroupController::class, 'all'])->name('permission-group.all');
                Route::get('guard-name-for-permissions/{guardName}', [\Ethan\LaravelAdmin\Http\Controllers\PermissionGroupController::class, 'guardNameForPermissions'])
                    ->name('permission-group.guard-name-for-permission');

                Route::resource('menu', \Ethan\LaravelAdmin\Http\Controllers\MenuController::class);
                Route::get('menu-my', [\Ethan\LaravelAdmin\Http\Controllers\MenuController::class, 'my'])->name('menu.my');
            });
        });
    });

