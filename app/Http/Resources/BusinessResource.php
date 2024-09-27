<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        $arrayData = [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "business_type_id" => $this->business_type_id,
            "restaurant_type_id" => $this->restaurant_type_id,
            "food_type_id" => $this->food_type_id,
            "name" => $this->name,
            "about" => $this->about,
            "address" => $this->address,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "phone" => $this->phone,
            "website_link" => $this->website_link,
            "facebook_link" => $this->facebook_link,
            "instagram_link" => $this->instagram_link,
            "twitter_link" => $this->twitter_link,
            "youtube_link" => $this->youtube_link,
            "tiktok_link" => $this->tiktok_link,
            "uber_link" => $this->uber_link,
            "doordash_link" => $this->doordash_link,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "step_completed" => $this->step_completed,
            "total_steps" => $this->total_steps,
            'user' => $this->whenLoaded('user', function () {
                return $this->user;
            }),
            'media' => $this->whenLoaded('media', function () {
                return MediaResource::collection($this->media);
            }),
            'opening_hours' => $this->whenLoaded('openingHours', function () {
                return $this->openingHours;
            }),
            'business_type' => $this->whenLoaded('businessType', function () {
                return $this->businessType;
            }),
        ];

        // show products only when business not sell food beverages
        if ($this->businessType->sell_food_beverage === 0){
            $arrayData['products'] = $this->whenLoaded('products', function (){
                return $this->products;
            });
        }

        // show menu only when business sell food beverages
        if ($this->businessType->sell_food_beverage === 1){
            $arrayData['menus'] = $this->whenLoaded('menus', function (){
                return $this->menus;
            });

            $arrayData['restaurant_type'] = $this->whenLoaded('restaurantType', function (){
                return $this->restaurantType;
            });

            $arrayData['food_type'] = $this->whenLoaded('foodType', function (){
                return $this->foodType;
            });
        }

        return $arrayData;
    }
}
