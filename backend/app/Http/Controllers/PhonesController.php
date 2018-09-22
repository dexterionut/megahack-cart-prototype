<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PhonesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $phones = Phone::query()
            ->with('shops');

        if ($request->has('nume_produs')) {
            $phones = $phones->where('nume_produs', 'like', '%' . $request->input('nume_produs') . '%');
        }

        if ($request->has('sku_id')) {
            $phones = $phones->where('sku_id', $request->input('sku_id'));
        }

        if ($request->has('producator')) {
            $phones = $phones->where('producator', 'like', '%' . $request->input('producator') . '%');
        }

        if ($request->has('caracteristici_principale')) {
            $phones = $phones->where('caracteristici_principale', 'like', '%' . $request->input('caracteristici_principale') . '%');
        }

        if ($request->has('diagonala_ecran')) {
            $phones = $phones->where('diagonala_ecran', 'like', '%' . $request->input('diagonala_ecran') . '%');
        }

        if ($request->has('camera')) {
            $phones = $phones->where('camera', 'like', '%' . $request->input('camera') . '%');
        }

        if ($request->has('memorie_interna')) {
            $phones = $phones->where('memorie_interna', 'like', '%' . $request->input('memorie_interna') . '%');
        }

        if ($request->has('shop_name')) {
            $word = $request->input('shop_name');
            $phones = $phones->whereHas('shops', function (Builder $q) use ($word) {
                return $q->where('shops.dealer_name', 'like', '%' . $word . '%');
            });
        }


        return $phones->get();
    }

    public function phonesList()
    {
        return view('phones-list');
    }
}
