<?php

namespace App\Http\Controllers\User\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Business;
use App\Models\Menu;
use App\Services\BusinessMenuService;
use Illuminate\Http\Request;

class BusinessMenuController extends Controller
{
    public function __construct(private readonly BusinessMenuService $businessMenuService)
    {
    }

    /**
     * Show the form for business time slot.
     */
    public function createIndex(Business $business)
    {
        $menuItems = $this->businessMenuService->getBusinessMenus($business->id);

        return view('user.businesses.businesses-menus-create-index', compact('menuItems'));
    }

    public function editIndex(Business $business){
        $menuItems = $this->businessMenuService->getBusinessMenus($business->id);

        return view('user.businesses.businesses-menus-edit-index', compact('menuItems'));
    }

    /**
     * Store data.
     */
    public function store(StoreMenuRequest $request, Business $business)
    {
        $this->businessMenuService->storeMenu($business, $request->validated());

        if ($request->isMethod('post')){
            return redirect()->route('user.businesses.menus.create.index', $business->id);
        }else{
            // put method
            return redirect()->route('user.businesses.menus.edit.index', $business->id);
        }
    }

    public function edit(Request $request, $businessId, Menu $menu){
        return view('user.businesses.businesses-menus-edit', compact('menu'));
    }

    public function update(UpdateMenuRequest $request, $businessId, Menu $menu){
        $request->validate([
            'redirect' => 'required|string|in:edit,create'
        ]);

        $this->businessMenuService->updateMenu($menu, $request->validated());

        if ($request->redirect === "edit"){
            return redirect()->route('user.businesses.menus.edit.index', $businessId);
        }else{
            return redirect()->route('user.businesses.menus.create.index', $businessId);
        }
    }

    /**
     * Delete Menu Item.
     */
    public function destroy(Request $request, $businessId, Menu $menu)
    {
        $this->businessMenuService->destroyMenu($menu);

        if ($request->redirect_route === "edit"){
            return redirect()->route('user.businesses.menus.edit.index', $businessId);
        }else{
            return redirect()->route('user.businesses.menus.create.index', $businessId);
        }
    }
}
