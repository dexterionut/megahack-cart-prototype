<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('phone_ids')) {
            $shops = $this->getAvailableShops($request);
        } else {
            $shops = [
                'data' => []
            ];
        }

        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return view('map-page', ['shops' => $shops, 'alphabet' => $alphabet]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function getAvailableShops(Request $request)
    {
        if (!$request->has('phone_ids')) {
            return response(['error' => 'No phone_ids provided'], 403);
        }

        $phoneIds = explode(',', $request->input('phone_ids'));

        $shops = Shop::query()
            ->with(['phones' => function ($q) use ($phoneIds) {
                $q->whereIn('phones.id', $phoneIds);
            }])
            ->whereHas('phones', function ($q) use ($phoneIds) {
                $q->whereIn('phones.id', $phoneIds);
            })
            ->get();

        $filteredShops = $shops->filter(function ($shop) use ($phoneIds) {
            return count($shop->phones) == count($phoneIds);
        });


        $base = [
            'latitudine' => $request->input('lat'),
            'longitudine' => $request->input('lng')
        ];

        $final = [];
        if (count($filteredShops) == 0) {
            $this->getRecursiveShops($shops, $phoneIds, $final);
            $f = $this->normalizeMultiple($base['latitudine'], $base['longitudine'], $final);
            return [
                'type' => 'multiple',
                'data' => array_merge([$base], $f)
            ];

        }
        $f = $this->normalizeSingle($base['latitudine'], $base['longitudine'], $shops);
        return [
            'type' => 'single',
            'data' => [$base, $f]
        ];
    }

    private function getRecursiveShops($shops, $phoneIds, &$final)
    {
        $shopWithHighestCount = $this->getShopWithHighestCount($shops);

        $final = array_merge($final, [$shopWithHighestCount]);

        $bigShopPhoneIds = array_pluck($shopWithHighestCount->phones, 'id');
        $remainingPhoneIds = array_diff($phoneIds, $bigShopPhoneIds);

        $shopsWithRestOfPhones = Shop::query()
            ->with(['phones' => function ($q) use ($remainingPhoneIds) {
                $q->whereIn('phones.id', $remainingPhoneIds);
            }])
            ->whereHas('phones', function ($q) use ($remainingPhoneIds) {
                $q->whereIn('phones.id', $remainingPhoneIds);
            })
            ->get();
        if (count($shopsWithRestOfPhones) > 0) {
            $this->getRecursiveShops($shopsWithRestOfPhones, $remainingPhoneIds, $final);
        }
    }

    private function getShopWithHighestCount(Collection $shops)
    {
        return $shops->sortBy(function ($el) {
            return count($el->phones);
        })[0];
    }

    private function distance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
    }

    private function normalizeSingle($userLat, $userLng, $shops)
    {
        $minShop = NULL;
        $minDistance = 999999999;
        foreach ($shops as $shop) {
            $distance = $this->distance($userLat, $userLng, $shop->latitudine, $shop->longitudine);
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $minShop = $shop;
            }
        }
        return $minShop;
    }

    private function normalizeMultiple($userLat, $userLng, $shops)
    {
        $shopsLen = count($shops);
        $smalls = [
            [
                'latitudine' => $userLat,
                'longitudine' => $userLng,
            ]
        ];
        $nextSmall = $this->normalizeSingle($userLat, $userLng, $shops);
        $smalls[] = $nextSmall;
        $shops = array_filter($shops, function ($el) use ($nextSmall) {
            return $el->id !== $nextSmall->id;
        });
        for ($i = 1; $i < $shopsLen; $i++) {
            $nextSmall = $this->normalizeSingle($nextSmall->latitudine, $nextSmall->longitudine, $shops);
            $smalls[] = $nextSmall;
            $shops = array_filter($shops, function ($el) use ($nextSmall) {
                return $el->id !== $nextSmall->id;
            });
        }
        array_shift($smalls);
        return $smalls;
    }
}
