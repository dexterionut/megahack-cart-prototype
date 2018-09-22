<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $phones = [];
        if ($request->has('phone_ids')) {
            $phones = Phone::query()
                ->whereIn('id', explode(',', $request->input('phone_ids')))
                ->get();
        }

        return view('cart', ['phones' => $phones]);
    }
}
