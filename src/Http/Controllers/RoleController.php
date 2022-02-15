<?php

namespace Ethan\LaravelAdmin\Http\Controllers;

use Ethan\LaravelAdmin\Http\Requests\RoleRequest;
use Ethan\LaravelAdmin\Http\Resources\PermissionResource;
use Ethan\LaravelAdmin\Http\Resources\RoleResource;
use Ethan\LaravelAdmin\Models\Role;

class RoleController extends Controller
{
    /**
     * 角色
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $roles = Role::filter(request()->all())->orderBy('created_at', 'desc')->paginate();
        return RoleResource::collection($roles);
    }

    /**
     * 保存
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create(request()->all());

        return response()->json(['data' => $role]);
    }

    /**
     * 更新
     *
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RoleRequest $request, $id)
    {
        $role = Role::query()->find($id);
        $role->fill(request()->all());
        $role->save();

        return response()->json(['data' => new RoleResource($role)]);
    }

    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $role = Role::query()->find($id);
        $role->delete();

        return response()->json();
    }

    /**
     * 角色拥有权限
     *
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function permissions($id)
    {
        $role = Role::query()->findOrFail($id);
        return PermissionResource::collection($role->permissions);
    }

    /**
     * 分配权限
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignPermissions($id)
    {
        $role = Role::query()->findOrFail($id);

        $role->syncPermissions(request()->input('permissions', []));

        return response()->json();
    }

    /**
     * 项目拥有角色
     *
     * @param $guardName
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function guardNameRoles($guardName)
    {
        $roles = Role::query()->where('guard_name', $guardName)->get();

        return RoleResource::collection($roles);
    }
}