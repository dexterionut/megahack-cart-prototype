<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MapController extends Controller
{
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
//
        if (count($filteredShops) == 0) {
            $shopWithHighestCount = $this->getShopWithHighestCount($shops);
            
        }

        return $filteredShops;
    }

    private function getShopWithHighestCount(Collection $shops)
    {
        return $shops->sortBy(function ($el) {
            return count($el->phones);
        })[0];
    }
}
