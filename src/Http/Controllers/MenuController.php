<?php

namespace Ethan\LaravelAdmin\Http\Controllers;

use Ethan\LaravelAdmin\Http\Requests\MenuRequest;
use Ethan\LaravelAdmin\Http\Resources\MenuResource;
use Ethan\LaravelAdmin\Models\Menu;
use Auth;

class MenuController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $menus = Menu::filter(request()->all())
            ->where('guard_name', request()->input('guard_name', 'admin'))
            ->orderBy('sort', 'desc')
            ->get();

        return response()->json(['data' => make_tree($menus->toArray())]);
    }

    /**
     * 保存
     *
     * @param MenuRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MenuRequest $request)
    {
        Menu::create(request()->all());

        return response()->json();
    }

    /**
     * 用户拥有菜单
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function my()
    {
        $userPermissions = Auth::user()->getAllPermissions()->pluck('name');
        $menus = Menu::query()
            ->where('guard_name', 'admin')
            ->orderBy('sort', 'desc')
            ->get()
            ->filter(function ($item) use ($userPermissions) {
                return !$item->permission_name || $userPermissions->contains($item->permission_name);
            });

        return response()->json(['data' => make_tree($menus->toArray())]);
    }


    public function update(MenuRequest $request, $id)
    {
        $menu = Menu::query()->findOrFail($id);

        if (request('p_id') == $id) {
            return response('不可以选择自身为父级', 422);
        }

        $menu->update(request()->all());

        return response()->json();
    }

    /**
     * @param $id
     * @return MenuResource
     */
    public function show($id)
    {
        return new MenuResource(Menu::query()->findOrFail($id));
    }

    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Ethan\LaravelAdminlication|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::query()->findOrFail($id);

        if (Menu::query()->where('p_id', $menu->id)->count()) {
             return response('请先删除子菜单', 422);
        }

        $menu->delete();

        return response()->json();
    }
}