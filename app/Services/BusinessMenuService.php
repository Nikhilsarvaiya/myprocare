<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Collection;

class BusinessMenuService
{
    public function getBusinessMenus($businessId): Collection
    {
        return Menu::query()
            ->with('media')
            ->where('business_id', $businessId)
            ->latest()
            ->get();
    }

    public function getMenuById($id): Menu
    {
        return Menu::query()
            ->with('media')
            ->find($id);
    }

    public function storeMenu($business, $data)
    {
        $menu = $business->menus()->create($data);

        if (isset($data['image'])) {
            $menu->addMedia($data['image'])->toMediaCollection();
        }

        if ($business->step_completed < 6) {
            $business->update([
                'step_completed' => 6,
            ]);
        }

        return $menu;
    }

    public function updateMenu($menu, $data): Menu
    {
        $menu->update($data);

        if (isset($data['image'])) {
            $menu->clearMediaCollection();

            $menu->addMedia($data['image'])->toMediaCollection();
        }

        return $menu;
    }

    public function destroyMenu($menu): void
    {
        $menu->delete();
    }
}
