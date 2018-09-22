<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(Request $request)
    {
        $shops = $this->getAvailableShops($request);
        return view('map-page', ['shops' => $shops]);
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

        $final = [];
        if (count($filteredShops) == 0) {
            $this->getRecursiveShops($shops, $phoneIds, $final);
            return [
                'type' => 'multiple',
                'data' => $final
            ];

        }

        return [
            'type' => 'single',
            'data' => $shops
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
}
