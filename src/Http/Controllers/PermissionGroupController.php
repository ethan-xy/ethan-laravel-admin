<?php

namespace Ethan\LaravelAdmin\Http\Controllers;

use Ethan\LaravelAdmin\Http\Requests\PermissionGroupRequest;
use Ethan\LaravelAdmin\Http\Resources\PermissionGroupResource;
use Ethan\LaravelAdmin\Models\PermissionGroup;

class PermissionGroupController extends Controller
{
    /**
     * 权限组
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $permissionGroups = PermissionGroup::filter(request()->all())->latest()->paginate();
        return PermissionGroupResource::collection($permissionGroups);
    }

    /**
     * 保存
     *
     * @param PermissionGroupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PermissionGroupRequest $request)
    {
        PermissionGroup::create(request()->all());

        return response()->json();
    }

    /**
     * 更新
     *
     * @param PermissionGroupRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PermissionGroupRequest $request, $id)
    {
        $permissionGroup = PermissionGroup::query()->find($id);
        $permissionGroup->fill(request()->all());
        $permissionGroup->save();

        return response()->json(['data' => new PermissionGroupResource($permissionGroup)]);
    }

    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $permissionGroup = PermissionGroup::query()->find($id);
        $permissionGroup->delete();

        return response()->json();
    }

    /**
     * 全部权限组
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all()
    {
        $permissionGroups = PermissionGroup::latest()->get();
        return PermissionGroupResource::collection($permissionGroups);
    }


    //项目拥有权限
    public function guardNameForPermissions($guardName)
    {
        $permissionGroups = PermissionGroup::query()
            ->with(['permission' => function ($query) use ($guardName) {
                $query->where('guard_name', $guardName);
            }])
            ->get()->filter(function ($item) {
                //存在权限
                return count($item->permission) > 0;
            });

        return response()->json([
            'data' => array_values($permissionGroups->toArray())
        ]);
    }
}