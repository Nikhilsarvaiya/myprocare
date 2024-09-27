<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleMapsService
{
    public function getLatLongFromAddress($address): ?object
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $address,
            'key' => config('services.google.key'),
        ]);

        if ($response->status() === 200 && isset($response->object()->results[0]->geometry->location)) {
            $location = $response->object()->results[0]->geometry->location;

            return (object)[
                'latitude' => $location->lat,
                'longitude' => $location->lng,
            ];
        }

        return null;
    }
}
