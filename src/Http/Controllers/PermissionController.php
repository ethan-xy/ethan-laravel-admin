<?php

namespace Ethan\LaravelAdmin\Http\Controllers;

use Ethan\LaravelAdmin\Http\Requests\PermissionRequest;
use Ethan\LaravelAdmin\Http\Resources\PermissionResource;
use Ethan\LaravelAdmin\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * 权限
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $permissions = Permission::filter(request()->all())->orderBy('created_at', 'desc')->paginate();
        return PermissionResource::collection($permissions);
    }

    /**
     * 保存
     *
     * @param PermissionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PermissionRequest $request)
    {
        Permission::create(array_merge(request()->all(), ['created_name' => Auth::user()->name]));

        return response()->json();
    }

    /**
     * 更新
     *
     * @param PermissionRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PermissionRequest $request, $id)
    {
        $permission = Permission::query()->find($id);
        $permission->fill(array_merge(request()->all(), ['updated_name' => Auth::user()->name]));
        $permission->save();

        return response()->json(['data' => new PermissionResource($permission)]);
    }

    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $permission = Permission::query()->find($id);
        $permission->delete();

        return response()->json();
    }

    /**
     * 用户拥有权限
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userAllPermissions()
    {
        return response()->json(['data' => Auth::user()->getAllPermissions()->pluck('name')]);
    }
}