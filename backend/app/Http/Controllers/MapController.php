<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
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
        if (!$request->has('sku_ids')) {
            return response(['error' => 'No sku_ids provided'], 403);
        }

        $skIds = explode(',', $request->input('sku_ids'));

        $shops = Shop::query()
            ->whereHas('phones', function ($q) use ($skIds) {
                $q->whereIn('phones.sku_id', $skIds);
            })
            ->get();

        return $shops;
    }
}
