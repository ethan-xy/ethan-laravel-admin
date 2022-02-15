<?php

namespace Ethan\LaravelAdmin\Http\Controllers;

use Ethan\LaravelAdmin\Http\Requests\AdminUserRequest;
use Ethan\LaravelAdmin\Http\Resources\AdminUserResource;
use Ethan\LaravelAdmin\Http\Resources\RoleResource;
use Ethan\LaravelAdmin\Models\AdminUser;

class AdminUserController extends Controller
{
    public function index()
    {
        $adminUsers = AdminUser::filter(request()->all())->paginate();
        return AdminUserResource::collection($adminUsers);
    }

    /**
     * @param AdminUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AdminUserRequest $request)
    {
        $data = request()->all();
        $data['password'] = bcrypt($data['password']);

        $adminUser = AdminUser::create($data);

        return response()->json(['data' => $adminUser]);
    }

    /**
     * @param AdminUserRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AdminUserRequest $request, $id)
    {
        $adminUser = AdminUser::findOrFail($id);

        $data = request()->all();
        $data['status'] = request('status') ? 1 : 2;
        unset($data['password']);

        $adminUser->fill($data);
        $adminUser->save();

        return response()->json(['data' => new AdminUserResource($adminUser)]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adminUser = AdminUser::findOrFail($id);

        $adminUser->delete();

        return response();
    }

    /**
     * 管理员拥有角色
     *
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function userRoles($id)
    {
        $adminUser = AdminUser::query()->findOrFail($id);

        return RoleResource::collection($adminUser->roles);
    }

    /**
     * 分配角色
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignRoles($id)
    {
        $adminUser = AdminUser::query()->findOrFail($id);

        $adminUser->syncRoles(request()->input('roles', []));

        return response()->json();
    }
}