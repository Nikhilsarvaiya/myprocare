<?php

namespace App\Http\Controllers\Api\User\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Http\Resources\MenuResource;
use App\Models\Business;
use App\Models\Menu;
use App\Services\BusinessMenuService;
use Illuminate\Http\Request;

class BusinessMenuController extends Controller
{
    public function __construct(private readonly BusinessMenuService $businessMenuService)
    {
    }

    public function index(Business $business){
        $menus = $this->businessMenuService->getBusinessMenus($business->id);

        return MenuResource::collection($menus);
    }

    /**
     * Store data.
     */
    public function store(StoreMenuRequest $request, Business $business)
    {
        $menu = $this->businessMenuService->storeMenu($business, $request->validated());

        $menu = $this->businessMenuService->getMenuById($menu->id);

        return new MenuResource($menu);
    }

    public function show($businessId, Menu $menu)
    {
        $menu->load('media');

        return new MenuResource($menu);
    }

    public function update(UpdateMenuRequest $request, Business $business, Menu $menu){
        $menu = $this->businessMenuService->updateMenu($menu, $request->validated());

        $menu = $this->businessMenuService->getMenuById($menu->id);

        return new MenuResource($menu);
    }

    /**
     * Delete Menu Item.
     */
    public function destroy(Request $request, Business $business, Menu $menu)
    {
        $this->businessMenuService->destroyMenu($menu);

        return response()->noContent();
    }
}
